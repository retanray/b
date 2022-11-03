<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Devblog extends BaseController
{
    public function list(){
        return view("/devblog/list");
    }

    public function post(){
        return view("/devblog/post");
    }
    
    public function index()
    {
        //
    }
}
