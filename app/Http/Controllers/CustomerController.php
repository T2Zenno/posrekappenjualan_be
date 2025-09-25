<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json(Customer::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('customers')->where('user_id', $user->id)],
            'note' => 'nullable|string',
        ]);

        $customer = $user->customers()->create($validated);

        return response()->json($customer, 201);
    }

    public function show($id)
    {
        $customer = Auth::user()->customers()->findOrFail($id);

        return response()->json($customer->load('sales'));
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $customer = $user->customers()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'username' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('customers')->where('user_id', $user->id)->ignore($customer->id)],
            'note' => 'nullable|string',
        ]);

        $customer->update($validated);

        return response()->json($customer);
    }

    public function destroy($id)
    {
        $customer = Auth::user()->customers()->findOrFail($id);

        $customer->delete();

        return response()->json(null, 204);
    }
}
