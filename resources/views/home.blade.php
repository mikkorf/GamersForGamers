{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}

@extends('layouts/main')

@section('home')
{{-- Bagian 1 --}}
<div class="card justify-content-center" 
style="
    background-image: url(/img/background.png);
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    background-position: center; height: 90%"
>
    <div class="container justify-content-center" style="height: fit-content">
        <div class="row justify-content-center">
            {{-- id="logo" --}}
            <div  class="col-md-5" style="width:fit-content"> 
                <img class="img-fluid" src="img/LogoGFG.png" alt="GFG" > 
                {{-- width=600 --}}
            </div>  
            {{-- id="paragraph" --}}
            <div  class="col-md-7 d-flex flex-column justify-content-center">
                <h1 style="font-size: 50px">
                    Welcome to GamersForGamers
                </h1>
                <h6 style="font-size: 5px">
                    {{-- ᲼᲼᲼᲼᲼᲼ --}}
                    <br>
                </h6>
                <h3>
                    GamersForGamers was first launched in December 24, 2022. GFG have an objective of reporting on the latest video game industry news, contents such as reviews, tips & tricks and other kinds of interesting articles for all gamers across the regions, as well becoming the go-to site for everything video game related.
                </h3>
            </div>
        </div>
    </div>
</div>

{{-- Bagian 2 --}}
<div class="card justify-content-center" style="background-color: black; height: 95%">
    <div class="container justify-content-center" style="height: fit-content">
        <div class="row justify-content-center">
            <div class="row mb-2" style="color: white">
                <h1>
                    How to Post Blog
                </h1>
            </div>
            <div class="row justify-content-center" style="width:fit-content;"> 
                <video style="object-fit: cover"   muted autoplay loop>
                    <source src="vid/ComingSoon.mp4" type="video/mp4" />
                </video>
            </div>  
        </div>
    </div>
</div>

