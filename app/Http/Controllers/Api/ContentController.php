<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller
{
    // mengambil semua data konten
    public function all(Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $category_id = $request->input('category_id');
        $platform_id = $request->input('platform_id');
        $freelancer_id = $request->input('freelancer_id');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        if($id) {
            $content = Content::with(['category', 'platform', 'freelancer', 'galleries'])
                ->find($id);

            if($content) {
                return response()->json([
                    'success' => true,
                    'data' => $content,
                    'message' => 'Data konten berhasil diambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data konten tidak ada'
                ], 404);
            }
        }

        $content = Content::with(['category', 'platform', 'freelancer', 'galleries']);

        if($name) {
            $content->where('title', 'like', '%'. $name . '%');
        }
        if($description) {
            $content->where('description', 'like', '%'. $description . '%');
        }
        if($tags) {
            $content->where('tag', 'like', '%'. $tags . '%');
        }
        if($category_id) {
            $content->where('category_id', $category_id);
        }
        if($platform_id) {
            $content->where('platform_id', $platform_id);
        }
        if($freelancer_id) {
            $content->where('freelancer_id', $freelancer_id);
        }
        if($price_from) {
            $content->where('price', '>=', $price_from);
        }
        if($price_to) {
            $content->where('price', '<=', $price_to);
        }

        return response()->json([
            'success' => true,
            'data' => $content->paginate($limit),
            'message' => 'Data konten berhasil diambil'
        ], 200);
    }
}
