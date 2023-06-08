<?php

require_once('./app/Models/UserListModel.php');
require_once('./app/core/Controller.php');
class UserListController extends Controller
{
    var $userList;
    public function __construct()
    {
        $this->userList = new UserListModel();
        // $userList = $this->model("UserList");
    }

    public function Show()
    {
        // $userList = $this->model("UserList");
        $listUser = $this->userList->getUserList();
        $this->view('index', ["listuser" => $listUser, "page" => "userlist"]);
        // require_once "./app/Views/UserList.php";
        // $page = "dashboard";

        // require_once('./app/index.php');

        // require_once('./index.php');
        // require_once "./app/index.php";
    }
}
