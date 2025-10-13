<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:orders_read'])->only('index');
        // $this->middleware(['permission:orders_read'])->only('index', 'export');
        // $this->middleware(['permission:orders_create'])->only('create');
        // $this->middleware(['permission:orders_update'])->only('edit');
        // $this->middleware(['permission:orders_delete'])->only(['destroy', 'restore', 'forceDelete', 'deleteAll']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // نجيب الترجمات العكسية
        $statusTranslations = [
            __('site.pending') => 'pending',
            __('site.completed') => 'completed',
            __('site.cancelled') => 'cancelled',
        ];

        $orders = Order::where(function ($q) use ($request, $statusTranslations) {

            $q->when($request->search, function ($query) use ($request, $statusTranslations) {

                // البحث في اسم العميل
                $query->whereHas('client', function ($q1) use ($request) {
                    $q1->where('name', 'like', '%' . $request->search . '%');
                });

                // لو المستخدم كتب ترجمة الحالة بالعربي أو الإنجليزي
                $statusKey = $statusTranslations[$request->input('search')] ?? null;

                if ($statusKey) {
                    $query->orWhere('status', $statusKey);
                }
            });

        })->latest()->paginate(5);
        return view('dashboard.orders.index', compact('orders'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // $products = $order->products()->withPivot('quantity')->get();
        // return $products[0]->pivot->quantity;
        // return $products;
        $order ->load('client', 'products');
        return view('dashboard.orders.order_details', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
