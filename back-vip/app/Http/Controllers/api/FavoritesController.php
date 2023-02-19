<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\Favorites;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FavoritesController extends Controller
{

    public Favorites $model;

    public function __construct()
    {
        $this->model = new Favorites();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function insert(Request $request):mixed
    {

        (array)$favorites = $request['favorites'];
        (string)$token = $request['token'];

        return Favorites::updDoc($favorites,$token);
    }
    public function searchItems(Request $request)
    {
        $items = Http::get('https://sujeitoprogramador.com/r-api/?api=filmes');
        return $items->json();
    }
}
