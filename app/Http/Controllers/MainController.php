<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController
{
    public function index(){
        return view('posts.articles');
    }

    public function articles(){
        return view('posts.articles');
    }

    public function article($slug){
        return view('posts.show');
    }

    public function categories(){
        return view('posts.categories');
    }

    public function about(){
        return view('posts.about');
    }
}