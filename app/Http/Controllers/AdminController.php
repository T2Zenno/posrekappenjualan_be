<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(Admin::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username',
            'note' => 'nullable|string',
        ]);

        $admin = Admin::create($validated);

        return response()->json($admin, 201);
    }

    public function show($id)
    {
        $admin = Admin::findOrFail($id);

        return response()->json($admin->load('sales'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255|unique:admins,username,' . $admin->id,
            'note' => 'nullable|string',
        ]);

        $admin->update($validated);

        return response()->json($admin);
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        $admin->delete();

        return response()->json(null, 204);
    }
}
