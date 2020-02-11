<?php


namespace Kernel;

use App\controllers\HeadController;
use App\controllers\FooterController;
use App\controllers\HeaderController;


class Response
{
    public static $pageData;

//*------------------------------------------------------------
// Собрать данные для построения страницы
    public static function buildPageData ()
    {
        self::$pageData ['head'] = HeadController::getContent();
        self::$pageData ['footer'] = FooterController::getContent();
        self::$pageData ['header'] = HeaderController::getContent();
    }

    public static function renderPage()
    {
        $page = "<!DOCTYPE html>\n<html>";
        $page .= "\n<head>\n";
        $page .= self::$pageData ['head'];
        $page .= "\n</head>\n";
        $page .= "\n<body data-spy=\"scroll\">\n";
        $page .= self::$pageData['header'];
        $page .= self::$pageData['content'];
        $page .= self::$pageData ['footer'];
        $page .= "\n</body></html>";
        return $page;
    }

    public static function putPosition ($name, $content){
        self::$pageData[$name].= $content;
    }


    private static $instance;
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __construct() {
        self::$pageData ['content'] ="";
    }

    private function __clone() {}
    private function __wakeup() {}

}