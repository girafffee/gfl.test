<?php


namespace App\models;


use App\Base\BaseModel;

class Book_Authors extends BaseModel
{
    public function __construct()
    {
        $this->table = 'book_authors';
        $this->addFields = ['book_id', 'author_id'];
    }

}