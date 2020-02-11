<?php


namespace App\controllers;


use App\Base\BaseController;

class FooterController extends BaseController
{
    public function getContent()
    {
        return self::render ('layouts/footer.php');
    }
}