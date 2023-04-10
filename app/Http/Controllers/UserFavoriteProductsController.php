<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserFavoriteProduct;
use Illuminate\Support\Facades\Auth;

class UserFavoriteProductsController extends Controller
{
    public function Index(){
        $user_favorite_products = Auth::user()->user_favorite_products;

        return response()->json($user_favorite_products);
    }

    public function store(Request $request){
        $request->validate([
            'product_id'        => 'required|integer|exists:products,id',        
        ]);

        $favorite = New UserFavoriteProduct;
        $favorite->user_id = Auth::user()->id;
        $favorite->product_id = $request->input('product_id', '');
        $favorite->save();
        
        return response()->json([
            'message' => 'Item added to favorites',
            'favorite' => $favorite,
        ]);
    }
}
