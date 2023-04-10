<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFavoriteProduct extends Model
{
    use SoftDeletes;

    const UPDATED_AT = null;
}