{{-- Bagian 3 --}}
</div>
<div class="card justify-content-center p-4" 
    style="
    background-image: url(/img/background.png);
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    background-position: center; ">
    <div class="container justify-content-center">
        <div class="row justify-content-center">
            <div class="row mb-2">
                <h1>
                    Review Blogs
                </h1>
            </div>
            <div class="row justify-content-center" style=""> 
                @if($reviewPosts->count())
                    <div id="demo1" class="carousel slide" data-interval="false" data-bs-ride="carousel" style="">
                        <!-- Indicators/dots -->
                        <div class="carousel-indicators" style="">
                            <button type="button" data-bs-target="#demo1" data-bs-slide-to="0" class="active"></button>
                            
                            @foreach ($reviewPosts->skip(1) as $reviewPost)
                                <button type="button" data-bs-target="#demo1" data-bs-slide-to="{{ $reviewCount }}"></button>
                                <?php
                                    $reviewCount++;
                                ?>
                            @endforeach
                        </div>
                        
                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="card" style="height: 100%; width: 100%">
                                    <div class="row g-0" style="height: 100%; width: 100%; background-color: #191919; color: white">
                                        <div id="viewContainer" class="col-md-4">
                                            <img id="overview" src="https://source.unsplash.com/350x380?{{ $reviewPosts[0]->category->name }}" class="card-img-top" alt="{{ $reviewPosts[0]->category->name }}" style="height: 350px">
                                        </div>
                                        <div id="tulisanContainer" class="col-md-8">
                                            <div class="card-body" style="height: 100%; display: flex;flex-direction: column;">
                                                <h5 class="card-title">{{ $reviewPosts[0]->title }}</h5>
                                                
                                                <p class="card-text">
                                                    <a class="text-decoration-none" href="/reviewPosts?user={{ $reviewPosts[0]->user->username }}"><strong style="color: #8c52ff !important;">{{ $reviewPosts[0]->user->name  }}</strong></a>
                                                    <br>
        
                                                    <a class="text-decoration-none" href="/reviewPosts?category={{ $reviewPosts[0]->category->slug }}"><strong style="color: #fffccf !important;">{{ $reviewPosts[0]->category->name  }}</strong></a>
        
                                                    <strong style="color: #fffccf !important"><i class="bi bi-dot" style="color: #fffccf !important"></i></strong>
        
                                                    <small style="color: #fffccf !important">{{ $reviewPosts[0]->created_at->diffForHumans() }}</small>
                                                </p>
        
                                                {{-- <p class="card-text">{{ Str::limit($reviewPosts[0]->excerpt, 100, $end='...') }}</p> --}}
                                                
                                                <p class="card-text">{{ $reviewPosts[0]->excerpt }}</p>
        
                                                <div class="card-text" style="">
                                                    <a href="/reviewPosts/{{ $reviewPosts[0]->slug }}" id="reviewRead" class="btn font-weight-bold mt-auto" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            @foreach ($reviewPosts->skip(1) as $reviewPost) 
                                <div class="carousel-item" >
                                    <div class="card" style="height: 100%; width: 100%">
                                        <div class="row g-0" style="height: 100%; width: 100%; background-color: #191919; color: white">
                                            <div id="viewContainer" class="col-md-4">
                                                <img id="overview" src="https://source.unsplash.com/350x380?{{ $reviewPost->category->name }}" class="card-img-top" alt="{{ $reviewPost->category->name }}" style="height: 350px">
                                            </div>
                                            <div id="tulisanContainer" class="col-md-8">
                                                <div class="card-body" style="height: 100%; display: flex;flex-direction: column;">
                                                    <h5 class="card-title">{{ $reviewPost->title }}</h5>
                                                    
                                                    <p class="card-text">
                                                        <a class="text-decoration-none" href="/reviewPosts?user={{ $reviewPost->user->username }}"><strong style="color: #8c52ff !important;">{{ $reviewPost->user->name  }}</strong></a>
                                                        <br>

                                                        <a class="text-decoration-none" href="/reviewPosts?category={{ $reviewPost->category->slug }}"><strong style="color: #fffccf !important;">{{ $reviewPost->category->name  }}</strong></a>

                                                        <strong style="color: #fffccf !important"><i class="bi bi-dot" style="color: #fffccf !important"></i></strong>

                                                        <small style="color: #fffccf !important">{{ $reviewPost->created_at->diffForHumans() }}</small>
                                                    </p>

                                                    {{-- <p class="card-text">{{ Str::limit($reviewPost->excerpt, 100, $end='...') }}</p> --}}
                                                    
                                                    <p class="card-text">{{ $reviewPost->excerpt }}</p>

                                                    <div class="card-text" style="">
                                                        <a href="/reviewPosts/{{ $reviewPost->slug }}" class="btn font-weight-bold mt-auto" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;">Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                            <!-- Left and right controls/icons -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#demo1" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#demo1" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                @else
                    <p class="text-center fs-4">No Blog Found</p>
                @endif
            </div>  
        </div>
    </div>
</div>

