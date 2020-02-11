<?php

namespace App;

use Kernel\Response;
use Kernel\Router;
use App\Lib\PDO_DB;


$Router = Router::getInstance();
$Responce = Response::getInstance();
$PDO = PDO_DB::getInstance();


$Responce::putPosition('content', $Router->callController());

$Responce::buildPageData();

echo $Responce::renderPage();



