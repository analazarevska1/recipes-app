<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function save(Request $request,Post $post){
        Comment::create([
            'user_id'=>auth()->id(),
            'post_id'=>$post->id,
            'comment'=>$request->comment_text
        ]);
        return redirect()->back();
    }

    public function destroy(Comment $comment){
        $comment->delete();
        return redirect()->back();
    }
    
}
