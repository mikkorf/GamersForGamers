@extends('layouts/main')

@section('container')
    @auth
        <input id="authUserID" type="hidden" name="authUserID" value="{{ auth()->user()->id }}">
    @endauth
    <div class="row mb-3">
        <div class="row justify-content-center mb-5">
            <div id="containerPost" class="col-md-10">
                @if(session()->has('success'))
                    <div class="alert alert-success" role="alert" style>
                        {{ session('success') }}
                    </div>
                @endif
                
                <h1 class="text-center">{{ $newsPost->title }}</h1>
                
                <div id="infoCont" class="my-4">
                    <h4>
                        <div>
                            <span class="info">Author</span> 
                            <span>: {{ $newsPost->user->name }}</span> 
                        </div>
                        
                        <div>
                            <span class="info">Category</span>
                            <span>: {{  $newsPost->category->name }}</span> 
                        </div>
                        
                        <div>
                            <span class="info">Publish Date</span>
                            <span>: {{ $newsPost->created_at->format('j F Y') }}</span>
                        </div>
                        <div id="like">
                            {{-- <form id="addLike" method="post">
                                @csrf
                                <input id="newsIDLike" type="hidden" name="newsID" value="{{ $newsPost->id }}">
                                <input id="userIDLike" type="hidden" name="userID" value="{{ auth()->user()->id }}">
                                <button id="submit_like" type="submit" class="btn" style="font-size : 25px;">
                                    <i class="bi bi-hand-thumbs-up"></i>
                                    <span id="likeCount">qwqw</span>
                                </button>
                            </form> --}}
                        </div>
                    </h4>
                    
                </div>

                <div class="mb-2" style="">
                    @auth
                        @if ($newsPost->user_id == auth()->user()->id)
                            <a href="/newsPosts/{{ $newsPost->slug }}/edit" class="btn font-weight-bold m-0 ml-1" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; font-size: 15px">Edit</a>
                            <form action="/newsPosts/{{ $newsPost->slug }}" method="post" class="font-weight-bold bg-dark d-inline m-0" style="height:100px">
                                @method('delete')
                                @csrf
                                <button class="btn font-weight-bold border-0 m-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; height:100%" onclick="return confirm('Are you sure want to delete this blog?')">Delete</button>
                            </form>
                        @endif
                    @endauth
                </div>

                @if ($newsPost->image)
                    <img id="contentimg" src="{{ asset('storage/' . $newsPost->image) }}" alt="{{ $newsPost->category->name }}" class="img-fluid ">
                @else
                    <img id="contentimg" src="https://source.unsplash.com/1200x400?{{ $newsPost->category->name }}" alt="{{ $newsPost->category->name }}" class="img-fluid ">
                @endif
                

                <article id="postBody" class="mt-4 fs-5 p-4">
                    {!! $newsPost->body !!}
                </article>
                
                
                <a href="{{ URL::previous() }}" class="d-block my-4">
                    <div id="back" class="mx-auto justify-content-center p-3">
                        Back to Previous Page
                    </div>    
                </a>
                
                <div class="commentContainer">
                    <hr>
                    <div class="row bootstrap snippets bootdeys">
                        <div class="col-sm-12">
                            <div class="comment-wrapper">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <span id="total"></span> <span id="totalInfo"></span>
                                    </div>
                                    {{-- action="/newsPosts/{{ $newsPost->slug }}/storeComment" --}}
                                    <div class="mt-2">
                                        <form id="addComment" 
                                        {{-- action = "/newsPosts/{{ $newsPost->slug }}/storeComment"  --}}
                                        method="post">
                                            @csrf
                                            <input id="newsID" type="hidden" name="newsID" value="{{ $newsPost->id }}">
                                            <input id="newsSlug" type="hidden" name="newsSlug" value="{{ $newsPost->slug }}">
                                            @auth
                                                <div id="textarea">
                                                    <input id="comment" type="hidden" name="comment" required>
                                                    <trix-editor id="trixComment" input="comment" 
                                                    onkeyup="enablebtn('comment', 'submit_comment')" style="background-color: white; color: black;" placeholder="Write a comment..." required></trix-editor>
                                                </div>
                                            @else
                                                <div id="textarea" class="text-center">
                                                    <a href="/login" style="text-decoration: underline; color: blue">You must be logged in to comment.</a>
                                                    {{-- <input id="comment" type="hidden" name="comment" required>
                                                    <trix-editor id="trixComment" input="comment" 
                                                    onkeyup="enablebtn('comment', 'submit_comment')" style="background-color: white; color: black;" placeholder="Write a comment..." required></trix-editor> --}}
                                                </div>
                                            @endauth
                                            
                                            <div class="mt-2" style="background-color: black">
                                                @auth
                                                    <button id="submit_comment" type="submit" class="btn" style="float: right; background-color: #191919; color: #FBFAF5;" disabled>Comment</button>
                                                {{-- @else
                                                    <a  href="/login" id="submit_comment" class="btn" style="float: right; background-color: #191919; color: #FBFAF5; font-size: 15px;">Comment</a> --}}
                                                @endauth
                                            </div>
                                            <div class="clearfix"></div>
                                        </form>
                                    </div>
                                    <hr>
                                    <div id="komen" class="panel-body" style="">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var id = parseInt(document.getElementById('newsID').value.toString());
        var slug = document.getElementById('newsSlug').value.toString();

        @auth
            var authUserID = parseInt(document.getElementById('authUserID').value.toString());
        @endauth

        $(document).ready(function() {
            getAllComment();
            getAllLike();
        });

        function getAllLike() {
            $.get("{{ url('/newsPosts/${slug}/getAllLike') }}", {newsID: id}, function(response, status) {
                console.log(response);
                var flag = 0;

                @auth
                    for(var i = 0; i < response.length; i++) {
                        if(response[i].user_id.toString() == authUserID) {
                            flag = 1;

                            document.getElementById('like').innerHTML = 
                            `<input id="newsIDLike" type="hidden" name="newsID" value="${id}">
                            <input id="userIDLike" type="hidden" name="userID" value="${authUserID}">
                            <button id="submit_like" type="submit" class="btn" style="font-size : 25px; outline: none;box-shadow: none;" onclick="deleteLike(${response[i].id})">
                                <i class="bi bi-hand-thumbs-up-fill"></i>
                                <span id="likeCount">${response.length}</span>
                            </button>`;

                            break;
                        }
                        else {
                            flag = 0;
                        }
                    }

                    if(flag == 0) {
                        document.getElementById('like').innerHTML = 
                            `<input id="newsIDLike" type="hidden" name="newsID" value="${id}">
                            <input id="userIDLike" type="hidden" name="userID" value="${authUserID}">
                            <button id="submit_like" type="submit" class="btn" style="font-size : 25px; outline: none;box-shadow: none;" onclick="storeLike(${authUserID}, ${id})">
                                <i class="bi bi-hand-thumbs-up"></i>
                                <span id="likeCount">${response.length}</span>
                            </button>`;
                    }
                @else
                    document.getElementById('like').innerHTML = 
                        `<form action="/login">
                            <button id="submit_like" type="submit" class="btn" style="font-size : 25px; outline: none;box-shadow: none;" >
                                <i class="bi bi-hand-thumbs-up"></i>
                                <span id="likeCount">${response.length}</span>
                            </button>
                        </form>`;
                @endauth
            });
        }

        function storeLike(IDuser, IDnews) {
            event.preventDefault();
            $.ajax({
                url: '/newsPosts/' + slug + '/storeLike',
                type: 'post',
                data: {userID : IDuser, newsID : IDnews, _token : '{{csrf_token()}}'},
                dataType: 'json',
                success: function(data) {
                    getAllLike();
                }
            }); 
        }

        function enablebtn(fieldID, btnID) {
            // console.log(btnID);
            if(document.getElementById(fieldID).value==="") { 
                document.getElementById(btnID).disabled = true; 
            } else { 
                document.getElementById(btnID).disabled = false;
            }
        } 

        function cleanString(comment) {
            var regex = /(<([^>]+)>)/ig;
            var check = comment.replace(/&nbsp;/g, '');
            check = check.replace(regex, "");
            check = check.replace(/\s+/g, '');
            return check;
        }

        function getAllComment() {
            $.get("{{ url('/newsPosts/${slug}/getAllComment') }}", {newsID: id}, function(response, status) {
                console.log(response);
                document.getElementById('komen').innerHTML = "";
                document.getElementById('total').innerHTML = response.length;

                if(response.length >= 1) {
                    document.getElementById('komen').innerHTML = `<ul id="listKomen" class="media-list"></ul>`;
                    document.getElementById('listKomen').innerHTML = "";

                    if(response.length == 1) {
                        document.getElementById('totalInfo').innerHTML = "Comment";
                    }
                    else {
                        document.getElementById('totalInfo').innerHTML = "Comments";
                    }

                    for(var i = 0; i < response.length; i++) {
                        var created = response[i].created_at;
                        created = created.substring(0, created.indexOf('T'));

                        @auth
                            if(parseInt(response[i].user.id) == authUserID) {
                                document.getElementById('listKomen').innerHTML +=
                                    `<li class="media">
                                        <div class="media-body">
                                            <strong style="color: #fffccf !important;">${response[i].user.username}</strong>
                                            <span class="pull-right" style="color: #fffccf !important">
                                                <small>commented at ${created}</small>
                                            </span><br>
                                            <span id="isiComment${response[i].id}">${response[i].comment}</span>
                                            <p></p>
                                        </div>
                                        <div id="action${response[i].id}" class="" style="">
                                            <button type="submit" class="btn font-weight-bold border-0 m-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; height:100%" onclick="editComment(${response[i].id}, 'isiComment${response[i].id}', '${response[i].comment}', 'action${response[i].id}')">Edit</button>

                                            <button type="submit" class="btn font-weight-bold border-0 m-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; height:100%" onclick="if(confirm('Are you sure want to delete this comment?')) deleteComment(${response[i].id})">Delete</button>
                                            <p></p>
                                        </div>
                                    </li>`;
                            }
                            else {
                                document.getElementById('listKomen').innerHTML +=
                                    `<li class="media">
                                        <div class="media-body">
                                            <strong style="color: #fffccf !important;">${response[i].user.username}</strong>
                                            <span class="pull-right" style="color: #fffccf !important">
                                                <small>commented at ${created}</small>
                                            </span><br>
                                            <span id="isiComment${response[i].id}">${response[i].comment}</span>
                                            <p></p>
                                        </div>
                                    </li>`;
                            }
                        @else
                            document.getElementById('listKomen').innerHTML +=
                                `<li class="media">
                                    <div class="media-body">
                                        <strong style="color: #fffccf !important;">${response[i].user.username}</strong>
                                        <span class="pull-right" style="color: #fffccf !important">
                                            <small>commented at ${created}</small>
                                        </span><br>
                                        <span id="isiComment${response[i].id}">${response[i].comment}</span>
                                        <p></p>
                                    </div>
                                </li>`;
                        @endauth 
                    }
                }
                else {
                    document.getElementById('totalInfo').innerHTML = "Comment";
                    document.getElementById('komen').innerHTML = `<p class="text-center fs-4">No Comment</p>`;
                }
            });
        }

        $('form#addComment').submit(function( event ) {
            event.preventDefault();
            var comment = document.getElementById('comment').value.toString();
            check = cleanString(comment);
            if(check.length!=0) {
                $.ajax({
                    url: '/newsPosts/' + slug + '/storeComment',
                    type: 'post',
                    data: $('form#addComment').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        getAllComment();
                    }
                }); 
                
                document.getElementById('comment').value = "";
                document.getElementById('trixComment').value = "";

                var count = parseInt(document.getElementById('total').innerHTML.toString())+1;
                document.getElementById('total').innerHTML = count;

                if(count > 1) {
                    document.getElementById('totalInfo').innerHTML = "Comments";
                }

                document.getElementById("comment").value="";
                document.getElementById('submit_comment').disabled = true;
            }
        });

        function deleteComment(deleteID) {
            $.ajax({
                url: '/newsPosts/' + slug + '/destroyComment',
                type: 'post',
                data: {deleteCommentID : deleteID, _token : '{{csrf_token()}}'},
                dataType: 'json',
                success: function(data) {
                    getAllComment();
                }
            }); 

            var count = parseInt(document.getElementById('total').innerHTML.toString())-1;
            document.getElementById('total').innerHTML = count;

            if(count <= 1) {
                document.getElementById('totalInfo').innerHTML = "Comment";
            }
        }

        function deleteLike(likeID) {
            $.ajax({
                url: '/newsPosts/' + slug + '/destroyLike',
                type: 'post',
                data: {deleteLikeID : likeID, _token : '{{csrf_token()}}'},
                dataType: 'json',
                success: function(data) {
                    getAllLike();
                }
            }); 
        }
        
        function enablebtnUpdate(fieldID, btnID, isi, newID) {
            if(document.getElementById(fieldID).value==="" || isi.toString() == document.getElementById(newID).value.toString()) { 
                document.getElementById(btnID).disabled = true;
            } else { 
                document.getElementById(btnID).disabled = false;
            }
        }  

        function editComment(editID, commentID, isi, action) {
            document.getElementById(commentID).innerHTML = 
                `<div id="textarea">
                    <input id="editComment${editID}" type="hidden" name="comment" value="${isi}" required>
                    <trix-editor id="trixComment${editID}" input="editComment${editID}" style="background-color: white; color: black;" placeholder="Write a comment..." onkeyup="enablebtnUpdate('editComment${editID}', 'submit_comment${editID}', '${isi}', 'editComment${editID}')" required></trix-editor>    
                </div>`;
            
            document.getElementById(action).innerHTML = 
                `<button id="submit_comment${editID}" type="submit" class="btn font-weight-bold border-0 m-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; height:100%" onclick="if(confirm('Are you sure want to update this comment?')) updateComment('${editID}', '${commentID}', '${action}')" disabled>Update</button>
                        
                <button type="submit" class="btn font-weight-bold border-0 m-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; height:100%" onclick="cancelEditComment('${editID}', '${commentID}', '${isi}', '${action}')">Cancel</button>
        
                <button type="submit" class="btn font-weight-bold border-0 m-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; height:100%" onclick="if(confirm('Are you sure want to delete this comment?')) deleteComment('${editID}')">Delete</button>
                <p></p>`;
        }

        function updateComment(editID, commentID, action) {
            var editComment = document.getElementById(`editComment${editID}`).value.toString();
            var checkEdit = cleanString(editComment);

            if(checkEdit.length!=0) {
                $.ajax({
                    url: '/newsPosts/' + slug + '/updateComment',
                    type: 'post',
                    data: {updateCommentID : editID, edited : editComment, _token : '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        getAllComment();
                    }
                }); 
            }
        }

        function cancelEditComment(editID, commentID, isi, action) {
            document.getElementById(commentID).innerHTML = `${isi}`;

            document.getElementById(action).innerHTML = 
                `<button type="submit" class="btn font-weight-bold border-0 m-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; height:100%" onclick="editComment('${editID}', '${commentID}', '${isi}', '${action}')">Edit</button>

                <button type="submit" class="btn font-weight-bold border-0 m-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; height:100%" onclick="if(confirm('Are you sure want to delete this comment?')) deleteComment('${editID}')">Delete</button>
                <p></p>`;
        }
    </script>
@endsection