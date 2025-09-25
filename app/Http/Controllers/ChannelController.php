<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChannelController extends Controller
{
    public function index()
    {
        return response()->json(Channel::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'url' => 'nullable|string',
        ]);

        $channel = $request->user()->channels()->create($validated);

        return response()->json($channel, 201);
    }

    public function show($id)
    {
        $channel = Auth::user()->channels()->findOrFail($id);

        return response()->json($channel->load('sales'));
    }

    public function update(Request $request, $id)
    {
        $channel = Auth::user()->channels()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'desc' => 'nullable|string',
            'url' => 'nullable|string',
        ]);

        $channel->update($validated);

        return response()->json($channel);
    }

    public function destroy($id)
    {
        $channel = Auth::user()->channels()->findOrFail($id);

        $channel->delete();

        return response()->json(null, 204);
    }
}
