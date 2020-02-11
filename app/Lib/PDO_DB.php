<?php


namespace App\Lib;


use App\Config;

class PDO_DB extends DB_Driver
{
    public $prepare;

    private function __construct()
    {
        $this->dbhost = Config::DB_HOST;
        $this->dbuser = Config::DB_USER;
        $this->dbpswd = Config::DB_PASS;
        $this->dbname = Config::DB_NAME;
        $this->dbcharset = Config::DB_CHARSET;

        $dsn = "mysql:dbname=$this->dbname;host=$this->dbhost;charset=$this->dbcharset";

        $this->DB = new \PDO($dsn, $this->dbuser, $this->dbpswd);
    }

    public function prepare($sqlExec)
    {
        $this->prepare = $this->DB->prepare($sqlExec, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
        return $this;
    }

    public function exec($arrayParam = array())
    {
        $this->prepare->execute($arrayParam);
        return $this;
    }

    public function getOne()
    {
        return $this->prepare->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        return $this->prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    public function query($sql)
    {
        return $this->DB->query($sql);
    }




    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __clone(){}
    private function __wakeup(){}
}