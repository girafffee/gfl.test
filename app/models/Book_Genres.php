<?php


namespace App\models;


use App\Base\BaseModel;

class Book_Genres extends BaseModel
{
    public function __construct()
    {
        $this->table = 'book_genres';
        $this->addFields = ['book_id', 'genre_id'];
    }

}