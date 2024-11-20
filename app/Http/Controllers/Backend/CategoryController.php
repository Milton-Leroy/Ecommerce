<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "icon" => ['required', 'not_in:empty', 'string', 'max:50'],
            "name" => ['required', 'string', 'max:200', 'unique:categories,name'],
            "status" => ['required', 'boolean'],
        ]);

        $category = new Category();
        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
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
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            "icon" => ['required', 'not_in:empty', 'string', 'max:50'],
            "name" => ['required', 'string', 'max:200', 'unique:categories,name,' . $id],
            "status" => ['required', 'boolean'],
        ]);

        $category = Category::findOrFail($id);

        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr()->success('Updated Successfully!');

        return to_route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        $category =  Category::findOrFail($id);
        $subCategory = SubCategory::where('category_id', $category->id)->count();

        if($subCategory > 0){
            return response(['status' => 'error', 'message' => 'This item contains sub items, to delete it, delete
             all sub items first!']);
        }

        $category->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    //This is used for automatic enabling and disabling of categories in this case via ajax
    public function changeStatus(Request $request): Response
    {
        $category = Category::findOrFail($request->id);

        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['status' => 'success', 'message' => 'Status updated sucessfully!']);
    }
}
