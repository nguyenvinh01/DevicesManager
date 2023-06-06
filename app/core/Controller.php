<?php
class Controller
{

    public function model($model)
    {
        require_once "./app/Models/" . $model . "Model.php";
        return new $model;
    }

    public function view($view, $data = [])
    {
        require_once "./mvc/Views/" . $view . ".php";
    }
}
