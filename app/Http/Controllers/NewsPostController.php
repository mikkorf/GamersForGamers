<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\NewsPost;
use \App\Models\Category;
use App\Models\NewsLike;
use \App\Models\NewsComment;
use \App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class NewsPostController extends Controller
{
    public function index()
    {
        $title = '';
        $selectCategory = '';
        $selectUser = '';
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
        return view('news.newsPosts', [
            'title' => "News Blogs" . $title,
            "active" => "newsPosts",
            "selectCategory" => $selectCategory,
            "selectUser" => $selectUser,
            "categories" => Category::all(),
            "newsPosts" => NewsPost::latest()->filter(request(['search', 'category', 'user']))->paginate(7)->withQueryString()
        ]);
    }

    public function create()
    {
        return view('news.createNews', [
            'categories' => Category::all(),
            'title' => "Create News Blog",
            "active" => "newsPosts"
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:news_posts',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required' 
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('newsPost-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 100);

        NewsPost::create($validatedData);

        return redirect('/newsPosts/' . $request->slug)->with('success', 'News blog has been created!');
    }

    public function storeComment(Request $request)
    {
        $validatedData = $request->validate([
            'comment' => 'required' 
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['newsPost_id'] = $request->newsID;
        
        NewsComment::create($validatedData);

        return response()->json($validatedData);
    }

    public function storeLike(Request $request)
    {
        $validatedData['user_id'] = $request->userID;
        $validatedData['newsPost_id'] = $request->newsID;
        
        NewsLike::create($validatedData);

        return response()->json($validatedData);
    }

    public function show(NewsPost $newsPost)
    {
        return view('news.newsPost', [
            'title' => "News Blog",
            "active" => "newsPosts",
            "newsPost" => $newsPost
        ]);
    }

    public function getAllComment() {
        $id = $_GET['newsID'];
        $comments = NewsComment::latest()->where('newsPost_id', '=', $id)->get();
        return response()->json($comments);
    }

    public function getAllLike() {
        $id = $_GET['newsID'];
        $likes = NewsLike::latest()->where('newsPost_id', '=', $id)->get();
        return response()->json($likes);
    }

    public function edit(NewsPost $newsPost)
    {
        return view('news.editNews', [
            'newsPost' => $newsPost,
            'categories' => Category::all(),
            'title' => "Edit News Blog",
            "active" => "newsPosts"
        ]);
    }

    public function update(Request $request, NewsPost $newsPost)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required' 
        ];

        if($request->slug != $newsPost->slug) {
            $rules['slug'] = 'required|unique:news_posts';
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')) {
            if($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('newsPost-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 100);

        NewsPost::where('id', $newsPost->id)
            ->update($validatedData);

        return redirect('/newsPosts/' . $request->slug)->with('success', 'News blog has been updated!');
    }

    public function updateComment(Request $request)
    {
        $data = [
            'comment' => $request->edited
        ];

        NewsComment::where('id', $request->updateCommentID)
            ->update($data);

        return response()->json($data);
    }

    public function destroy(NewsPost $newsPost)
    {
        if($newsPost->image) {
            Storage::delete($newsPost->image);
        }

        NewsPost::destroy($newsPost->id);
        NewsComment::where('newsPost_id', $newsPost->id)->delete();
        NewsLike::where('newsPost_id', $newsPost->id)->delete();
        return redirect('/newsPosts')->with('success', 'News blog has been deleted!');
    }

    public function destroyComment(Request $request)
    {
        NewsComment::destroy($request->deleteCommentID);

        return response()->json($request);
    }

    public function destroyLike(Request $request)
    {
        NewsLike::destroy($request->deleteLikeID);

        return response()->json($request);
    }

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show', 'getAllComment', 'getAllLike']]);
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(NewsPost::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
