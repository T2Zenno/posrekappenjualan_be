<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats()
    {
        $user = Auth::user();
        $totalSales = $user->sales()->count();
        $totalRevenue = $user->sales()->sum('price');
        $totalProducts = $user->products()->count();
        $totalCustomers = $user->customers()->count();

        return response()->json([
            'total_sales' => $totalSales,
            'total_revenue' => $totalRevenue,
            'total_products' => $totalProducts,
            'total_customers' => $totalCustomers,
        ]);
    }

    public function summary()
    {
        $user = Auth::user();
        $monthlySales = $user->sales()->select(
            DB::raw('MONTH(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('COUNT(*) as sales_count'),
            DB::raw('SUM(price) as revenue')
        )
        ->where('user_id', $user->id)
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        $topProducts = Sale::select('products.name', DB::raw('COUNT(*) as sales_count'))
            ->where('sales.user_id', $user->id)
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name')
            ->orderBy('sales_count', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'monthly_sales' => $monthlySales,
            'top_products' => $topProducts,
        ]);
    }
}
