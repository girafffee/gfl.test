<?php


namespace App\Base;

use App\Config;
use Kernel\Router;

class BaseController
{
    const RENDER_ECHO = false;
    const RENDER_RETURN = true;

    protected $content;
    public $params;

    private static function getPathTpl($tplName)
    {
        $path = Config::PATH_TO_TEMPLATES . '/' . $tplName;

        if(file_exists($path))
            return $path;
    }

    /**
     * Название шаблона
     * @param $tplName
     *
     * Передаваемые параметры (переменные) в шаблон
     * @param string $data
     *
     * FALSE    - полученный контенст сразу выводится на экран
     * TRUE     - получанный контент становится возвращаемым значением типа string
     * @param bool $output
     * @return false|string|null
     */
    public static function render($tplName, $data = array(), $output = true)
    {
        if(empty($tplName) || $tplName == '')
            return NULL;

        if(!empty($data))
            extract($data);

        // включаем буфер
        ob_start();

        include self::getPathTpl($tplName);

        // сохраняем всё что есть в буфере в переменную $content
        $content = ob_get_contents();

        // отключаем и очищаем буфер
        ob_end_clean();

        if($output)
            return $content;
        else
            echo $content;
    }

    public function __construct($action, $params = NULL)
    {
        $this->$action($params);
    }

    public function getContent()
    {
        return $this->content;
    }

    public static function setAdmin()
    {
        if(!array_key_exists('is_active_admin', $_SESSION)
            && array_key_exists('PHP_AUTH_USER', $_SERVER)
            && $_SERVER['PHP_AUTH_USER'] == Config::ADMIN_LOGIN)
            $_SESSION['is_active_admin'] = true;
    }
    public static function checkAdmin()
    {
        return array_key_exists('is_active_admin', $_SESSION) && (bool)$_SESSION['is_active_admin'];
    }

    public function redirect($nameRoute, $args = array())
    {
        $url = Router::route($nameRoute, $args);
        //echo $url; die;
        header("Location: " . Config::SITE_URL . $url);
        exit;
    }

    public function filterData(&$data)
    {
        foreach ($_POST as $key => $post)
        {
            if(is_string($post))
            {
                $data[$key] = htmlspecialchars(trim($post));
                continue;
            }
            $data[$key] = $post;
        }
    }




}