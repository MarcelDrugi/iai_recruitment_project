<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index($action=null)
    { 
        return response()->view('homepage.index', []);
    }
}
