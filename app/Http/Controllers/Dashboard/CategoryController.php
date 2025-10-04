<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Traits\UploadTrait;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{

    use UploadTrait;

    public function __construct()
    {
        $this->middleware(['permission:categories_read'])->only('index');
        $this->middleware(['permission:categories_create'])->only('create');
        $this->middleware(['permission:categories_update'])->only('edit');
        $this->middleware(['permission:categories_delete'])->only(['destroy', 'deleteAll']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withTrashed()->with('parentData')->latest()->paginate(5);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // @dd($request);

        $locales = LaravelLocalization::getSupportedLocales();

        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'parent' => 'nullable',
        ];

        foreach ($locales as $localeCode => $properties) {
            $rules["{$localeCode}.name"] = 'required|string';
            $rules["{$localeCode}.description"] = 'nullable|string';
        }

        $validatedData = $request->validate($rules);

        $category = Category::create($validatedData);

        if ($request->hasFile('image')) {
            $this->verifyAndStoreImage($request, 'image', 'categories', 'upload_image', $category->id, Category::class);
        }

        Alert::toast(__('site.added_successfully'), 'success')->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('dashboard.categories.edit', compact(['category', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $locales = LaravelLocalization::getSupportedLocales();

        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'parent' => 'nullable',
        ];

        foreach ($locales as $localeCode => $properties) {
            $rules["{$localeCode}.name"] = 'required|string';
            $rules["{$localeCode}.description"] = 'nullable|string';
        }

        $validatedData = $request->validate($rules);

        $category->update($validatedData);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                $old_image = $category->image->file;
                $this->Delete_attachment('upload_image', 'categories/' . $old_image, $category->id);
            }
            // Store new image
            $this->verifyAndStoreImage($request, 'image', 'categories', 'upload_image', $category->id, Category::class);
        }

        Alert::toast(__('site.updated_successfully'), 'success')->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
