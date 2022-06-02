// {{-- @if($reviewComments->count())
//     <ul id="listKomen" class="media-list">
//         @foreach ($reviewComments as $comment)
//             <li id="comment{{ $comment->id }}" class="media">
//                 <div class="media-body">
//                     <span class="pull-right" style="color: #fffccf !important">
//                         <small >{{ $comment->created_at->diffForHumans() }}</small>
//                     </span>
//                     <strong style="color: #8c52ff !important;">{{ $comment->user->name  }}</strong><br>
//                     <span id="isiComment{{ $comment->id }}">{!!  $comment->comment  !!}</span>
//                     <p></p>
//                 </div>
//                 @auth
//                     <div id="action{{ $comment->id }}" class="" style="">
//                         @if ($comment->user_id == auth()->user()->id)
//                             <button type="submit" class="btn font-weight-bold border-0 m-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; height:100%" onclick="editComment({{ $comment->id }}, 'isiComment{{ $comment->id }}', '{!!  $comment->comment  !!}', 'action{{ $comment->id }}', 'comment{{ $comment->id }}')">Edit</button>

//                             <button type="submit" class="btn font-weight-bold border-0 m-0" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none; height:100%" onclick="if(confirm('Are you sure want to delete this comment?')) deleteComment({{ $comment->id }}, 'comment{{ $comment->id }}')">Delete</button>
//                             <p></p>
//                         @endif
//                     </div>
//                 @endauth
//             </li>
//         @endforeach
//     </ul>
// @else
//     <p class="text-center fs-4">No Comment</p>
// @endif         --}}