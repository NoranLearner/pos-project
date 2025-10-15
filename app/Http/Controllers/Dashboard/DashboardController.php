<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users_count = User::whereHasRole(['admin', 'super_admin'])->count();
        $categories_count = Category::count();
        $products_count = Product::count();
        $clients_count = Client::count();
        $orders_count = Order::count();

        $completed_orders_count = Order::where('status', 'completed')->count();
        $pending_orders_count = Order::where('status', 'pending')->count();
        $cancelled_orders_count = Order::where('status', 'cancelled')->count();

        $orders_labels = ['Completed', 'Pending', 'Cancelled'];
        $orders_data = [$completed_orders_count, $pending_orders_count, $cancelled_orders_count];

        return view('dashboard.index', compact('users_count', 'categories_count', 'products_count', 'clients_count', 'orders_count', 'orders_labels', 'orders_data'));
    }

    public function sales()
    {
        // https://www.youtube.com/watch?v=rv16bmm9TDY

        // whereYear('created_at', 2025)
        // $sales_data = Order::select([
        //     DB::raw('Day(created_at) as day'),
        //     DB::raw('Month(created_at) as month'),
        //     DB::raw('Year(created_at) as year'),
        //     DB::raw('SUM(total_price) as total'),
        // ])->groupBy('day', 'month', 'year')->orderBy('day')->get();

        $sales_data = Order::select([
            DB::raw('DAYOFWEEK(created_at) as weekday'),
            DB::raw('SUM(total_price) as total'),
        ])
        ->groupBy('weekday')
        ->orderBy('weekday')
        ->get();

        $labels = [1=>'Sunday', 2=>'Monday', 3=>'Tuesday', 4=>'Wednesday', 5=>'Thursday', 6=>'Friday', 7=>'Saturday'];

        $total = [];

        foreach ($sales_data as $key => $value) {
            $total[$value->weekday] = $value->total;
        }

        foreach ($labels as $key1 => $value1) {
            if(!array_key_exists($key1, $total)){
                $total[$key1] = 0;
            }
        }

        ksort($total);

        return [
            'labels' => array_values($labels),
            'datasets' => [
                'label' => 'Total Sales',
                'data' => array_values($total),
            ],
        ];

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
