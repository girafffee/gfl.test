<?php


namespace App\controllers;


use App\Base\BaseController;
use Kernel\Router;

class HomeController extends BaseController
{
    public function index()
    {
        $links = [
            'catalog' => Router::route('catalog'),
            'admin' => Router::route('admin'),
        ];

        $this->content = self::render('home.tpl.php', $links);
        return $this;
    }

}