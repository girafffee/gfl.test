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
        $this->addFields = ['title', 'desc_short', 'desc_full'];
        $this->findField = 'id';

        $this->deleteByFields = [
            'status' => self::STATUS_DELETED,
            'deleted_at' => 'NOW()'
        ];
    }


}