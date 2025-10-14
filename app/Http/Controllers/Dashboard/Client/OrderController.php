<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{

    public function __construct()
    {
        // $this->middleware(['permission:orders_read'])->only('index', 'export');
        $this->middleware(['permission:orders_create'])->only('create');
        $this->middleware(['permission:orders_update'])->only('edit');
        // $this->middleware(['permission:orders_delete'])->only(['destroy', 'restore', 'forceDelete', 'deleteAll']);
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
    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create', compact('client', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Client $client)
    {
        // dd($request->all());
        // dd($client);

        $validatedData =  $request->validate([
            'products' => 'required|array|min:1',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.id' => 'exists:products,id',
        ]);

        // dd($validatedData);

        // Orders Table
        $order = $client->orders()->create([
            'client_id' => $client->id,
            // 'total_price' => $request->total_price,
            // 'status' => 'pending',
        ]);

        // product_order_pivot Table
        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id=>$quantity) {
            // dd($quantity); // array("quantity" => "1")
            $product = Product::findOrFail($id);
            $total_price += $quantity['quantity'] * $product->currentSalePrice->sale_price;
            // update product stock - Products Table
            $product->update([
                'stock' => $product->stock - $quantity['quantity'],
            ]);
        }

        // update total_price - Orders Table
        $order->update([
            'total_price' => $total_price,
        ]);

        Alert::toast(__('site.order_added_successfully'), 'success')->timerProgressBar();

        return redirect()->route('dashboard.orders.index');
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
    public function edit(Client $client, Order $order)
    {
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.edit', compact('client', 'order', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
