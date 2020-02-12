<?php


namespace App\Base;


use App\Lib\PDO_DB;

class BaseModel extends PDO_DB
{

    public $hasOne;
    public $belongsTo;
    public $hasMany;
    public $manyToMany;
    public $alias;

    public $simpleJoin;

    public $sql; // Содержит запрос
    public $Select;
    public $Where;
    public $WhereAnd;
    public $WhereOr;
    public $WhereIn;
    public $WhereLike;
    public $having;

    public $Order;
    public $Group;
    public $Lim;
    public $PagStart;
    public $PagCount;
    public $Pag;

    public $addFields;
    public $findField;
    public $deleteByFields;
    public $activeByFields;

    public function simpleJoin($join)
    {
        $this->simpleJoin .= $join;
        return $this;
    }

    public function hasOne($modelName, $foreign_key, $local_key){
        $this->hasOne[] = [$modelName, $foreign_key, $local_key];
    }
    public function belongsTo($modelName, $foreign_key, $local_key) {
        $this->belongsTo[] = [$modelName, $foreign_key, $local_key];
    }
    public function hasMany($modelName, $foreign_key, $local_key) {
        if(class_exists($modelName))
            $this->hasMany[] = [$modelName, $foreign_key, $local_key];
    }
    public function manyToMany($modelName, $foreign_key, $local_key, $middleTable, $middleTableForeign_key, $middleTableLocal_key) {
        $this->hasMany[] = [$modelName, $foreign_key, $local_key, $middleTable, $middleTableForeign_key, $middleTableLocal_key];
        return $this;
    }

    public function hasManyThrough($modelName, $foreign_key, $local_key, $middleTable, $middleTableForeign_key, $middleTableLocal_key) {
        $this->hasMany[] = [$modelName, $foreign_key, $local_key, $middleTable, $middleTableForeign_key, $middleTableLocal_key];
    }


    public function WhereEqually($f, $s)
    {
        $this->Where = $f . "='" . $s ."' ";
        return $this;
    }


    private function Like($var, $col, $string)
    {
        $string = trim($string);

        if(trim($string, '%') == '' && !preg_match('/(a-zA-ZА-Яа-я0-9)+/', $string))
        {
            return $this;
        }
        $this->$var[$col][] = "$col LIKE '" . rawurldecode(htmlspecialchars($string)). "'";

        return $this;
    }

    public function havingLike($col, $string)
    {
        $this->Like('having', $col, $string);
        return $this;
    }
    public function WhereLike($col, $string)
    {
        $this->Like('WhereLike', $col, $string);
        return $this;
    }


    public function OrderBy($o)
    {
        $this->Order = " ORDER BY " . $o . " ";
        return $this;
    }

    public function GroupBy($o)
    {
        $this->Group = " GROUP BY " . $o . " ";
        return $this;
    }

    // id, < , 2
    public function WhereAnd($f, $o, $s)
    {
        $this->WhereAnd[] = $f . $o . $s;
        return $this;
    }

    public function Limit($f, $l = 0)
    {
        if ($l == 0)
            $this->Lim = " LIMIT " . $f;
        else
            $this->Lim = " LIMIT " . $f . ", " . $l;
        return $this;
    }

    public function SelectWhat($array_selected){
        $selected = array();
        foreach ($array_selected as $name => $item){
            $selected[] = $item . " as " . "'$name'";
        }
        $this->Select = implode(", ", $selected);
        return $this;
    }

