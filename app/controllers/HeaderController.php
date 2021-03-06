<?php


namespace App\controllers;


use App\Base\BaseController;
use App\Config;
use Kernel\Router;

class HeaderController extends BaseController
{
    public function getContent()
    {
        $links = [
            'catalog' => Router::route('catalog'),
            'admin' => Router::route('admin'),
            'main'  => Config::SITE_URL
        ];

        return self::render('layouts/header.php', $links);
    }

}