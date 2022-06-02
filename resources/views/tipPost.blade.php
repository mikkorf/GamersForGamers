@extends('layouts/main')

@section('container')   
    <div class="row mb-3">
        <div class="row justify-content-center mb-5">
            <div id="containerPost" class="col-md-10">
                <h1 class="text-center">{{ $tipPost->title }}</h1>
                
                <div id="infoCont" class="my-4">
                    <h4>
                        <div>
                            <span class="info">Author</span> 
                            <span>: {{ $tipPost->user->name }}</span> 
                        </div>
                        
                        <div>
                            <span class="info">Category</span>
                            <span>: {{  $tipPost->category->name }}</span> 
                        </div>
                        
                        <div>
                            <span class="info">Publish Date</span>
                            <span>: {{ $tipPost->created_at->format('j F Y') }}</span>
                        </div>
                    </h4>
                </div>
                
                <img id="contentimg" src="https://source.unsplash.com/1200x400?{{ $tipPost->category->name }}" alt="{{ $tipPost->category->name }}" class="img-fluid ">

                <article id="postBody" class="mt-4 fs-5 p-4">
                    {!! $tipPost->body !!}
                </article>
                
                
                <a href="{{ URL::previous() }}" class="d-block my-4">
                    <div id="back" class="mx-auto justify-content-center p-3">
                        Back to Blog Overview
                    </div>    
                </a>
                
                <div class="commentContainer">
                    <hr>
                    <div class="row bootstrap snippets bootdeys">
                        <div class="col-sm-12">
                            <div class="comment-wrapper">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        @if($tipComments->count()<2)
                                            {{ $tipComments->count() }} Comment
                                        @else
                                            {{ $tipComments->count() }} Comments
                                        @endif
                                    </div>

                                    <div class="mt-2">
                                        <div id="textarea">
                                            <textarea class="autoExpand" rows='1' data-min-rows='1' placeholder="Write a comment..." autofocus></textarea>
                                        </div>
                                        
                                        <div class="mt-2" style="background-color: black">
                                            <button type="button" class="btn" style="float: right; background-color: #191919; 
                                            color: #FBFAF5;">Comment</button>
                                        </div>
                                        
                                        <div class="clearfix"></div>
                                        <hr>
                                    </div>
                                    <div id="komen" class="panel-body">
                                        @if($tipComments->count())
                                            <ul class="media-list">
                                                @foreach ($tipComments as $comment)
                                                    <li class="media">
                                                        <div class="media-body">
                                                            <span class="pull-right" style="color: #fffccf !important">
                                                                <small >{{ $comment->created_at->diffForHumans() }}</small>
                                                            </span>
                                                            <strong style="color: #8c52ff !important;">{{ $comment->user->name  }}</strong>
                                                            <p>
                                                                {{ $comment->comment }}
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-center fs-4">No Comment</p>
                                        @endif        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection