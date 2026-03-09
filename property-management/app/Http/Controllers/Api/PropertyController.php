<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Resources\PropertyResource;

class PropertyController extends Controller
{
    // Get all properties
   public function index(Request $request)
    {
        $query = Property::with('user');

        if ($request->sort == 'price_low') {
    $query->orderBy('price', 'asc');
        }

        elseif ($request->sort == 'price_high') {
            $query->orderBy('price', 'desc');
        }

        else {
            $query->latest();
        }
        if ($request->location) {
            $query->where('location', $request->location);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $properties = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => PropertyResource::collection($properties)
        ]);
    }
    //store a new property
    public function store(Request $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('properties', 'public');
        }
                $property = Property::create([
            ...$validated,
            'image' => $imagePath,
            'user_id' => auth()->id()
        ]);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $property = Property::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'location' => $validated['location'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'image' => $imagePath,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'data' => $property
        ], 201);
    }
    // Get a single property
    public function show($id)
    {
        $property = Property::with('user')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $property
        ]);
    }
    // Update a property
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        if(auth()->user()->role !== 'admin' && $property->user_id !== auth()->id()){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $property->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $property
        ]);
    }
    // Delete a property
    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        if(auth()->user()->role !== 'admin' && $property->user_id !== auth()->id()){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $property->delete();

        return response()->json([
            'success' => true,
            'message' => 'Property deleted'
        ]);
    }
}
