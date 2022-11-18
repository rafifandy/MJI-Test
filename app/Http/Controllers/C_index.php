<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class C_index extends Controller
{
    public function index()
    {
        return view('index');
    }
}
