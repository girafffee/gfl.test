<?php


namespace App\controllers;

use App\Base\BaseController;
use App\Config;

class HeadController extends BaseController
{

    public function getContent()
    {
        $data['title'] = Config::SITE_NAME;
        return self::render ('layouts/head.php', $data);
    }

}