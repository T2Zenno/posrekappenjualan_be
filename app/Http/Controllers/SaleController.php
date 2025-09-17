<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return response()->json(Sale::with(['customer', 'product', 'channel', 'payment', 'admin'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'channel_id' => 'required|exists:channels,id',
            'payment_id' => 'required|exists:payments,id',
            'admin_id' => 'required|exists:admins,id',
            'price' => 'required|numeric|min:0',
            'link' => 'nullable|string',
            'date' => 'required|date',
            'ship_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        $sale = Sale::create($validated);

        return response()->json($sale->load(['customer', 'product', 'channel', 'payment', 'admin']), 201);
    }

    public function show($id)
    {
        $sale = Sale::findOrFail($id);

        return response()->json($sale->load(['customer', 'product', 'channel', 'payment', 'admin']));
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $validated = $request->validate([
            'customer_id' => 'sometimes|required|exists:customers,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'channel_id' => 'sometimes|required|exists:channels,id',
            'payment_id' => 'sometimes|required|exists:payments,id',
            'admin_id' => 'sometimes|required|exists:admins,id',
            'price' => 'sometimes|required|numeric|min:0',
            'link' => 'nullable|string',
            'date' => 'sometimes|required|date',
            'ship_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        $sale->update($validated);

        return response()->json($sale->load(['customer', 'product', 'channel', 'payment', 'admin']));
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        $sale->delete();

        return response()->json(null, 204);
    }
}
