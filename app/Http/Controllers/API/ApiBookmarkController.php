<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiBookmarkController extends Controller
{
    public function index()
    {
        $bookmark = Bookmark::all();
        return response()->json([
            'status' => 'success',
            'data' => $bookmark,
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validate = $request->validate([
                'warungmakan_id' => 'required|numeric',
                'user_id' => 'required|numeric',
            ]);

            $rating = new Bookmark();
            $rating->fill($validate);
            $rating->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Bookmart berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteData($id)
    {
        try {
            $bookmark = Bookmark::where('id', $id);
            $bookmark->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Bookmark berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
