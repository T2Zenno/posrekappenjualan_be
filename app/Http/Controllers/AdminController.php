<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(Admin::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['nullable', 'string', 'max:255', Rule::unique('admins')->where('user_id', $user->id)],
            'note' => 'nullable|string',
        ]);

        $admin = $user->admins()->create($validated);

        return response()->json($admin, 201);
    }

    public function show($id)
    {
        $admin = Auth::user()->admins()->findOrFail($id);

        return response()->json($admin->load('sales'));
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $admin = $user->admins()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'username' => ['sometimes', 'nullable', 'string', 'max:255', Rule::unique('admins')->where('user_id', $user->id)->ignore($admin->id)],
            'note' => 'nullable|string',
        ]);

        $admin->update($validated);

        return response()->json($admin);
    }

    public function destroy($id)
    {
        $admin = Auth::user()->admins()->findOrFail($id);

        $admin->delete();

        return response()->json(null, 204);
    }
}
