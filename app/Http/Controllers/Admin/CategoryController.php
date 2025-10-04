<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=\App\Models\BlogCategory::latest()->paginate(10);
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\StoreCategoryRequest $r)
    {
        \App\Models\BlogCategory::create($r->validated());
        return back()->with('ok','Category created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\UpdateCategoryRequest $r,\App\Models\BlogCategory $category)
    {
        $category->update($r->validated()); return back()->with('ok','Category updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\BlogCategory $category)
    {
        $category->delete(); return back()->with('ok','Category deleted.');
    }
}
