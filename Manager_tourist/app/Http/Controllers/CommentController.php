<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Trait\DeleteModalTrait;

class CommentController extends Controller
{
    use DeleteModalTrait;
    private $comment;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
    public function index(){
        $comments = $this->comment->latest()->paginate(5);
        return view('admin.comment.index',compact('comments'));
    }
    public function destroy($id){
        if (empty($id)) {
            return view('errors.403');
        }
        return $this->deleteModalTrait($id, $this->comment);
    }
}
