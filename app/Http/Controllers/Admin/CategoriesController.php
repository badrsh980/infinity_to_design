<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();
        return Inertia::render('Admin/Category/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Category/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'thumbnail' => 'required|image|max:2048|mimes:png,gif,jpg,jpeg'
        ]);

        $image = "";

        if ($request->thumbnail) {
            $thumbnail = $request->thumbnail;
            try {
                $name = unique_str() . $thumbnail->getClientOriginalName();

                $thumbnail->storeAs('/public/images/', $name);

                $image =  $name;
            } catch (\Throwable $th) {
                return false;
            }
        }

        Category::create([
            'name' => $request->name,
            'slug' => str()->slug($request->name),
            'thumbnail' => $image,
        ]);

        return to_route('admin.categories.index')->with('message', __('Category has been created.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::where('id', $id)->firstOrFail();

        return Inertia::render('Admin/Category/show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::where('id', $id)->firstOrFail();

        return Inertia::render('Admin/Category/edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::where('id', $id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $image = $category->thumbnail;

        if ($request->thumbnail) {
            $request->validate([
                'thumbnail' => 'required|image|max:2048|mimes:png,gif,jpg,jpeg'
            ]);

            $thumbnail = $request->thumbnail;

            try {
                $name = unique_str() . $thumbnail->getClientOriginalName();

                $thumbnail->storeAs('/public/images/', $name);

                $image =  $name;
            } catch (\Throwable $th) {
                return false;
            }
        }

        $category->update([
            'name' => $request->name,
            'slug' => str()->slug($request->name),
            'thumbnail' => $image,
        ]);

        return to_route('admin.categories.index')->with('message', __('Category has been updated.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::where('id', $id)->firstOrFail();

        $category->delete();

        return to_route('admin.categories.index')->with('message', __('Category has been deleted.'));
    }
}
