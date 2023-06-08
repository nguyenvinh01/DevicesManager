<?php
class Route
{
    protected $controller;
    protected $action = "Show";
    protected $params = [];

    function __construct()
    {
        $arr = $this->UrlProcess();
        if (isset($arr[0])) {
            // Controller
            if (file_exists("./app/Controllers/" . $arr[0] . "Controller.php")) {
                $this->controller = $arr[0];
                unset($arr[0]);
            }
            require_once "./app/Controllers/" . $this->controller . "Controller.php";

            $this->controller =  $this->controller .= "Controller";

            $controllerInstance = new $this->controller();

            // Action
            if (isset($arr[1])) {
                if (method_exists($controllerInstance, $arr[1])) {
                    $this->action = $arr[1];
                }
                unset($arr[1]);
            }

            // Params
            $this->params = $arr ? array_values($arr) : [];

            call_user_func_array([$controllerInstance, $this->action], $this->params);
            // } else {
            //     // header("Location: index.php?url=index.php");

            //     require_once "./app/index.php";
        } else {
            require_once "./app/index.php";
        }
    }
    function UrlProcess()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
    }
}
