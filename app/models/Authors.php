<?php


namespace App\models;


use App\Base\BaseModel;

class Authors extends BaseModel
{
    public function __construct()
    {
        $this->table = 'authors';
    }

}