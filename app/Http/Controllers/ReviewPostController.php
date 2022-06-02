<?php

namespace App\Http\Controllers;

use Response;
use \App\Models\User;
use \App\Models\Category;
use App\Models\ReviewLike;
use App\Models\ReviewPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use \App\Models\ReviewComment;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class ReviewPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view('review.reviewPosts', [
            'title' => "Review Blogs" . $title,
            "active" => "reviewPosts",
            "selectCategory" => $selectCategory,
            "selectUser" => $selectUser,
            "categories" => Category::all(),
            "reviewPosts" => ReviewPost::latest()->filter(request(['search', 'category', 'user']))->paginate(7)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('review.createReview', [
            'categories' => Category::all(),
            'title' => "Create Review Blog",
            "active" => "reviewPosts"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:review_posts',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required' 
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('reviewPost-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 100);

        ReviewPost::create($validatedData);

        return redirect('/reviewPosts/' . $request->slug)->with('success', 'Review blog has been created!');
    }

    public function storeComment(Request $request)
    {
        $validatedData = $request->validate([
            'comment' => 'required' 
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['reviewPost_id'] = $request->reviewID;
        
        ReviewComment::create($validatedData);

        // return redirect('/reviewPosts/' . $request->reviewSlug)->with('success', 'Comment has been posted!');
        return response()->json($validatedData);
    }

    public function storeLike(Request $request)
    {
        $validatedData['user_id'] = $request->userID;
        $validatedData['reviewPost_id'] = $request->reviewID;
        
        ReviewLike::create($validatedData);

        return response()->json($validatedData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReviewPost  $reviewPost
     * @return \Illuminate\Http\Response
     */
    public function show(ReviewPost $reviewPost)
    {
        return view('review.reviewPost', [
            'title' => "Review Blog",
            "active" => "reviewPosts",
            "reviewPost" => $reviewPost
        ]);
    }

    public function getAllComment() {
        $id = $_GET['reviewID'];
        $comments = ReviewComment::latest()->where('reviewPost_id', '=', $id)->get();
        return response()->json($comments);
    }

    public function getAllLike() {
        $id = $_GET['reviewID'];
        $likes = ReviewLike::latest()->where('reviewPost_id', '=', $id)->get();
        return response()->json($likes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReviewPost  $reviewPost
     * @return \Illuminate\Http\Response
     */
    public function edit(ReviewPost $reviewPost)
    {
        return view('review.editReview', [
            'reviewPost' => $reviewPost,
            'categories' => Category::all(),
            'title' => "Edit Review Blog",
            "active" => "reviewPosts"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReviewPost  $reviewPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReviewPost $reviewPost)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required' 
        ];

        if($request->slug != $reviewPost->slug) {
            $rules['slug'] = 'required|unique:review_posts';
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')) {
            if($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('reviewPost-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 100);

        ReviewPost::where('id', $reviewPost->id)
            ->update($validatedData);

        return redirect('/reviewPosts/' . $request->slug)->with('success', 'Review blog has been updated!');
    }

    public function updateComment(Request $request)
    {
        $data = [
            'comment' => $request->edited
        ];

        ReviewComment::where('id', $request->updateCommentID)
            ->update($data);

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReviewPost  $reviewPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReviewPost $reviewPost)
    {
        if($reviewPost->image) {
            Storage::delete($reviewPost->image);
        }

        ReviewPost::destroy($reviewPost->id);
        ReviewComment::where('reviewPost_id', $reviewPost->id)->delete();
        ReviewLike::where('reviewPost_id', $reviewPost->id)->delete();
        return redirect('/reviewPosts')->with('success', 'Review blog has been deleted!');
    }

    public function destroyComment(Request $request)
    {
        ReviewComment::destroy($request->deleteCommentID);

        return response()->json($request);
    }

    public function destroyLike(Request $request)
    {
        ReviewLike::destroy($request->deleteLikeID);

        return response()->json($request);
    }

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show', 'getAllComment', 'getAllLike']]);
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(ReviewPost::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
