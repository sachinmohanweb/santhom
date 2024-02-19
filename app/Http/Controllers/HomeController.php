<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    
    public function admin_index() : View
    {
        return view('index',[]);
    }

    public function admin_dashboard() : View
    {
        return view('dashboard.index',[]);
    }
    
}
