<?php


namespace App\controllers;


use App\Base\BaseController;
use App\Config;
use App\models\Authors;
use App\models\Book_Genres;
use App\models\Book_Authors;
use App\models\Books;
use App\models\Genres;
use App\Lib\Mailer;

class AdminController extends BaseController
{

    public function index()
    {
        $table = new Books;
        $books = $table->WhereEqually('status', Books::STATUS_ACTIVE)
            ->OrderBy('title')
            ->Get()
            ->fetchAll(\PDO::FETCH_ASSOC);

        $this->content = self::render ('admin/all.tpl.php', [
            'books' => $books
        ]);
        $this->setAdmin();
        return $this;
    }

    public function create()
    {
        if(!empty($_POST))
            $this->createBook();

        $genres_ob = new Genres();
        $genres = $genres_ob->All();

        $authors_ob = new Authors();
        $authors = $authors_ob->All();

        $this->content = self::render ('admin/single.create.tpl.php', [
            'genres'    => $genres,
            'authors'   => $authors,
        ]);

        return $this;
    }

    public function delete($args)
    {
        $model = new Books();

        foreach ($model->deleteByFields as $col => $value)
        {
            $model->Update([$col => $value, 'id' => $args[2]]);
        }

        $this->redirect('admin');
    }

    public function edit($args)
    {
        if(!$this->checkAdmin())
            $this->redirect('admin');

        if(!empty($_POST))
            $this->saveBook($args[2]);

        $table = new Books;
        $table->table = 'book_genres bg';

        $books = $table
            ->SelectWhat([
                'id'        => 'b.id',
                'title'     =>'b.title',
                'desc_short' => 'b.desc_short',
                'desc_full' => 'b.desc_full',
                'created_at' => 'b.created_at',
                'genres'    => 'GROUP_CONCAT(DISTINCT g.id)',
                'authors'   => 'GROUP_CONCAT(DISTINCT a.id)'
            ])
            ->simpleJoin('
                LEFT JOIN books b ON bg.book_id = b.id
                LEFT JOIN genres g ON bg.genre_id = g.id
                LEFT JOIN book_authors ba ON ba.book_id = b.id
                LEFT JOIN authors a ON ba.author_id = a.id
            ')
            ->WhereEqually('b.id', $args[2])
            ->Get();

        if($books)
        {
            $books = $books->fetch(\PDO::FETCH_ASSOC);
            $books['genres'] = explode(',', $books['genres']);
            $books['authors'] = explode(',', $books['authors']);
        }
        else
            $books = array();

        $genres_ob = new Genres();
        $genres = $genres_ob->All();

        $authors_ob = new Authors();
        $authors = $authors_ob->All();



        $this->content = self::render ('admin/single.edit.tpl.php', [
            'books'     => $books,
            'genres'    => $genres,
            'authors'   => $authors,
        ]);
        return $this;
    }

    private function createBook()
    {
        $data = array();
        $this->filterData($data);

        $genres_authors = $data['upd'];
        unset($data['upd']);

        $model = new Books();
        $return = $model->Create($data);
        $id = $return->DB->lastInsertId();

        $objects = ['genre', 'author'];
        foreach ($objects as $obj)
        {
            if(!array_key_exists($obj, $genres_authors))
                continue;

            $model = 'App\models\Book_'. ucfirst($obj) . 's';

            $table = new $model();
            if(is_array($genres_authors[$obj]))
            {
                foreach ($genres_authors[$obj] as $addVal)
                {
                    $create['book_id'] = $id;
                    $create[$obj . '_id'] = $addVal;

                    $table->Create($create);
                    unset($create);
                }
            }
        }

        $this->redirect('admin');
    }

    private function saveBook($id)
    {
        $data = array();
        $this->filterData($data);

        $objects = ['genre', 'author'];

        foreach ($objects as $obj)
        {
            if (!array_key_exists($obj, $data['upd']))
                continue;

            $src = array();

            if(array_key_exists('src', $data) && array_key_exists($obj, $data['src']))
                $src = $data['src'][$obj];

            $result[$obj]['remove'] = array_diff($src, $data['upd'][$obj]);
            $result[$obj]['add'] = array_diff($data['upd'][$obj], $src);

            $model = 'App\models\Book_'. ucfirst($obj) . 's';

            $table = new $model();
            if(is_array($result[$obj]['add']))
            {
                foreach ($result[$obj]['add'] as $key => $addVal)
                {

                    $create['book_id'] = $id;
                    $create[$obj . '_id'] = $addVal;

                    $table->Create($create);
                    unset($create);
                }
            }
            if(is_array($result[$obj]['remove']))
            {
                foreach ($result[$obj]['remove'] as $key => $addVal)
                {

                    $remove['book_id'] = $id;
                    $remove[$obj . '_id'] = $addVal;

                    $table->Delete($remove);
                    unset($remove);
                }
            }
        }
        unset($data['src']);
        unset($data['upd']);

        $model = new Books();

        foreach ($data as $col => $value)
        {
            $model->Update([$col => $value, 'id' => $id]);
        }

        $this->redirect('admin');
    }




}