<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    private $post;
    private $category;
    private $comment;
    const LOCAL_STORAGE_FOLDER = 'public/images/';

    public function __construct(Post $post, Category $category, Comment $comment)
    {
        $this->post = $post;
        $this->category = $category;
        $this->comment = $comment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $all_categories = $this->category->all();
        $all_categories = Category::all();
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|array|between:1,3',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:1048',
            'description' => 'required|min:1|max:1000'
        ]);

        #Save in the post table
        $this->post->user_id = Auth::user()->id;
        $this->post->image = $this->saveImage($request);
        $this->post->description = $request->description;
        $this->post->save();

        #Save in category_post table
        // creating an array for selected categories
        foreach($request->category as $category_id):
            $category_post[] = ["category_id"=>$category_id];
        endforeach;
        $this->post->categoryPost()->createMany($category_post);

        return redirect()->route('index');

        // return $request;
        // 詳細が画面に表示される
    }

    public function saveImage($request)
    {
        #save image later
        #rename the file.
        $image_name = time() . "." . $request->image->extension();
        #example = 1234567890.png
        #upload
        $request->image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);
        #public/images/1234567890.png

        return $image_name;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->post->findOrFail($id);

        return view('users.posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post = $this->post->findOrFail($id);

        if($post->user->id != Auth::user()->id){
            return redirect()->route('index');
        }

        $all_categories = $this->category->all();
        $selected_categories = [];

        foreach($post->categoryPost as $category_post):
            $selected_categories[] = $category_post->category_id;
        endforeach;


        return view('users.posts.edit')
            ->with('all_categories', $all_categories)
            ->with('post', $post)
            ->with('selected_categories', $selected_categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|array|between:1,3',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:1048',
            'description' => 'required|min:1|max:1000'
        ]);

        #Save in the post table
        // $post->id = $request->id;
        $post =  $this->post->findOrFail($id);
        $post->description = $request->description;


        #delete the existing image
        if($request->image){
            #delete the image
            $this->deleteImage($post->image);

            #uplload the image
            $post->image = $this->saveImage($request);
        }

        $post->save();

        #categories
        #deletethe old selected categories
        $post->categoryPost()->delete();
        #save the one

        foreach($request->category as $category_id):
            $category_post[] = ["category_id"=>$category_id];
        endforeach;
        $post->categoryPost()->createMany($category_post);

        return redirect()->route('post.show',$id);
    }

    public function deleteImage($image_name)
    {
        $image_path = self::LOCAL_STORAGE_FOLDER . $image_name;

        if(Storage::disk('local')->exists($image_path)){
            Storage::disk('local')->delete($image_path);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->post->destroy($id);

        return redirect()->route('index');
    }
}
