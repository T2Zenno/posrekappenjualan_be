
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

// Public API routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // Products
    Route::apiResource('products', ProductController::class);

    // Sales
    Route::apiResource('sales', SaleController::class);

    // Customers
    Route::apiResource('customers', CustomerController::class);

    // Channels
    Route::apiResource('channels', ChannelController::class);

    // Admins
    Route::apiResource('admins', AdminController::class);

    // Payments
    Route::apiResource('payments', PaymentController::class);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);

    // Reports
    Route::get('/reports/sales', [ReportController::class, 'salesReport']);
    Route::get('/reports/customers', [ReportController::class, 'customerReport']);
    Route::get('/reports/products', [ReportController::class, 'productReport']);
    Route::get('/reports/revenue', [ReportController::class, 'revenueReport']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', fn(Request $r) => $r->user());
    
    // dst…
});