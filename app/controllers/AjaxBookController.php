<?php


namespace App\controllers;


use App\Base\BaseController;
use App\Lib\Mailer;
use App\models\Authors;
use App\models\Book_Genres;
use App\models\Books;
use App\models\Genres;

class AjaxBookController extends BaseController
{

    public function ajaxSearchBooks()
    {
        $model = new Books();
        $model->table = 'book_genres';
        $model->alias = 'bg';

        $data = array();
        $this->filterData($data);

        $model->setIndexQuery()
            ->WhereLike('b.title', '%'.$data['name-desc'].'%')
            ->WhereEqually('b.status', Books::STATUS_ACTIVE);


        $columns = ['genres', 'authors'];

        foreach ($_POST as $key => $value)
        {
            $col = explode('-', $key)[0];
            if(in_array($col, $columns))
            {
                $pattern = "%#$value#%";

                $model->searchLikeInGroupConcat($col . '_id', $pattern);
            }
        }
        $books = $model->Get();

        if($books)
            $books = $books->fetchAll(\PDO::FETCH_ASSOC);
        else
            $books = array();

        self::renderPartial('ajax/all.ajax.tpl.php', ['books'=>$books]);
    }

    public function ajaxCreateAuthors()
    {
        $data = array();
        $this->filterdata($data);

        $model = new Authors();
        $model->Create($data);

        $authors = $model
            ->OrderBy('a.name')
            ->Get()
            ->fetchAll(\PDO::FETCH_ASSOC);

        self::renderPartial('ajax/authors.ajax.tpl.php', [
            'authors' => $authors
        ]);
    }

    public function ajaxCreateGenres()
    {
        $data = array();
        $this->filterdata($data);

        $model = new Genres();
        $model->Create($data);

        $genres = $model
            ->OrderBy('g.name')
            ->Get()
            ->fetchAll(\PDO::FETCH_ASSOC);

        self::renderPartial('ajax/genres.ajax.tpl.php', [
            'genres' => $genres
        ]);
    }

    public function ajaxDeleteGenre()
    {
        $data = array();
        $this->filterData($data);

        $model = new Genres();
        $model->Delete($data);

        $genres = $model
            ->OrderBy('g.name')
            ->Get()
            ->fetchAll(\PDO::FETCH_ASSOC);

        self::renderPartial('ajax/genres.ajax.tpl.php', [
            'genres' => $genres
        ]);
    }

    public function ajaxUpdateGenres()
    {
        $data = array();
        $this->filterdata($data);

        $model = new Genres();
        $model->Update($data);

        $genres = $model
            ->OrderBy('g.name')
            ->Get()
            ->fetchAll(\PDO::FETCH_ASSOC);

        self::renderPartial('ajax/genres.ajax.tpl.php', [
            'genres' => $genres
        ]);

    }

    public function ajaxUpdateAuthors()
    {
        $data = array();
        $this->filterdata($data);

        $model = new Authors();
        $model->Update($data);

        $authors = $model
            ->OrderBy('a.name')
            ->Get()
            ->fetchAll(\PDO::FETCH_ASSOC);

        self::renderPartial('ajax/authors.ajax.tpl.php', [
            'authors' => $authors
        ]);

    }




    public function ajaxDeleteAuthor()
    {
        $data = array();
        $this->filterData($data);

        $model = new Authors();
        $model->Delete($data);

        $authors = $model
            ->OrderBy('a.name')
            ->Get()
            ->fetchAll(\PDO::FETCH_ASSOC);

        self::renderPartial('ajax/authors.ajax.tpl.php', [
            'authors' => $authors
        ]);
    }

    public function ajaxOrder()
    {
        if(empty($_POST))
            return false;

        $data = $_POST['inp'];
        $book = $_POST['book'];
        $this->filterData($data);

        $table = new Books;

        $book = $table
            ->SelectWhat([
                'title'     =>'b.title',
                'desc_short' => 'b.desc_short',
            ])
            ->WhereEqually('b.id', $book)
            ->Get()
            ->fetch(\PDO::FETCH_ASSOC);

        $mail = new Mailer();
        $mail_info = [
            'subject'   => 'New order',
            'body'      => self::render('mail/book_order.php', [
                'book' => $book,
                'customer' => $data
            ]),
            'altBody'   => ''
        ];

        if($mail->sendEmailAdmin($mail_info))
            echo (int)TRUE;
    }



}