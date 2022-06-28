@extends('layouts/main')

@section('container')
@if(session()->has('success'))
    <div class="alert alert-success" role="alert" style>
        {{ session('success') }}
    </div>
@endif

<h1 class="mb-3 text-center">
    @if(request('user'))
        Author : {{ $selectUser }}
    @endif
</h1>

<div class="row justify-content-center mb-3">
    <div class="col-md-6">
        <form action="/tipPosts">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <?php
              $user = ""
            ?>
            
            @if(request('user'))
                <input type="hidden" name="user" value="{{ request('user') }}">
                <?php
                    $user = "user=".request('user')."&";
                ?>
            @endif
            <div class="input-group mb-3">
                <input type="text" class="form-control" autocomplete="off" placeholder="Search" name="search" value="{{ request('search') }}">
                <button class="btn" style="background-color: #191919; color: white;" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    
    <div class="dropdown col-md-2 text-center">
        <a class="btn btn-secondary dropdown-toggle text-center " href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"
        style="background-color: #191919; color: white; width: 200px">
            @if($selectCategory==='')
                All Category
            @else
                {{ $selectCategory }}
            @endif
        </a>
            
        <ul class="dropdown-menu col-md-12" aria-labelledby="dropdownMenuLink" style="width: 200px;">
            <li><a class="dropdown-item" href="/tipPosts?{{ str_replace("&","",$user) }}">All Category</a>
            @foreach ($categories as $category)
                <li><a class="dropdown-item" href="/tipPosts?{{ $user }}category={{ $category->slug }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>

<div class="row justify-content-center mb-3">
    @auth
        <div class="col-md-3 text-center">
            <a class="btn text-center" href="/tipPosts?user={{ auth()->user()->username }}" role="button" aria-expanded="false"  style="background-color: #191919; color: white; width: 200px">
                My Tips & Tricks Blogs
            </a>
        </div>
    @else
        <div class="col-md-3 text-center">
            <a class="btn text-center" href="/login" role="button" aria-expanded="false"  style="background-color: #191919; color: white; width: 200px">
                My Tips & Trick Blogs
            </a>
        </div>
    @endauth

    <div class="col-md-3 text-center">
        <a class="btn text-center" href="/tipPosts/create" role="button" aria-expanded="false" style="background-color: #191919; color: white; width: 210px">
            Create Tips & Trick Blog
        </a>
    </div>
</div>

