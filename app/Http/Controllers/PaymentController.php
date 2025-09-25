<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        return response()->json(Payment::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
        ]);

        $payment = $request->user()->payments()->create($validated);

        return response()->json($payment, 201);
    }

    public function show($id)
    {
        $payment = Auth::user()->payments()->findOrFail($id);

        return response()->json($payment->load('sales'));
    }

    public function update(Request $request, $id)
    {
        $payment = Auth::user()->payments()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
        ]);

        $payment->update($validated);

        return response()->json($payment);
    }

    public function destroy($id)
    {
        $payment = Auth::user()->payments()->findOrFail($id);

        $payment->delete();

        return response()->json(null, 204);
    }
}
