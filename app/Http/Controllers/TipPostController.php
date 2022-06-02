<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TipPost;
use \App\Models\Category;
use \App\Models\TipComment;
use \App\Models\User;

class TipPostController extends Controller
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
        return view('tipPosts', [
            'title' => "Tip Blogs" . $title,
            "active" => "tipPosts",
            "selectCategory" => $selectCategory,
            "selectUser" => $selectUser,
            "categories" => Category::all(),
            "tipPosts" => TipPost::latest()->filter(request(['search', 'category', 'user']))->paginate(7)->withQueryString()
        ]);
    }

    public function show(TipPost $tipPost)
    {
        return view('tipPost', [
            'title' => "Tip Blog",
            "active" => "tipPosts",
            "tipPost" => $tipPost,
            "tipComments" => TipComment::all()->where('tipPost_id', '=', $tipPost->id)
        ]);
    }
}
