<?php

require_once('./app/Models/LoginModel.php');
class LoginController
{
    var $login;
    public function __construct()
    {
        $this->login = new LoginModel();
    }

    function login()
    {
        require_once('./app/Views/login.php');
    }
}
