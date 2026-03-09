<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // Get all properties
    public function index()
    {
        $properties = Property::with('user')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $properties
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string'
        ]);

        $property = Property::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'location' => $validated['location'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'user_id' => 1 // temporary (we’ll replace with auth later)
        ]);

        return response()->json([
            'success' => true,
            'data' => $property
        ], 201);
    }
}
