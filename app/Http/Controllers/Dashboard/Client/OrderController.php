<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
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

        $order = $client->orders()->create([
            'client_id' => $client->id,
            // 'total_price' => $request->total_price,
            // 'status' => 'pending',
        ]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id=>$quantity) {
            // dd($quantity); // array("quantity" => "1")
            $product = Product::findOrFail($id);
            $total_price += $quantity['quantity'] * $product->currentSalePrice->sale_price;
            $product->update([
                'stock' => $product->stock - $quantity['quantity'],
            ]);
        }

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
    public function edit(string $id)
    {
        //
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
