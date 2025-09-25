<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Auth::user()->sales()->with(['customer', 'product', 'channel', 'payment', 'admin']);

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $sales = $query->get();

        $totalRevenue = $sales->sum('price');
        $totalSales = $sales->count();

        return response()->json([
            'sales' => $sales,
            'summary' => [
                'total_sales' => $totalSales,
                'total_revenue' => $totalRevenue,
            ],
        ]);
    }

    public function customerReport()
    {
        $customers = Auth::user()->customers()->withCount('sales')
            ->with(['sales' => function ($query) {
                $query->select('customer_id', 'price');
            }])
            ->get()
            ->map(function ($customer) {
                $customer->total_spent = $customer->sales->sum('price');
                return $customer;
            });

        return response()->json($customers);
    }

    public function productReport()
    {
        $products = Auth::user()->products()->withCount('sales')
            ->with(['sales' => function ($query) {
                $query->select('product_id', 'price');
            }])
            ->get()
            ->map(function ($product) {
                $product->total_revenue = $product->sales->sum('price');
                return $product;
            });

        return response()->json($products);
    }

    public function revenueReport(Request $request)
    {
        $period = $request->get('period', 'monthly'); // daily, weekly, monthly, yearly
        $user = Auth::user();

        $groupBy = match ($period) {
            'daily' => DB::raw('DATE(date) as period'),
            'weekly' => DB::raw('YEARWEEK(date) as period'),
            'monthly' => DB::raw('DATE_FORMAT(date, "%Y-%m") as period'),
            'yearly' => DB::raw('YEAR(date) as period'),
            default => DB::raw('DATE_FORMAT(date, "%Y-%m") as period'),
        };

        $revenue = $user->sales()->select($groupBy, DB::raw('SUM(price) as revenue'), DB::raw('COUNT(*) as sales_count'))
            ->groupBy('period')
            ->orderBy('period', 'desc')
            ->get();

        return response()->json($revenue);
    }
}
