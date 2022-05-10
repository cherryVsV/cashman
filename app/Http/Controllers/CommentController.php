<?php

namespace App\Http\Controllers;

use App\Events\CommentEvent;
use App\Models\Comment;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function fetchComments($id)
    {
        $comments = Comment::where('product_id', $id)->get();

        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $comment = Comment::create($request->all());
        if(Auth::check()){
            $profile = UserProfile::where('user_id', Auth::id())->first();
            $comment->avatar = $profile->avatar;
        }else{
            $comment->avatar = 'avatar/1630314076.png';
        }
        $comment->save();
        event(new CommentEvent($comment));
        return response()->json('ok');

    }
}
