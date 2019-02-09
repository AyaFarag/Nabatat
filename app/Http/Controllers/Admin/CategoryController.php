<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;

use Session;

class CategoryController extends Controller
{
    public function index()
    {
        $this -> authorize("view", Category::class);

        $category = Category::paginate();
        return view('admin.category.index', compact('category'));
    }

    public function create()
    {
        $this -> authorize("create", Category::class);

        $categories = Category::where('parent_id', null)->pluck('name','id')->all();
        return view('admin.category.create', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $this -> authorize("create", Category::class);

        Category::create($request->all());

        Session::flash("success", "Category was added successfully!");

        return redirect() -> route("admin.category.index");
    }

    public function edit(Category $category)
    {
        $this -> authorize("update", Category::class);

        $categories = Category::where('parent_id', null)->pluck('name','id')->all();
        return view('admin.category.edit', compact('categories' ,'category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this -> authorize("update", Category::class);

        $category->update($request->all());

        Session::flash("success", "Category was updated successfully!");
        return redirect() -> route("admin.category.index");
    }

    public function destroy(Category $category)
    {
        $category->delete();

        Session::flash("success", "Category was deleted successfully!");

        return redirect() -> route("admin.category.index");
    }
}
