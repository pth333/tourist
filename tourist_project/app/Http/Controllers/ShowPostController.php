<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Traits\QueryCommonData;

class ShowPostController extends Controller
{
    use QueryCommonData;
    public function postDetail($id, $slug)
    {
        $commonData = $this->getCommonData();
        $postDetail = Post::find($id);
        $view_posts = $postDetail->view_posts + 1;
        $postDetail->update(['view_posts' => $view_posts]);
        $postNews = Post::latest()->take(9)->get();
        return view('show.post.showDetail', array_merge($commonData, compact('postDetail', 'postNews')));
    }
}
