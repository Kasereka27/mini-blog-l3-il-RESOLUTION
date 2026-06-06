<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;

class DashboardController
{
    public function index()
    {
        $stats = [
            'posts' => Post::count(),
            'comments' => Comment::count(),
            'users' => User::count(),
            'categories' => Category::count(),
        ];
        $recent_articles = Post::with(['category', 'user'])->latest('id')->limit(7)->get();
        return view('dashboard.index', compact('stats', 'recent_articles'));
    }

    public function articles()
    {
        $articles = Post::with(['category', 'user'])->latest('id')->limit(10)->paginate(10);

        return view('dashboard.articles', compact('articles'));
    }

    public function categories()
    {
        $categories = Category::withCount('articles')->paginate(5);
        return view('dashboard.categories', compact('categories'));
    }

    public function users()
    {
        $users = User::withCount('articles')->paginate(10);
        return view('dashboard.users', compact('users'));
    }

    public function comments()
    {
        $comments = Comment::with(['user', 'post'])->paginate(10);
        //dd($comments);
        return view('dashboard.comments', compact('comments'));
    }

    public function settings()
    {
        return view('dashboard.settings');
    }
}