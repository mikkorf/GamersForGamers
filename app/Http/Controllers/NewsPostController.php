<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\NewsPost;
use \App\Models\Category;
use \App\Models\NewsComment;
use \App\Models\User;

class NewsPostController extends Controller
{
    public function index()
    {
        $title = '';
        $selectCategory = '';
        $selectUser = '';
        $count = 0;
        if(request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            // $title = ' in ' . $category->name;
            $selectCategory = $category->name;
        }

        if(request('user')) {
            $user = User::firstWhere('username', request('user'));
            $title = ' by ' . $user->name;
            $selectUser = $user->name;
        }

        //dd(request('search'));
        return view('newsPosts', [
            'title' => "News Blogs" . $title,
            "active" => "newsPosts",
            "selectCategory" => $selectCategory,
            "selectUser" => $selectUser,
            "categories" => Category::all(),
            "newsPosts" => NewsPost::latest()->filter(request(['search', 'category', 'user']))->paginate(7)->withQueryString()
        ]);
    }

    public function show(NewsPost $newsPost)
    {
        return view('newsPost', [
            'title' => "News Blog",
            "active" => "newsPosts",
            "newsPost" => $newsPost,
            "newsComments" => NewsComment::all()->where('newsPost_id', '=', $newsPost->id)
        ]);
    }
}
