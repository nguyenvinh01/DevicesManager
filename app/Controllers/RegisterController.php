<?php

require_once('./app/Models/RegisterModel.php');
class RegisterController
{
    var $register;
    public function __construct()
    {
        $this->register = new RegisterModel();
    }

    function register()
    {
        require_once('./app/Views/register.php');
    }
}
