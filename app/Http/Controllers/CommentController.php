<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|min:1|max:500'
        ]);

        #save in the comments_table
        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $request->post_id;
        $this->comment->comment = $request->comment;
        $this->comment->save();



        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->comment->destroy($id);
        
        return redirect()->back();
    }




}
