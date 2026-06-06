<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class MainController extends Controller
{
    public function index(){
        $articles = Post::limit(3)->orderByDesc('id')->get();
        $categories = Category::limit(5)->get();
        $stats = [
            'posts' => Post::count(),
            'categories' => Category::count(),
            'comments' => Comment::count(),
        ];
        return view('posts.index', compact('articles', 'categories', 'stats'));
    }

    public function articles(){

        //articles = Post::limit(10)->orderByDesc('id')->get();
        
        $articles = Post::paginate(10);
        //dd($articles); 
        $stats = [
            'posts' => Post::count(),
            'categories' => Category::count(),
        ];
        $categories = Category::all();
        return view('posts.articles', compact("articles", "stats", "categories"));
    }

    public function article(String $slug){

        $article = Post::where("slug", $slug)->first();
        //dd($article);
        return view('posts.show', compact("article"));
    }

    public function categories(){
        $categories = Category::with('articles.user')->get();
        return view('posts.categories', compact("categories"));
    }

    public function about(){
        $stats = [
            'posts' => Post::count(),
            'categories' => Category::count(),
            'users' => \App\Models\User::count(),
            'comments' => Comment::count(),
        ];
        $users = \App\Models\User::all();

        return view('posts.about', compact('stats', 'users'));
    }
}