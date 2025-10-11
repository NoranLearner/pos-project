<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ProductsExport;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\UploadTrait;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductController extends Controller
{
    use UploadTrait;

    public function __construct()
    {
        $this->middleware(['permission:products_read'])->only('index', 'export');
        $this->middleware(['permission:products_create'])->only('create');
        $this->middleware(['permission:products_update'])->only('edit', 'change_sale_price');
        $this->middleware(['permission:products_delete'])->only(['destroy', 'restore', 'forceDelete', 'deleteAll']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all);

        $categories = Category::all();

        $products = Product::withTrashed()
            ->with(['translations', 'prices', 'category'])
            ->where(function ($q) use ($request){

                $q->when($request->search, function ($query) use ($request){
                    // بحث في الاسم والوصف (بناءً على الترجمة)
                    $query->whereTranslationLike('name', '%' . $request->search . '%')
                    ->orWhereTranslationLike('description', '%' . $request->search . '%')
                    // او نبحث عن اسم قسم المنتج
                    ->orWhereHas('category.translations', function ($q2) use ($request){
                        $q2->where('name', 'like', '%' . $request->search . '%');
                    });
                });

                $q->when($request->filled('category_id'), function ($query) use ($request) {
                    $query->where('category_id', $request->category_id);
                });

            })
            ->latest()->paginate(5);

        return view('dashboard.products.index', compact('categories', 'products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $locales = LaravelLocalization::getSupportedLocales();

        $rules = [
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required',
        ];

        foreach ($locales as $localeCode => $properties) {
            $rules["{$localeCode}.name"] = 'required|string|max:255';
            $rules["{$localeCode}.description"] = 'nullable|string';
        }

        $validatedData = $request->validate($rules);

        $product = Product::create($validatedData);

        // لاضافة سعر الشراء و سعر البيع
        if (isset($validatedData['purchase_price']) && isset($validatedData['sale_price'])) {
            $product->prices()->create([
                'purchase_price' => $validatedData['purchase_price'],
                'sale_price' => $validatedData['sale_price'],
                'start_date' => now(),
                'end_date' => null,
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $this->verifyAndStoreImageForeach($file, 'products', 'upload_image', $product->id, Product::class);
            }
        }

        Alert::toast(__('site.added_successfully'), 'success')->timerProgressBar();

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // @dd($request->all());

        $locales = LaravelLocalization::getSupportedLocales();

        $rules = [
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'purchase_price' => 'numeric|min:0',
            'sale_price' => 'numeric|min:0',
            'stock' => 'numeric|min:0',
            'category_id' => 'nullable',
        ];

        foreach ($locales as $localeCode => $properties) {
            $rules["{$localeCode}.name"] = 'required|string|max:255';
            $rules["{$localeCode}.description"] = 'nullable|string';
        }

        $validatedData = $request->validate($rules);


        $product->update($validatedData);

        // تحقق من السعر الحالي
        $currentPrice = $product->prices()->whereNull('end_date')->latest()->first();

        // لو وضعنا قيمه لسعر الشراء او لسعر البيع
        if (
            ($request->filled('purchase_price') || $request->filled('sale_price')) && (
            $currentPrice?->purchase_price != $validatedData['purchase_price'] ||
            $currentPrice?->sale_price != $validatedData['sale_price']
        )) {

            // تقفيل السعر الحالى
            $product->prices()->where('end_date', null)->update([
                'end_date' => now()->subDay(),
            ]);

            // لاضافة سعر الشراء و سعر البيع
            $product->prices()->create([
                'purchase_price' => $validatedData['purchase_price'],
                'sale_price' => $validatedData['sale_price'],
                'start_date' => now(),
                'end_date' => null,
            ]);
        }

        if ($request->hasFile('images')) {

            // Delete old images
            if ($product->images) {
                foreach ($product->images as $image) {
                    $this->Delete_attachment('upload_image', 'products/' . $image->file, $product->id);
                }
            }

            // Store new images
            foreach ($request->file('images') as $file) {
                $this->verifyAndStoreImageForeach($file, 'products', 'upload_image', $product->id, Product::class);
            }

        }

        Alert::toast(__('site.updated_successfully'), 'success')->timerProgressBar();

        return redirect()->route('dashboard.products.index');

    }

    public function change_sale_price(Request $request){

        // dd($request->all());

        $product = Product::find($request->product_id);

        // تحقق من السعر الحالي
        $currentPrice = $product->prices()->whereNull('end_date')->latest()->first();

        if ($currentPrice?->sale_price != $request->sale_price) {

            // تقفيل السعر الحالى
            $product->prices()->where('end_date', null)->update([
                'end_date' => now()->subDay(),
            ]);

            // اضافة سعر جديد
            $product->prices()->create([
                'purchase_price' => $request->purchase_price,
                'sale_price' => $request->sale_price,
                'start_date' => $request->start_date,
                'end_date' => null,
            ]);

        }

        Alert::toast(__('site.updated_successfully'), 'success')->timerProgressBar();
        return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        Alert::toast(__('site.change_status_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.products.index');
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        Alert::toast(__('site.change_status_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.products.index');
    }

    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        // Delete old images
        if ($product->images) {
            foreach ($product->images as $image) {
                $this->Delete_attachment('upload_image', 'products/' . $image->file, $product->id);
            }
        }

        $product->forceDelete();

        Alert::toast(__('site.deleted_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.products.index');
    }

    public function deleteAll(Request $request)
    {

        // dd($request->delete_select_id);

        $ids = explode(",", $request->delete_select_id);

        foreach ($ids as $product_id) {

            $product = Product::findOrFail($product_id);

            // Delete old images
            if ($product->images) {
                foreach ($product->images as $image) {
                    $this->Delete_attachment('upload_image', 'products/' . $image->file, $product->id);
                }
            }

            $product->forceDelete();
        }

        Alert::toast(__('site.delete_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.products.index');

    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
        // return Excel::download(new ProductsExport, 'products.csv', \Maatwebsite\Excel\Excel::CSV);
    }

}
