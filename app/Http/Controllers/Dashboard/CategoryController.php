<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Exports\CategoriesExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends Controller
{

    use UploadTrait;

    public function __construct()
    {
        $this->middleware(['permission:categories_read'])->only('index', 'export');
        $this->middleware(['permission:categories_create'])->only('create');
        $this->middleware(['permission:categories_update'])->only('edit');
        $this->middleware(['permission:categories_delete'])->only(['destroy', 'restore', 'forceDelete', 'deleteAll']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $categories = Category::withTrashed()->with('parentData')->latest()->paginate(5);

        $categories = Category::withTrashed()
            ->with(['parentData', 'translations'])
            ->where(function ($q) use ($request) {
                return $q->when($request->search, function ($query) use ($request) {
                    // بحث في الاسم والوصف (بناءً على الترجمة)
                    $query->whereTranslationLike('name', '%' . $request->search . '%')
                        ->orWhereTranslationLike('description', '%' . $request->search . '%')
                        // أو نبحث عن الاسم في تصنيف الأب
                        ->orWhereHas('parentData.translations', function ($q2) use ($request) {
                        $q2->where('name', 'like', '%' . $request->search . '%');
                    });
                });
            })
            ->latest()
            ->paginate(5);

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
        $category->delete();

        Alert::toast(__('site.change_status_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.categories.index');
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        Alert::toast(__('site.change_status_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.categories.index');
    }

    public function forceDelete($id){

        $category = Category::withTrashed()->findOrFail($id);

        if ($category->image && $category->image->file) {
            $old_image = $category->image->file;
            $this->Delete_attachment('upload_image', 'categories/' . $old_image, $category->id);
        }

        $category->forceDelete();

        Alert::toast(__('site.delete_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.categories.index');
    }

    public function deleteAll(Request $request)
    {

        // @dd($request->delete_select_id);

        $ids = explode(",", $request->delete_select_id);

        foreach ($ids as $category_id) {

            $category = Category::findOrFail($category_id);

            if ($category->image && $category->image->file) {
                $old_image = $category->image->file;
                $this->Delete_attachment('upload_image', 'categories/' . $old_image, $category->id);
            }

            $category->forceDelete();
        }

        Alert::toast(__('site.delete_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.categories.index');

    }

    public function export()
    {
        return Excel::download(new CategoriesExport, 'categories.xlsx');
        // return Excel::download(new CategoriesExport, 'categories.csv', \Maatwebsite\Excel\Excel::CSV);
    }

}
