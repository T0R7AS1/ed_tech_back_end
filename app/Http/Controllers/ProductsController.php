<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index(Request $request){
        $user_id = Auth::user()->id;
        $products = Product::with(['user_favorite_product' => function($query) use ($user_id){
            $query->where('user_id', $user_id);
        }]);

        $products_count = $products->count();

        $page = intval($request->input('page', 0));
        $limit = intval($request->input('length', 5));
        if($page > 0){
            $products = $products->offset(($page * $limit));
        }
        if($limit > 0){
            $products = $products->limit($limit);
        }

        $products = $products->get();
        foreach ($products as $product) {
            $product->is_favorite = $product->user_favorite_product->isNotEmpty();
            $product->makeHidden('user_favorite_product', 'deleted_at');
        }

        $visible_cols = Product::getVisibleCols();

        return response()->json(['products' => $products, 'visible_cols' => $visible_cols, 'items_count' => $products_count]);
    }
}
