<?php


namespace App\models;


use App\Base\BaseModel;

class Genres extends BaseModel
{
    public function __construct()
    {
        $this->table = 'genres';
        $this->alias = 'g';
        $this->addFields = ['name'];
        $this->findField = 'id';
    }

}