{{-- Bagian 4 --}}
<div class="card justify-content-center p-4" style="background-color: black;">
    <div class="container justify-content-center">
        <div class="row justify-content-center">
            <div class="row mb-2" style="color:white">
                <h1>
                    Tips & Tricks Blogs
                </h1>
            </div>
            <div class="row justify-content-center" style=""> 
                @if($tipPosts->count())
                    <div id="demo3" class="carousel slide" data-interval="false" data-bs-ride="carousel" style="">
                        <!-- Indicators/dots -->
                        <div class="carousel-indicators" style="">
                            <button type="button" data-bs-target="#demo3" data-bs-slide-to="0" class="active"></button>
                            
                            @foreach ($tipPosts->skip(1) as $tipPost)
                                <button type="button" data-bs-target="#demo3" data-bs-slide-to="{{ $tipCount }}"></button>
                                <?php
                                    $tipCount++;
                                ?>
                            @endforeach
                        </div>
                        
                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="card" style="height: 100%; width: 100%">
                                    <div class="row g-0" style="height: 100%; width: 100%; background-color: #191919; color: white">
                                        <div id="viewContainer" class="col-md-4">
                                            <img id="overview" src="https://source.unsplash.com/350x380?{{ $tipPosts[0]->category->name }}" class="card-img-top" alt="{{ $tipPosts[0]->category->name }}" style="height: 350px">
                                        </div>
                                        <div id="tulisanContainer" class="col-md-8">
                                            <div class="card-body" style="height: 100%; display: flex;flex-direction: column;">
                                                <h5 class="card-title">{{ $tipPosts[0]->title }}</h5>
                                                
                                                <p class="card-text">
                                                    <a class="text-decoration-none" href="/tipPosts?user={{ $tipPosts[0]->user->username }}"><strong style="color: #8c52ff !important;">{{ $tipPosts[0]->user->name  }}</strong></a>
                                                    <br>
        
                                                    <a class="text-decoration-none" href="/tipPosts?category={{ $tipPosts[0]->category->slug }}"><strong style="color: #fffccf !important;">{{ $tipPosts[0]->category->name  }}</strong></a>
        
                                                    <strong style="color: #fffccf !important"><i class="bi bi-dot" style="color: #fffccf !important"></i></strong>
        
                                                    <small style="color: #fffccf !important">{{ $tipPosts[0]->created_at->diffForHumans() }}</small>
                                                </p>
        
                                                {{-- <p class="card-text">{{ Str::limit($tipPosts[0]->excerpt, 100, $end='...') }}</p> --}}
                                                
                                                <p class="card-text">{{ $tipPosts[0]->excerpt }}</p>
        
                                                <div class="card-text" style="">
                                                    <a href="/tipPosts/{{ $tipPosts[0]->slug }}" class="btn font-weight-bold mt-auto" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            @foreach ($tipPosts->skip(1) as $tipPost) 
                                <div class="carousel-item" >
                                    <div class="card" style="height: 100%; width: 100%">
                                        <div class="row g-0" style="height: 100%; width: 100%; background-color: #191919; color: white">
                                            <div id="viewContainer" class="col-md-4">
                                                <img id="overview" src="https://source.unsplash.com/350x380?{{ $tipPost->category->name }}" class="card-img-top" alt="{{ $tipPost->category->name }}" style="height: 350px">
                                            </div>
                                            <div id="tulisanContainer" class="col-md-8">
                                                <div class="card-body" style="height: 100%; display: flex;flex-direction: column;">
                                                    <h5 class="card-title">{{ $tipPost->title }}</h5>
                                                    
                                                    <p class="card-text">
                                                        <a class="text-decoration-none" href="/tipPosts?user={{ $tipPost->user->username }}"><strong style="color: #8c52ff !important;">{{ $tipPost->user->name  }}</strong></a>
                                                        <br>

                                                        <a class="text-decoration-none" href="/tipPosts?category={{ $tipPost->category->slug }}"><strong style="color: #fffccf !important;">{{ $tipPost->category->name  }}</strong></a>

                                                        <strong style="color: #fffccf !important"><i class="bi bi-dot" style="color: #fffccf !important"></i></strong>

                                                        <small style="color: #fffccf !important">{{ $tipPost->created_at->diffForHumans() }}</small>
                                                    </p>

                                                    {{-- <p class="card-text">{{ Str::limit($tipPost->excerpt, 100, $end='...') }}</p> --}}
                                                    
                                                    <p class="card-text">{{ $tipPost->excerpt }}</p>

                                                    <div class="card-text" style="">
                                                        <a href="/tipPosts/{{ $tipPost->slug }}" class="btn font-weight-bold mt-auto" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;">Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                            <!-- Left and right controls/icons -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#demo3" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#demo3" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                @else
                    <p class="text-center fs-4">No Blog Found</p>
                @endif
            </div>  
        </div>
    </div>
</div>

