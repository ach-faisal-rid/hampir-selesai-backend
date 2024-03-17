<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    // mengambil semua data platform
    public function all(Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $show_content = $request->input('show.content');

        if($id) {
            $platform = Platform::with(['content'])->find($id);
            if($platform) {
                return response()->json([
                    'success' => true,
                    'data' => $platform,
                    'message' => 'Data Platform berhasil diambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Platform tidak ada'
                ], 404);
            }
        }

        $platform = Platform::query();

        if ($name) {
            $platform->where('name', 'like', '%' . $name . '%');
        }

        if ($show_content) {
            $platform->with('content');
        }

        return response()->json([
            'success' => true,
            'data' => $platform->paginate($limit),
            'message' => 'Data Platform berhasil diambil'
        ], 200);
    }
}
