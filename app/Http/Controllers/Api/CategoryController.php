<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // mengambil semua data kategory
    public function all(Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $show_content = $request->input('show.content');

        if($id) {
            $category = Category::with(['content'])->find($id);
            if($category) {
                return response()->json([
                    'success' => true,
                    'data' => $category,
                    'message' => 'Data Kategori berhasil diambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Kategori tidak ada'
                ], 404);
            }
        }

        $category = Category::query();

        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_content) {
            $category->with('content');
        }

        return response()->json([
            'success' => true,
            'data' => $category->paginate($limit),
            'message' => 'Data Kategori berhasil diambil'
        ], 200);
    }
}
