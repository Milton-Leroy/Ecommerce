<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
            "icon" => ['required', 'not_in:empty' ,'string', 'max:50'],
            "name" => ['required', 'string', 'max:200', 'unique:categories,name'],
            "status" => ['required', 'boolean'],
       ]);

       $category = new Category();
       $category->icon = $request->icon ;
       $category->name = $request->name ;
       $category->slug = Str::slug($request->name);
       $category->status = $request->status ;
       $category->save();

       toastr()->success('Created Successfully!');

       return to_route('admin.category.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "icon" => ['required', 'not_in:empty' ,'string', 'max:50'],
            "name" => ['required', 'string', 'max:200', 'unique:categories,name,'.$id],
            "status" => ['required', 'boolean'],
       ]);

       $category = Category::findOrFail($id);

       $category->icon = $request->icon ;
       $category->name = $request->name ;
       $category->slug = Str::slug($request->name);
       $category->status = $request->status ;
       $category->save();

       toastr()->success('Updated Successfully!');

       return to_route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
