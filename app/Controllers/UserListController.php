<?php

require_once('./app/Models/UserListModel.php');
class UserListController
{
    var $userList;
    public function __construct()
    {
        $this->userList = new UserListModel();
    }

    function getUserList()
    {

        $listUser = $this->userList->getUserList();

        // require_once('../index.php');
        require_once "./app/index.php";
    }
}
