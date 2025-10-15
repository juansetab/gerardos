<?php

namespace App\Controllers;


class Inicio extends BaseController
{
    public function index()
    {
        return view("template/header_sneat").view("template/footer_sneat");
    }
}
