<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use App\Models\ReviewPost;
use App\Models\TipPost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'title' => 'Home',
            'active' => 'home',
            "reviewPosts" => ReviewPost::all(),
            "tipPosts" => TipPost::all(),
            "newsPosts" => NewsPost::all(),
            'reviewCount' => 1,
            'tipCount' => 1,
            'newsCount' => 1
        ]);
    }
}