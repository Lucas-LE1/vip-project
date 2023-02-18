<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FavoritesController extends Controller
{

    /**
     * @return void
     */
    public function addFavorite(): void
    {

    }
    public function searchItems(Request $request)
    {
        $items = Http::get('https://sujeitoprogramador.com/r-api/?api=filmes');
        return $items->json();
    }
}
