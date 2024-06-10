<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductsRating;
use App\Models\TempatMakan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TempatMakanController extends Controller
{
    public function getWarungMakan()
    {
        $tempat_makan = TempatMakan::all();
        return response()->json([
            'status' => 'success',
            'data' => $tempat_makan,
        ]);
    }

    public function getRatingByWarung($id)
    {
        $rating = ProductsRating::where('warungmakan_id', $id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $rating,
        ]);
    }

    public function storeRatingWarung(Request $request)
    {
        try {
            DB::beginTransaction();
            $validate = $request->validate([
                'name' => 'required',
                'review' => 'required',
                'rating' => 'required|numeric',
                'status' => 'required',
                'warungmakan_id' => 'required|numeric',
            ]);

            $rating = new ProductsRating();
            $rating->fill($validate);
            $rating->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Rating berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
