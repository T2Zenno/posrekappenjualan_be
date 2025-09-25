<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('products')->where('user_id', $user->id)],
        ]);

        $product = $user->products()->create($validated);

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = Auth::user()->products()->findOrFail($id);

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $product = $user->products()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:255',
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('products')->where('user_id', $user->id)->ignore($product->id)],
        ]);

        $product->update($validated);

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Auth::user()->products()->findOrFail($id);

        $product->delete();

        return response()->json(null, 204);
    }
}
