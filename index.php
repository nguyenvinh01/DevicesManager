<?php
session_start();

// if (empty($_SESSION['taikhoanadmin'])) {
//     // header("Location: login");
//     require_once './app/Views/Auth/login.php';
// } else
//     require_once "./app/index.php";
// if (isset($_GET["url"]) == "login") {
//     require_once "./app/Views/Auth/login.php";
// } else 
// if (empty($_SESSION['taikhoanadmin'])) {
//     // Nếu không có session đăng nhập, chuyển hướng đến trang login
//     header("Location: ./login");
//     exit();
// } else {
//     // Nếu đã đăng nhập, chuyển hướng đến trang index
//     header("Location: user_list.php");
//     exit();
// }

// $request = isset($_GET['url']) ? $_GET['url'] : '';

// // if ($request === 'login' && empty($_SESSION['taikhoanadmin'])) {
// //     // Nếu đang yêu cầu truy cập trang login và chưa có session login
// //     // Chuyển hướng đến trang login.php
// //     header("Location: login");
// //     // exit();
// // }
// switch ($request) {
//     case 'user_list':
//         require_once('./app/Controllers/UserListController.php');
//         $controller = new UserListController();
//         $controller->getUserList();
//         break;
//     case 'login':
//         require_once('./app/Controllers/LoginController.php');
//         $controller = new LoginController();
//         $controller->login();
//         break;
//     case 'register':
//         require_once('./app/Controllers/RegisterController.php');
//         $controller = new RegisterController();
//         $controller->register();
//         break;
//     default:
//         // require_once './app/Views/Error/404.php';
//         break;
// }

require_once "./app/Route.php";
$route = new Route();
