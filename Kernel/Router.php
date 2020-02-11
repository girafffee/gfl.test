<?php


namespace Kernel;

use App\Config;
use Kernel\RouterEl;

class Router
{
    public static $routes;

    public static function add($url, $controller,$parent_id = null)
    {
        self::$routes[$url] = new RouterEl($url, $controller, $parent_id);
        return self::$routes[$url]; //Возвращает обьект
    }

    static function addGroup ($url, $controller){
        $url = strtolower($url);
        $url = str_replace('{', '', $url);
        $url = str_replace('}', '', $url);
        $url = explode('/', $url);


        array_shift($url);
        $mainUrl = '/'.$url[0];

        $path = array();

        for($i = 1; $i < sizeof($url); $i++){
            $path[] = $url[$i];
        }

        $route = self::add($mainUrl, $controller);
        $route->addPath($path);

        return $route;
    }

    public static function route($name, $args = array())
    {
        foreach (self::$routes as $route)
        {
            if($route->name == $name || $route->url == $name)
            {
                if(empty($args))
                    return $route->url;

                foreach ($args as $key => $value)
                {
                    $route->addArg($key, $value);
                }


                return self::buildUrl($route);
            }
        }
    }
    private static function buildUrl($route)
    {
        return $route->url . '/' . implode('/', $route->arg);
    }

    public static function checkArgs($name)
    {
        return count(self::$routes[$name]->arg) == count(self::$routes[$name]->path);
    }

    /*
    |--------------------------------------------------------------------------
    | Создание запрошенного контроллера
    |--------------------------------------------------------------------------
    |
    | Router создает выбранный пользователем контроллер через URL,
    | и передеает ему параметры
    |
    */
    public function callController()
    {
        $url =  explode('?' , $_SERVER['REQUEST_URI']);
        $url = $url[0];


        if(array_key_exists($url, self::$routes) OR array_key_exists(substr($url, 0, strlen($url) - 1) , self::$routes))
        {

            if(!isset(self::$routes[$url]))
                $url = substr($url, 0, strlen($url) - 1);

            // статический маршрут
            $object = new self::$routes[$url]->controller(self::$routes[$url]->action);

            return $object->getContent();
        }
        else
        {
            // динамический маршрут с аргументами
            $url = explode("/", $url);
            array_shift($url);
            $mainUrl = '/'.$url[0];

            if(isset(self::$routes[$mainUrl]))
            {
                array_shift($url);
                self::$routes[$mainUrl]->arg = $url;


                if(self::checkArgs($mainUrl))
                {
                    $action = self::$routes[$mainUrl]->action;

                    if(in_array('action', self::$routes[$mainUrl]->path))
                    {
                        $action_key = array_search('action', self::$routes[$mainUrl]->path);
                        $action = self::$routes[$mainUrl]->arg[$action_key];
                        unset(self::$routes[$mainUrl]->arg[$action_key]);
                    }

                    $object = new self::$routes[$mainUrl]->controller($action, self::$routes[$mainUrl]->arg);

                    return $object->getContent();
                }
            }
        }


    }



    private static $instance;
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __construct(){}
    private function __clone() {}
    private function __wakeup() {}
}

Config::inc("Router/web.php");