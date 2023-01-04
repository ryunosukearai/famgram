<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'likemark' => 'required|min:1|max:5000'
        // ]);

        #sava in the like table
        $this->like->user_id = Auth::user()->id; // $this->like->user_id = Auth::id();
        $this->like->post_id = $request->post_id;

        $this->like->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->like->where('post_id', $id)->where('user_id', Auth::user()->id)->delete();

        return redirect()->back();
    }


}
