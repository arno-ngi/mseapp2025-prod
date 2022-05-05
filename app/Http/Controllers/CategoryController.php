<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->tenant->categories()->get();

        return view('categories.index', compact('categories'));
    }

    public function edit(Category $category)
    {
        $category->load('categoryusers');

        $users = User::whereIsActive(true)->whereIsClientvisible(true)->whereTenantId(auth()->user()->tenant_id)->get();

        return view('categories.edit', compact('category', 'users'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category = new Category();
        $category->tenant_id = auth()->user()->tenant_id;
        $category->name = $request->name;
        $category->shortname = $request->shortname;
        $category->save();

        return to_route('categories.index');

    }
    public function update(Category $category, Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category->name = $request->name;
        $category->shortname = $request->shortname;
        $category->save();

        $approvers = $request['approvers'];

        $category->categoryusers()->delete();

        foreach($approvers as $key => $value)
        {
            $categoryuser = new CategoryUser();
            $categoryuser->category_id = $category->id;
            $categoryuser->user_id = $value;
            $categoryuser->save();
        }

        return back();
    }
}
