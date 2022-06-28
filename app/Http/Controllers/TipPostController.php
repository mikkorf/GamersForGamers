<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TipPost;
use \App\Models\Category;
use App\Models\TipLike;
use App\Models\TipComment;
use \App\Models\User;
use Illuminate\Support\Str;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;

class TipPostController extends Controller
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
        return view('tip.tipPosts', [
            'title' => "Tips & Tricks Blogs" . $title,
            "active" => "tipPosts",
            "selectCategory" => $selectCategory,
            "selectUser" => $selectUser,
            "categories" => Category::all(),
            "tipPosts" => TipPost::latest()->filter(request(['search', 'category', 'user']))->paginate(7)->withQueryString()
        ]);
    }

    public function create()
    {
        return view('tip.createTip', [
            'categories' => Category::all(),
            'title' => "Create Tips & Tricks Blog",
            "active" => "tipPosts"
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:tip_posts',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required' 
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('tipPost-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 100);

        TipPost::create($validatedData);

        return redirect('/tipPosts/' . $request->slug)->with('success', 'Tips & tricks blog has been created!');
    }

    public function storeComment(Request $request)
    {
        $validatedData = $request->validate([
            'comment' => 'required' 
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['tipPost_id'] = $request->tipID;
        
        TipComment::create($validatedData);

        return response()->json($validatedData);
    }

    public function storeLike(Request $request)
    {
        $validatedData['user_id'] = $request->userID;
        $validatedData['tipPost_id'] = $request->tipID;
        
        TipLike::create($validatedData);

        return response()->json($validatedData);
    }

    public function show(TipPost $tipPost)
    {
        return view('tip.tipPost', [
            'title' => "Tips & Tricks Blog",
            "active" => "tipPosts",
            "tipPost" => $tipPost
        ]);
    }

    public function getAllComment() {
        $id = $_GET['tipID'];
        $comments = TipComment::latest()->where('tipPost_id', '=', $id)->get();
        return response()->json($comments);
    }

    public function getAllLike() {
        $id = $_GET['tipID'];
        $likes = TipLike::latest()->where('tipPost_id', '=', $id)->get();
        return response()->json($likes);
    }

    public function edit(TipPost $tipPost)
    {
        return view('tip.editTip', [
            'tipPost' => $tipPost,
            'categories' => Category::all(),
            'title' => "Edit Tips & Tricks Blog",
            "active" => "tipPosts"
        ]);
    }

    public function update(Request $request, TipPost $tipPost)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required' 
        ];

        if($request->slug != $tipPost->slug) {
            $rules['slug'] = 'required|unique:tip_posts';
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')) {
            if($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('tipPost-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 100);

        TipPost::where('id', $tipPost->id)
            ->update($validatedData);

        return redirect('/tipPosts/' . $request->slug)->with('success', 'Tips & tricks blog has been updated!');
    }

    public function updateComment(Request $request)
    {
        $data = [
            'comment' => $request->edited
        ];

        TipComment::where('id', $request->updateCommentID)
            ->update($data);

        return response()->json($data);
    }

    public function destroy(TipPost $tipPost)
    {
        if($tipPost->image) {
            Storage::delete($tipPost->image);
        }

        TipPost::destroy($tipPost->id);
        TipComment::where('tipPost_id', $tipPost->id)->delete();
        TipLike::where('tipPost_id', $tipPost->id)->delete();
        return redirect('/tipPosts')->with('success', 'Tips & Tricks blog has been deleted!');
    }

    public function destroyComment(Request $request)
    {
        TipComment::destroy($request->deleteCommentID);

        return response()->json($request);
    }

    public function destroyLike(Request $request)
    {
        TipLike::destroy($request->deleteLikeID);

        return response()->json($request);
    }

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show', 'getAllComment', 'getAllLike']]);
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(TipPost::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
