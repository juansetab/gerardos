<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        session()->destroy();
        echo view("login/index");
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function start()
    {   
        if (!isset($_POST["username"], $_POST["password"]))
            return redirect()->to(base_url('login?status=0&description=Error al ingresar usuario y contraseña'));
        $response = \App\Libraries\UserControl::login_validation($_POST["username"], $_POST["password"]);
        
        if ($response['status'] === true) {
            $url_request = explode("?", $_SERVER["HTTP_REFERER"])[0]; //Quita variables GET si existen
            $url_redirect = $url_request != base_url("login") ?  $_SERVER["HTTP_REFERER"] : base_url("inicio/");    
            return redirect()->to($url_redirect);
        } else {
            return redirect()->to(base_url('login?status=0&description= ' . $response['msg']));
        }
    }
}
