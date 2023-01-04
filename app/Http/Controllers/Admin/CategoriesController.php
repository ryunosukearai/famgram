<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $all_categories = $this->category->paginate(5);  //->withTrashed()->latest()->paginate(4)


        return view('admin.categories.index')->with('all_categories', $all_categories);
    }

    public function store(Request $request)
    {
        // $this->category->id = $request->id;


        $this->category->name = $request->name;
        $this->category->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->category->destroy($id);
        return redirect()->back();
    }
}
