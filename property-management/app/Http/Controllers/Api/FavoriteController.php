<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store($property_id)
    {
        $favorite = Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'property_id' => $property_id
        ]);

        return response()->json([
            'success' => true,
            'data' => $favorite
        ]);
    }
    public function index()
    {
        $favorites = Favorite::with('property')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'success' => true,
            'data' => $favorites
        ]);
    }
    public function destroy($property_id)
    {
        Favorite::where('user_id', auth()->id())
            ->where('property_id', $property_id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removed from favorites'
        ]);
    }
}