{{-- Bagian 5 --}}
<div class="card justify-content-center p-4"
    style="
        background-image: url(/img/background.png);
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
        background-position: center; ">
    <div class="container justify-content-center">
        <div class="row justify-content-center">
            <div class="row mb-2" style="color: black">
                <h1>
                    News
                </h1>
            </div>
            <div class="row justify-content-center" style=""> 
                @if($newsPosts->count())
                    <div id="demo4" class="carousel slide" data-interval="false" data-bs-ride="carousel" style="">
                        <!-- Indicators/dots -->
                        <div class="carousel-indicators" style="">
                            <button type="button" data-bs-target="#demo4" data-bs-slide-to="0" class="active"></button>
                            
                            @foreach ($newsPosts->skip(1) as $newsPost)
                                <button type="button" data-bs-target="#demo4" data-bs-slide-to="{{ $newsCount }}"></button>
                                <?php
                                    $newsCount++;
                                ?>
                            @endforeach
                        </div>
                        
                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="card" style="height: 100%; width: 100%">
                                    <div class="row g-0" style="height: 100%; width: 100%; background-color: #191919; color: white">
                                        <div id="viewContainer" class="col-md-4">
                                            <img id="overview" src="https://source.unsplash.com/350x380?{{ $newsPosts[0]->category->name }}" class="card-img-top" alt="{{ $newsPosts[0]->category->name }}" style="height: 350px">
                                        </div>
                                        <div id="tulisanContainer" class="col-md-8">
                                            <div class="card-body" style="height: 100%; display: flex;flex-direction: column;">
                                                <h5 class="card-title">{{ $newsPosts[0]->title }}</h5>
                                                
                                                <p class="card-text">
                                                    <a class="text-decoration-none" href="/newsPosts?user={{ $newsPosts[0]->user->username }}"><strong style="color: #8c52ff !important;">{{ $newsPosts[0]->user->name  }}</strong></a>
                                                    <br>
        
                                                    <a class="text-decoration-none" href="/newsPosts?category={{ $newsPosts[0]->category->slug }}"><strong style="color: #fffccf !important;">{{ $newsPosts[0]->category->name  }}</strong></a>
        
                                                    <strong style="color: #fffccf !important"><i class="bi bi-dot" style="color: #fffccf !important"></i></strong>
        
                                                    <small style="color: #fffccf !important">{{ $newsPosts[0]->created_at->diffForHumans() }}</small>
                                                </p>
        
                                                {{-- <p class="card-text">{{ Str::limit($newsPosts[0]->excerpt, 100, $end='...') }}</p> --}}
                                                
                                                <p class="card-text">{{ $newsPosts[0]->excerpt }}</p>
        
                                                <div class="card-text" style="">
                                                    <a href="/newsPosts/{{ $newsPosts[0]->slug }}" class="btn font-weight-bold mt-auto" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            @foreach ($newsPosts->skip(1) as $newsPost) 
                                <div class="carousel-item" >
                                    <div class="card" style="height: 100%; width: 100%">
                                        <div class="row g-0" style="height: 100%; width: 100%; background-color: #191919; color: white">
                                            <div id="viewContainer" class="col-md-4">
                                                <img id="overview" src="https://source.unsplash.com/350x380?{{ $newsPost->category->name }}" class="card-img-top" alt="{{ $newsPost->category->name }}" style="height: 350px">
                                            </div>
                                            <div id="tulisanContainer" class="col-md-8">
                                                <div class="card-body" style="height: 100%; display: flex;flex-direction: column;">
                                                    <h5 class="card-title">{{ $newsPost->title }}</h5>
                                                    
                                                    <p class="card-text">
                                                        <a class="text-decoration-none" href="/newsPosts?user={{ $newsPost->user->username }}"><strong style="color: #8c52ff !important;">{{ $newsPost->user->name  }}</strong></a>
                                                        <br>

                                                        <a class="text-decoration-none" href="/newsPosts?category={{ $newsPost->category->slug }}"><strong style="color: #fffccf !important;">{{ $newsPost->category->name  }}</strong></a>

                                                        <strong style="color: #fffccf !important"><i class="bi bi-dot" style="color: #fffccf !important"></i></strong>

                                                        <small style="color: #fffccf !important">{{ $newsPost->created_at->diffForHumans() }}</small>
                                                    </p>

                                                    {{-- <p class="card-text">{{ Str::limit($newsPost->excerpt, 100, $end='...') }}</p> --}}
                                                    
                                                    <p class="card-text">{{ $newsPost->excerpt }}</p>

                                                    <div class="card-text" style="">
                                                        <a href="/newsPosts/{{ $newsPost->slug }}" class="btn font-weight-bold mt-auto" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;">Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                            <!-- Left and right controls/icons -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#demo4" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#demo4" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                @else
                    <p class="text-center fs-4">No Blog Found</p>
                @endif
            </div>  
        </div>
    </div>
</div>
@endsection