<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function all (Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $showCreator = $request->input('show.creator', false); // Default to not showing creator

        $query = Content::query();

        // Filter by category ID
        if ($id) {
            $query->where('category_id', $id);
        }

        // Filter by content name (optional)
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        // Eager load creator and/or products based on request parameters
        if ($showCreator) {
            $query->with('creator');
        }

         // Select relevant content data (adjust columns as needed)
        $query->select([
            'content.id',
            'content.name',
        ]);

        // Paginate results with default limit
        $contents = $query->paginate($limit);

        return response()->json([
            'data' => $contents,
            'message' => 'Data Konten berhasil diambil'
        ], 200);
    }
}
