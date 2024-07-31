<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class CommentController extends Controller
{
    public function commentPost(Request $request)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->postId,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'content' => $request->content,
        ]);
        return redirect()->back()->with('ok', 'Bạn đã bình luận thành công');
    }
}
