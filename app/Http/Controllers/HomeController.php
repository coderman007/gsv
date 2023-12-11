<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome(){
        return view('home.welcome');
    }

    public function help(){
        return view('home.help');
    }

    public function settings(){
        return view('home.settings');
    }

    public function policy(){
        return view('home.policy');
    }

    public function terms(){
        return view('home.terms');
    }

    public function manual(){
        return view('home.manual');
    }

}