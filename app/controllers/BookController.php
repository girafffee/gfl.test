<?php


namespace App\controllers;


use App\Base\BaseController;
use App\Lib\Mailer;
use App\models\Books;

class BookController extends BaseController
{
    public function index()
    {
        $table = new Books;
        $table->table = 'book_genres bg';
        $books = $table
            ->SelectWhat([
                'id'        => 'b.id',
                'title'     =>'b.title',
                'desc_short' => 'b.desc_short',
                'genres'    => 'GROUP_CONCAT(DISTINCT g.name)',
                'authors'   => 'GROUP_CONCAT(DISTINCT a.name)'
            ])
            ->simpleJoin('
                LEFT JOIN books b ON bg.book_id = b.id
                LEFT JOIN genres g ON bg.genre_id = g.id
                LEFT JOIN book_authors ba ON ba.book_id = b.id
                LEFT JOIN authors a ON ba.author_id = a.id
            ')
            ->WhereEqually('status', Books::STATUS_ACTIVE)
            ->GroupBy('bg.book_id')
            ->OrderBy('b.title')
            ->Get();

        if($books)
            $books = $books->fetchAll(\PDO::FETCH_ASSOC);
        else
            $books = array();

        $this->content = self::render ('catalog/all.tpl.php', [
            'books' => $books
        ]);
        return $this;
    }

    /**
     * @param $args array
     *
     * Отрабатывает по запросу
     * /catalog-g/{search_string}/{genre_id}/{author_id}
     * @return $this
     */
    public function search($args)
    {
        $table = new Books;

        $table->table = 'book_genres bg';
        $books = $table
            ->SelectWhat([
                'id'        => 'b.id',
                'title'     =>'b.title',
                'desc_short' => 'b.desc_short',
                'genres'    => 'GROUP_CONCAT(DISTINCT g.name)',
                'authors'   => 'GROUP_CONCAT(DISTINCT a.name)'
            ])
            ->WhereEqually('b.status', Books::STATUS_ACTIVE)
            ->WhereLike('b.title', $args[0])
            ->WhereLike('b.desc_short', $args[0])
            ->havingLike('genres', $args[1])
            ->havingLike('authors', $args[2], 'AND')
            ->simpleJoin('
                LEFT JOIN books b ON bg.book_id = b.id
                LEFT JOIN genres g ON bg.genre_id = g.id
                LEFT JOIN book_authors ba ON ba.book_id = b.id
                LEFT JOIN authors a ON ba.author_id = a.id
            ')
            ->GroupBy('bg.book_id')
            ->OrderBy('b.title')
            ->Get();

        if($books)
            $books = $books->fetchAll(\PDO::FETCH_ASSOC);
        else
            $books = array();

        $this->content = self::render ('catalog/all.tpl.php', $books);
        return $this;
    }

    public function view($args)
    {
        $table = new Books;
        $table->table = 'book_genres bg';

        $books = $table
            ->SelectWhat([
                'id'        => 'b.id',
                'title'     =>'b.title',
                'desc_short' => 'b.desc_short',
                'desc_full' => 'b.desc_full',
                'created_at' => 'b.created_at',
                'genres'    => 'GROUP_CONCAT(DISTINCT g.name)',
                'authors'   => 'GROUP_CONCAT(DISTINCT a.name)'
            ])
            ->simpleJoin('
                LEFT JOIN books b ON bg.book_id = b.id
                LEFT JOIN genres g ON bg.genre_id = g.id
                LEFT JOIN book_authors ba ON ba.book_id = b.id
                LEFT JOIN authors a ON ba.author_id = a.id
            ')
            ->WhereEqually('b.id', $args[1])
            ->Get();

        if($books)
            $books = $books->fetch(\PDO::FETCH_ASSOC);
        else
            $books = array();

        $this->content = self::render ('catalog/single.tpl.php', [
            'book' => $books
        ]);
        return $this;
    }



}