    public function Get()
    {
        $sql = "SELECT ";
        if(strlen($this->Select)>0)
            $sql .= $this->Select;
        else
            $sql .= " * ";

        $sql .= " FROM " . $this->table . ' as ' .$this->alias;
        $sql .= $this->simpleJoin;

        $flagWhere = " WHERE ";

        if (strlen($this->Where) > 0) {
            $sql .= $flagWhere . $this->Where;
            $flagWhere = " ";
        }
        if (is_array($this->WhereLike))
        {
            if(strlen($this->Where) > 0)
                $sql .= " AND ";
            $sql .= $flagWhere;
            $flagWhere = " ";

            $where_groups = [];
            foreach ($this->WhereLike as $column => $conditions)
            {
                $where_groups[$column] = ' (' . implode(' OR ', $conditions) . ') ';
            }
            $sql .= implode("\n AND \n", $where_groups);
        }
        else {
            /*if(strlen($this->WhereLike) > 0 || strlen($this->Where) > 0)
                $flagWhere = " WHERE ";
            else
                $flagWhere = " ";*/
            
            if (is_array($this->WhereAnd)) {
                $sql .= $flagWhere . '(' . implode(") AND (", $this->WhereAnd) . ')';
                $flagWhere = "";
            }
            if (is_array($this->WhereOr)) {
                if (strlen($flagWhere) == 0) {
                    $sql .= " OR ";
                }
                $sql .= $flagWhere . '(' . implode(") OR (", $this->WhereOr) . ')';
                $flagWhere = "";
            }
        }
        if(strlen($this->Group))
        {
            $sql .= $this->Group;
        }
        /** having
        [
            'genres_id' =>
         * [
         *      ...
         * ]
        ]
         * */

        if (is_array($this->having))
        {
            $sql .= " HAVING ";
            $having_groups = [];
            foreach ($this->having as $column => $conditions)
            {
                $having_groups[$column] = ' (' . implode(' OR ', $conditions) . ') ';
            }
            $sql .= implode("\n AND \n", $having_groups);

        }
        if (strlen($this->Order) > 0) {
            $sql .= $this->Order;
        }
        if (strlen($this->Pag) > 0) {
            $sql .= $this->Pag;
        } else if (strlen($this->Lim) > 0) {
            $sql .= $this->Lim;
        }
        $sql .= "; ";
        //echo "<pre><p> sql: " . $sql . "</p>"; die();

        return PDO_DB::getInstance()->query($sql);
    }

    public function Paginate($num)
    {
        $this->PagCount = $num;
        if (isset($_GET['pagStart'])) {
            $this->PagStart = $_GET['pagStart'];
            $this->Pag = " LIMIT " . $this->PagStart . ", ";
            $this->Pag .= $this->PagCount;
        } else {
            $this->Pag = " LIMIT " . $num;
        }
        return $this;
    }

    public function getPaginate()
    {
        $pag['count'] = $this->getCount();
        $pag['pagStart'] = $pag['count'] - $this->PagCount;
        $pag['num'] = $this->PagCount;
        if ($pag['count'] > $this->PagCount) {
            $pag['url'] = explode("?", $_SERVER['REQUEST_URI']);
            $pag['url'] = $pag['url'][0] . "?";

            foreach ($_GET as $key => $value) {
                if ($key != 'pagStart')
                    $pag['url'] .= $key . "=" . $value . "&";
            }
        }
        return $pag;
    }

    public function Create($data)
    {
        $sql = "INSERT INTO " . $this->table . " ( ";
        for ($i = 0; $i < sizeof($this->addFields); $i++) {
            $arrFilds[] = "`" . $this->addFields[$i] . "`";
        }
        $sql .= implode(", ", $arrFilds);
        $sql .= ") VALUES (";

        for($i = 0; $i < sizeof($this->addFields); $i++) {
            if(array_key_exists($this->addFields[$i], $data))
                $arrValues[] = $data[$this->addFields[$i]];
            else
                $arrValues[] = $data[$this->alias .'.'. $this->addFields[$i]];
        }
        $sql .= ':'.implode(", :", $this->addFields);
        $sql .= '); ';

        //echo $sql; print_r($data); die();
        $query = PDO_DB::getInstance()->prepare($sql);
        return $query->exec($data);
    }

    public function Delete($data)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE ";
        foreach ($data as $col => $value)
        {
            $conditions[] = $col.' = :'.$col;
        }
        $sql .= implode(' AND ', $conditions);
        $sql .= ';';

        //echo $sql; die();
        $query = PDO_DB::getInstance()->prepare($sql);
        $query->exec($data);
    }

    public function Update($data)
    {
        $sql = "UPDATE " . $this->table . " SET ";
        foreach ($data as $col => $value)
        {
            if($col != $this->findField)
                $newValues[] = $col."=:".$col;

        }
        $sql .= implode(", ", $newValues);
        $sql .= " WHERE " . $this->findField . '=' . $data[$this->findField];
        unset($data[$this->findField]);
        $sql .= '; ';

        //echo $sql;
        $query = PDO_DB::getInstance()->prepare($sql);
        //print_r($sql); print_r($data);
        $query->exec($data);
    }


    public function All()
    {
        $sql = "SELECT * FROM " . $this->table . ';';
        return PDO_DB::getInstance()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }




}