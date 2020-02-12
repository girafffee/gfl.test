<?php


namespace App\models;


use App\Base\BaseModel;

class Books extends BaseModel
{

    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';

    public function __construct()
    {
        $this->table = 'books';
        $this->alias = 'b';
        $this->addFields = ['b.title', 'b.desc_short', 'b.desc_full'];
        $this->findField = 'b.id';

        $this->deleteByFields = [
            'status' => self::STATUS_DELETED,
            'deleted_at' => 'NOW()'
        ];

        $this->activeByFields = [
            'status' => self::STATUS_ACTIVE,
            'deleted_at' => NULL
        ];
    }

    /** TODO:
     *      Переделать поиск по каталогу.
     *      Реализовать в виде чекбоксов Жанры и Авторы
     *      При каждом нажатии собирать все данные и отправлять запрос
     *      Выборку из базы сделать с помощью HAVING LIKE
     *      example:
     *      ... GROUP_CONCAT(DISTINCT g.id) as "genres_id" ...
     *      ... HAVING genres_id LIKE "%,1,%" OR genres_id LIKE "1,%" OR genres_id LIKE "%,1" OR genres_id=1
     *      и запрос строить через OR если id соответствуют одной категории
     *      (только Жанры или Авторы)
     *      если поиск по обеим категориям - ставить между ними условие AND
     * @param $column
     * @param $argument
     * @return Books
     */

    public function searchLikeInGroupConcat($column, $argument)
    {
        $this->havingLike($column, $argument);
        return $this;
    }

    public function setIndexQuery()
    {
        $this->SelectWhat([
        'id'            => 'b.id',
        'title'         => 'b.title',
        'desc_short'    => 'b.desc_short',
        'genres'        => 'GROUP_CONCAT(DISTINCT " ", g.name)',
        'authors'       => 'GROUP_CONCAT(DISTINCT " ", a.name)',
        'genres_id'     => 'GROUP_CONCAT(DISTINCT "#", g.id, "#")',
        'authors_id'    => 'GROUP_CONCAT(DISTINCT "#", a.id, "#")',
    ])

        ->simpleJoin('
                LEFT JOIN books b ON bg.book_id = b.id
                LEFT JOIN genres g ON bg.genre_id = g.id
                LEFT JOIN book_authors ba ON ba.book_id = b.id
                LEFT JOIN authors a ON ba.author_id = a.id
            ')
        ->GroupBy('bg.book_id')
        ->OrderBy('b.title');

        return $this;
    }


}