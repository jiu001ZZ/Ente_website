<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductsRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function index()
    {
        $rating = ProductsRating::all();
        return response()->json([
            'status' => 'success',
            'data' => $rating
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validate = $request->validate([
                'name' => 'required|',
                'user_id' => 'required',
                'review' => 'required|',
                'rating' => 'required|numeric',
                'status' => 'required|',
                'warungmakan_id' => 'required|numeric',
            ]);

            $rating = new ProductsRating();
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

    public function show($user_id)
    {
        $rating = ProductsRating::where('user_id', $user_id)->get();
        if ($rating) {
            return response()->json([
                'status' => 'success',
                'data' => $rating
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data not found'
            ]);
        }
    }
}
