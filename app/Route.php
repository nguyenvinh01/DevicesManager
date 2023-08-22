<?php

class Route
{
    protected $controller;
    protected $action = "Show";
    protected $params = [];
    protected $role;
    public function __construct()
    {
        $arr = $this->UrlProcess();

        // Kiểm tra xem có đường dẫn URL hay không
        if ($arr) {
            // Lấy controller từ đường dẫn URL
            $this->controller = ucfirst($arr[0]) . "Controller";

            $authActions = ['register', 'login', 'logout'];
            if (in_array($arr[0], $authActions)) {
                $this->role = "Auth/";
            } else {
                if ($_SESSION['quyen'] == 1) {
                    $this->role = "Admin/";
                } else if ($_SESSION['quyen'] == 2) {
                    $this->role = "User/";
                } else if ($_SESSION['quyen'] == 3) {
                    $this->role = "Staff/";
                }
            }
            if (isset($_SESSION['taikhoanadmin'])) {
            }
            $controllerFile = "./app/Controllers/" . $this->role . $this->controller . ".php";
            unset($arr[0]);

            // Kiểm tra file controller có tồn tại hay không
            if (file_exists($controllerFile)) {
                require_once $controllerFile;

                $controllerInstance = new $this->controller();

                // Lấy action từ đường dẫn URL
                if (isset($arr[1])) {
                    $action = lcfirst($arr[1]);
                    if (method_exists($controllerInstance, $action)) {
                        $this->action = $action;
                        unset($arr[1]);
                    }
                }

                // Lấy params từ đường dẫn URL
                $this->params = array_values($arr);

                // Gọi phương thức action trên controller
                call_user_func_array([$controllerInstance, $this->action], $this->params);
            } else {
                // Nếu file controller không tồn tại, xử lý lỗi tại đây
                echo "File controller không tồn tại.";
            }
        } else {
            // Nếu không có đường dẫn URL, hiển thị trang chủ
            require_once "./app/index.php";
        }
    }

    public function UrlProcess()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
        return null;
    }
}
