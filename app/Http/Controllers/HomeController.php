<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use App\Models\Comment;

class HomeController extends Controller
{
    private $post;
    //private $comment;

    public function __construct(Post $post, User $user) #, Comment $comment
    {
        $this->post = $post;
        $this->user = $user;
        // $this->comment = $comment;
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_posts = $this->post->latest()->get(); //get all posts inside posts table
        $home_posts = [];
        $suggested_users = $this->suggestedUsers();

        foreach($all_posts as $post):
            //filter
            if($post->user->isFollowed() OR $post->user->id === Auth::user()->id):
                $home_posts[] = $post;
            endif;
        endforeach;

        // $all_comment = $this->comment->latest()->get();
        return view('users.home')
            ->with('all_posts', $home_posts)
            ->with('suggested_users', $suggested_users); #->with('all_comment', $all_comment)
    }

    public function SuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach($all_users as $user):
            if(!$user->isFollowed()): //if user is NOT (!) followed
                $suggested_users[] = $user;
            endif;
        endforeach;

        return $suggested_users;
    }
}

// $this->post->user_id = Auth::user()->id;
//         $this->post->image = $this->saveImage($request);
//         $this->post->description = $request->description;
//         $this->post->save();

//         #Save in category_post table
//         // creating an array for selected categories
//         foreach($request->category as $category_id):
//             $category_post[] = ["category_id"=>$category_id];
//         endforeach;
//         $this->post->categoryPost()->createMany($category_post);

//         return redirect()->route('index');
