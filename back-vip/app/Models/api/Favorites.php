<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Favorites extends Model
{
    use HasFactory;

    public function register(Request $request)
    {
        (array) $favorites = $request->only('favorites');


    }
}
