<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SaleController extends Controller
{
    public function index()
    {
        return response()->json(Sale::where('user_id', Auth::id())->with(['customer', 'product', 'channel', 'payment', 'admin'])->get());
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'customer_id' => ['required', Rule::exists('customers', 'id')->where('user_id', $user->id)],
            'product_id' => ['required', Rule::exists('products', 'id')->where('user_id', $user->id)],
            'channel_id' => ['required', Rule::exists('channels', 'id')->where('user_id', $user->id)],
            'payment_id' => ['required', Rule::exists('payments', 'id')->where('user_id', $user->id)],
            'admin_id' => ['required', Rule::exists('admins', 'id')->where('user_id', $user->id)],
            'price' => 'required|numeric|min:0',
            'link' => 'nullable|string',
            'date' => 'required|date',
            'ship_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        $sale = $user->sales()->create($validated);

        return response()->json($sale->load(['customer', 'product', 'channel', 'payment', 'admin']), 201);
    }

    public function show($id)
    {
        $sale = Auth::user()->sales()->findOrFail($id);

        return response()->json($sale->load(['customer', 'product', 'channel', 'payment', 'admin']));
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $sale = $user->sales()->findOrFail($id);

        $validated = $request->validate([
            'customer_id' => ['sometimes', 'required', Rule::exists('customers', 'id')->where('user_id', $user->id)],
            'product_id' => ['sometimes', 'required', Rule::exists('products', 'id')->where('user_id', $user->id)],
            'channel_id' => ['sometimes', 'required', Rule::exists('channels', 'id')->where('user_id', $user->id)],
            'payment_id' => ['sometimes', 'required', Rule::exists('payments', 'id')->where('user_id', $user->id)],
            'admin_id' => ['sometimes', 'required', Rule::exists('admins', 'id')->where('user_id', $user->id)],
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
        $sale = Auth::user()->sales()->findOrFail($id);

        $sale->delete();

        return response()->json(null, 204);
    }
}
