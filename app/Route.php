<?php


// Kiểm tra các yêu cầu và xác định tuyến đường
// $request = isset($_GET['url']) ? $_GET['url'] : '';

// switch ($request) {
//     case 'user_list':
//         require_once './app/Views/UserList.php';
//         break;
//     case 'login':
//         require_once './app/Views/login.php';
//         break;
//     case 'register':
//         require_once './app/Views/register.php';
//         break;
//     default:
//         // require_once './app/Views/Error/404.php';
//         break;
// }

// if ($_GET['url'] == 'login') {
//     // require_once ".\\app\\Views\\Auth\\login.php";
//     echo "sdasđs";
// }
class Route
{
    // protected $controller;
    // protected $action;
    // protected $params = [];
    // function __construct()
    // {
    //     $arr = $this->UrlProcess();
    //     $arr[0] = 'Login';
    //     // Controller
    //     if (file_exists("./app/Controllers/Login" . $arr[0] . "Controller.php")) {
    //         $this->controller = $arr[0];
    //         unset($arr[0]);
    //     }
    //     require_once "./app/Controllers/" . $this->controller . "Controller.php";
    //     $this->controller = new $this->controller;

    //     // Action
    //     if (isset($arr[1])) {
    //         if (method_exists($this->controller, $arr[1])) {
    //             $this->action = $arr[1];
    //         }
    //         unset($arr[1]);
    //     }

    //     // Params
    //     $this->params = $arr ? array_values($arr) : [];

    //     call_user_func_array([$this->controller, $this->action], $this->params);
    // }
    // function UrlProcess()
    // {
    //     if (isset($_GET["url"])) {
    //         return explode("/", filter_var(trim($_GET["url"], "/")));
    //     }
    // }
    protected $controller = "";
    // protected $action = "SayHi";
    // protected $params = [];

    function __construct()
    {

        $arr = $this->UrlProcess();
        $arr[0] = 'Login';

        // Controller
        if (file_exists("/app/Controllers/" . $arr[0] . "Controller.php")) {
            $this->controller = $arr[0];
            unset($arr[0]);
        }
        require_once "./app/Controllers/" . $this->controller . "Controller.php";
        // $this->controller = new $this->controller;

        // // Action
        // if (isset($arr[1])) {
        //     if (method_exists($this->controller, $arr[1])) {
        //         $this->action = $arr[1];
        //     }
        //     unset($arr[1]);
        // }

        // // Params
        // $this->params = $arr ? array_values($arr) : [];

        // call_user_func_array([$this->controller, $this->action], $this->params);
    }

    function UrlProcess()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
    }
}
