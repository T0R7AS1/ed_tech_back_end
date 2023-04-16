<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'is_favorite',
    ];

    public function user_favorite_product(){
        return $this->hasMany(UserFavoriteProduct::class, 'product_id');
    }

    public static function getVisibleCols(){
        return [
            [
                'key' => 'name',
                'type' => 'text',
            ],
            [
                'key' => 'description',
                'type' => 'text',
            ],
            [
                'key' => 'price',
                'type' => 'integer',
            ],
            [
                'key' => 'created_at',
                'type' => 'date',
            ],
            [
                'key' => 'updated_at',
                'type' => 'date',
            ]
        ];
    }
}
