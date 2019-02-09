<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PagesRequest;

use Session;

class PageController extends Controller
{
    public function index()
    {
        $this -> authorize("view", Page::class);

        $page = Page::paginate();
        return view('admin.pages.index',compact('page'));
    }

    public function create()
    {
        return view('admin.pages.create',compact('page'));
    }

    public function store(PagesRequest $request)
    {
        Page::create($request->all());

        Session::flash("success", "Page was added successfully!");

        return redirect()->route('admin.pages.index');
    }

    public function edit(Page $page)
    {
        $this -> authorize("update", Page::class);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(PagesRequest $request, Page $page)
    {
        $this -> authorize("update", Page::class);

        $page->update($request->all());

        Session::flash("success", "Page was updated successfully!");

        return redirect()->route('admin.pages.index');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        Session::flash("success", "Page was deleted successfully!");

        return redirect()->route('admin.pages.index');
    }
}
