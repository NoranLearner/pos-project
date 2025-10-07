<?php

namespace App\Http\Controllers\Dashboard;

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
        $this->middleware(['permission:products_update'])->only('edit');
        $this->middleware(['permission:products_delete'])->only(['destroy', 'restore', 'forceDelete', 'deleteAll']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // @dd($request->all());

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
