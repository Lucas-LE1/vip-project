<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\Favorites;
use App\Models\api\Users;
use ErrorException;
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
     * @return array
     * @throws ErrorException
     */
    public function insert(Request $request): array
    {

        (array)$favorites = $request['favorites'];
        (string)$token = $request->bearerToken();

        return Favorites::updDoc($favorites, $token);
    }

    /**
     * @throws ErrorException
     */
    public function searchItems(Request $request): ?JsonResponse
    {

        (string)$token = $request->bearerToken();
        $items = Http::get('https://sujeitoprogramador.com/r-api/?api=filmes');

        if (!$token) {
            return null;
        }
        $validated = JWTController::JWTValidate($token);
        $id_user = $validated['id'];


        $validate = (new Users)::is_admin($id_user);

        if ($validate)
            $userFavorites = Favorites::select(token: $token);
        else
            $userFavorites = null;

        return response()->json([
            'list' => $items->json(),
            'favorites' => $userFavorites ? $userFavorites->favorites : $userFavorites
        ]);
    }
}