@if($tipPosts->count())
    <div class="card mb-3 text-white" style="background-color: #191919">
        {{-- <div class="text-center" style="background-color: #FBFAF5; color: #191919"> --}}
        <div class="text-center" style="background-color: #8c52ff; color: #fffccf">
            <p><h1>Latest Tips & Trick Blog</h1></p>
        </div>
        <div class="card-body text-center">
            <h3 class="card-title">{{ $tipPosts[0]->title }}</h5>
            
            <p>
                <h4 class="card-text">  
                    <a class="text-decoration-none" href="/tipPosts?user={{ $tipPosts[0]->user->username }}"><strong style="color: #8c52ff !important;">{{ $tipPosts[0]->user->name  }}</strong></a>
                    <br>

                    <a class="text-decoration-none" href="/tipPosts?category={{ $tipPosts[0]->category->slug }}"><strong style="color: #fffccf !important;">{{ $tipPosts[0]->category->name  }}</strong></a>

                    <strong style="color: #fffccf !important"><i class="bi bi-dot" style="color: #fffccf !important"></i></strong>

                    <small style="color: #fffccf !important">{{ $tipPosts[0]->created_at->diffForHumans() }}</small>
                </h4>
            </p>

            {{-- <p class="card-text">{{ Str::limit($tipPosts[0]->excerpt, 100, $end='...') }}</p> --}}
            <p>                   
                <h5 class="card-text">{{ $tipPosts[0]->excerpt }}</h5>
            </p>

            <a href="/tipPosts/{{ $tipPosts[0]->slug }}" class="btn font-weight-bold" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; font-size: 15px">Read More</a>
            
            @auth
                @if ($tipPosts[0]->user_id == auth()->user()->id)
                    <a href="/tipPosts/{{ $tipPosts[0]->slug }}/edit" class="btn font-weight-bold" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; font-size: 15px">Edit</a>

                    {{-- <a href="/tipPosts/{{ $tipPosts[0]->slug }}" class="btn font-weight-bold" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;">Delete</a> --}}

                    <form action="/tipPosts/{{ $tipPosts[0]->slug }}" method="post" class="font-weight-bold mt-auto d-inline">
                        @method('delete')
                        @csrf
                        <button class="btn font-weight-bold border-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;" onclick="return confirm('Are you sure want to delete this blog?')">Delete</button>
                    </form>
                @endif
            @endauth
        </div>

        @if($tipPosts[0]->image)
            <img id="latestimg" src="{{ asset('storage/' . $tipPosts[0]->image) }}" class="card-img-top" alt="{{ $tipPosts[0]->category->name }}">
        @else
            <img id="latestimg" src="https://source.unsplash.com/1200x400?{{ $tipPosts[0]->category->name }}" class="card-img-top" alt="{{ $tipPosts[0]->category->name }}">
        @endif
    </div>

    <div class="container">
        <div class="row">
            @foreach ($tipPosts->skip(1) as $tipPost)
                <div class="col-lg-6 mb-3" >
                    <div class="card" style="height: 100%">
                        <div class="row g-0" style="height: 100%; background-color: #191919; color: white">
                            <div id="viewContainer" class="col-md-5">
                                @if($tipPost->image)
                                    <img id="overview" src="{{ asset('storage/' . $tipPost->image) }}" class="card-img-top" alt="{{ $tipPost->category->name }}">
                                @else
                                    <img id="overview" src="https://source.unsplash.com/350x380?{{ $tipPost->category->name }}" class="card-img-top" alt="{{ $tipPost->category->name }}">
                                @endif
                            </div>
                            <div id="tulisanContainer" class="col-md-7">
                                <div class="card-body" style="height: 100%; display: flex;flex-direction: column;">
                                    <h5 class="card-title">{{ $tipPost->title }}</h5>
                                    
                                    <p class="card-text">
                                        <a class="text-decoration-none" href="/tipPosts?user={{ $tipPost->user->username }}"><strong style="color: #8c52ff !important;">{{ $tipPost->user->name  }}</strong></a>
                                        <br>

                                        <a class="text-decoration-none" href="/tipPosts?category={{ $tipPost->category->slug }}"><strong style="color: #fffccf !important;">{{ $tipPost->category->name  }}</strong></a>

                                        <strong style="color: #fffccf !important"><i class="bi bi-dot" style="color: #fffccf !important"></i></strong>

                                        <small style="color: #fffccf !important">{{ $tipPost->created_at->diffForHumans() }}</small>
                                        <br>
                                    </p>

                                    <p class="card-text">{{ Str::limit($tipPost->excerpt, 100, $end='...') }}</p>
                                    
                                    {{-- <p class="card-text">{{ $tipPost->excerpt }}</p> --}}

                                    <div class="card-text" style="height: 100%; width: fit-content; display: flex; justify-content: flex-end;">
                                        <a href="/tipPosts/{{ $tipPost->slug }}" class="btn font-weight-bold mt-auto" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; font-size: 15px;">Read More</a>

                                        @auth
                                            @if ($tipPost->user_id == auth()->user()->id)
                                                <a href="/tipPosts/{{ $tipPost->slug }}/edit" class="btn font-weight-bold mt-auto mx-1" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; font-size: 15px">Edit</a>

                                                {{-- <a href="/tipPosts/{{ $tipPost->slug }}" class="btn font-weight-bold mt-auto" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;">Delete</a> --}}
                                                <form action="/tipPosts/{{ $tipPost->slug }}" method="post" class="font-weight-bold mt-auto d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn font-weight-bold border-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;" onclick="return confirm('Are you sure want to delete this blog?')">Delete</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@else
    <p class="text-center fs-4">No Blog Found</p>
@endif

<div class="d-flex justify-content-center" style="height: fit-content">
    {{ $tipPosts->links() }}
</div>
@endsection