<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\UserFavoriteProduct;
use Illuminate\Support\Facades\Auth;

class UserFavoriteProductsController extends Controller
{
    public function index(Request $request){
        $user_id = Auth::user()->id;
        $favorite_products = Product::whereHas('user_favorite_product', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        });

        $favorite_products_count = $favorite_products->count();

        $page = intval($request->input('page', 0));
        $limit = intval($request->input('length', 5));

        if($page > 0){
            $favorite_products = $favorite_products->offset(($page * $limit));
        }
        if($limit > 0){
            $favorite_products = $favorite_products->limit($limit);
        }

        $favorite_products = $favorite_products->get();
        foreach ($favorite_products as $product) {
            $product->is_favorite = $product->user_favorite_product->isNotEmpty();
            $product->makeHidden('user_favorite_product', 'deleted_at');
        }

        $visible_cols = Product::getVisibleCols();

        return response()->json(['products' => $favorite_products, 'visible_cols' => $visible_cols, 'items_count' => $favorite_products_count]);
    }

    public function addToFavorites($product_id){
        $product = Product::findOrFail($product_id);
        $user_id = Auth::user()->id;

        $favorite = UserFavoriteProduct::where('product_id', $product->id)->where('user_id', $user_id)->first();
        if(empty($favorite)){
            $favorite = New UserFavoriteProduct;
            $favorite->user_id = $user_id;
            $favorite->product_id = $product->id;
            $favorite->save();
            return response()->json([
                'message' => trans('resources.product_added_to_favorites'),
            ], 200);
        }
        
        return response()->json([
            'message' => trans('resources.product_is_already_added_to_favorites'),
        ], 404);
    }
    
    public function removeFromFavorites($product_id){
        $product = Product::findOrFail($product_id);
        $user_id = Auth::user()->id;

        $favorite = UserFavoriteProduct::where('product_id', $product->id)->where('user_id', $user_id)->first();
        if (!empty($favorite)) {
            $favorite->delete();
            return response()->json([
                'message' => trans('resources.product_removed_from_favorites'),
            ]);
        }

        return response()->json([
            'message' => trans('resources.product_already_removed_from_favorites'),
        ], 404);
    }
}
