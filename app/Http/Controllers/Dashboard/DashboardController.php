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

    public function sales(Request $request)
    {
        // https://www.youtube.com/watch?v=rv16bmm9TDY

        $period = $request->query('period', 'day');

        switch ($period) {

            // For Month

            case 'month':

                $sales_data = Order::select([
                    DB::raw('Month(created_at) as period'),
                    DB::raw('SUM(total_price) as total'),
                ])
                ->groupBy('period')
                ->orderBy('period')
                ->get();

                $labels = [1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December'];

                break;

            // For Year

            case 'year':

                $sales_data = Order::select([
                    DB::raw('Year(created_at) as period'),
                    DB::raw('SUM(total_price) as total'),
                ])
                ->groupBy('period')
                ->orderBy('period')
                ->get();

                // $labels = [1=>'2021', 2=>'2022', 3=>'2023', 4=>'2024', 5=>'2025', 6=>'2026', 7=>'2027', 8=>'2028', 9=>'2029', 10=>'2030'];
                $labels = $sales_data->pluck('period', 'period')->toArray();

                break;

            // For Day Default
            default:

                $sales_data = Order::select([
                    DB::raw('DAYOFWEEK(created_at) as period'),
                    DB::raw('SUM(total_price) as total'),
                ])
                ->groupBy('period')
                ->orderBy('period')
                ->get();

                $labels = [1=>'Sunday', 2=>'Monday', 3=>'Tuesday', 4=>'Wednesday', 5=>'Thursday', 6=>'Friday', 7=>'Saturday'];

                break;

        }

        $total = [];

        foreach ($sales_data as $key => $value) {
            $total[$value->period] = $value->total;
        }

        foreach ($labels as $key1 => $value1) {
            if(!array_key_exists($key1, $total)){
                $total[$key1] = 0;
            }
        }

        ksort($total);

        return [
            'period' => $period,
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
