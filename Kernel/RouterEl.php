<?php


namespace Kernel;


use App\Config;

class RouterEl
{

    public $url;
    public $controller;
    public $action;
    public $name;
    public $arg;
    public $path;

    public $parent_id;  //url for parent route

    public function __construct ($url, $controller, $parent_id = null){

        $this->url = $url;
        $this->controller = $controller;
        $this->setAction();
        $this->parent_id = $parent_id;
    }


    private function setAction()
    {
        $methods = explode('#', $this->controller);
        $this->controller = $methods[0];

        if(count($methods) == 2)
        {
            $this->action = $methods[1];
        }
        else
        {
            $this->action = Config::DEFAULT_ACTION;
        }
    }

    public function addArg($key, $value) {
        $this->arg[$key] = $value;
        return $this;
    }

    public function addPath($path) {
        $this->path = $path;
        return $this;
    }


    public function name($name){
        $this->name = $name;
        return $this;
    }

}