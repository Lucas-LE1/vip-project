<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\Favorites;
use App\Models\api\Users;
use ErrorException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use function Symfony\Component\String\s;

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
    public function searchItems(Request $request): Application|ResponseFactory|Response|null
    {

        function removerAcentos($text): string
        {
            return preg_replace("/[^\w\s]/", "", iconv("UTF-8", "ASCII//TRANSLIT", $text));
        }

        (string)$token = $request->bearerToken();
        (string)$search = $request['search'];

        $items = Http::get('https://sujeitoprogramador.com/r-api/?api=filmes')->json();
        $ItemsCopy = $items;
        if ($search) {
            $items = [];
            $newSearch = removerAcentos($search);

            foreach ($ItemsCopy as $values) {
                $movieName = removerAcentos($values['nome']);
                $movieSinopse = removerAcentos($values['sinopse']);

                $findName = stripos($movieName, $newSearch);
                $findSinopse = stripos($movieSinopse, $newSearch);


                if ($findName !== false or $findSinopse !== false) {
                    if($findName !== false) {
                        $tempValue = $movieName;
                        $word = substr($tempValue,$findName,strlen($newSearch));
                        $values['nome'] =str_ireplace($search, "<mark class='mark_search_items title_movie'>$word</mark>", $values['nome']);
                    }
                    if($findSinopse !== false) {
                        $tempValue = $movieSinopse;
                        $word = substr($tempValue,$findSinopse,strlen($newSearch));
                        $values['sinopse'] =str_ireplace($search, "<mark class='mark_search_items synopses_movie'>$word</mark>", $values['sinopse']);
                    }
                    $items[] = $values;
                }
            }
        }

        if (!$token) {
            return null;
        }
        $validated = JWTController::JWTValidate($token);
        $id_user = $validated['id'];

        $validate = (new Users)::is_admin($id_user);

        if ($validate) {
            $userFavorites = Favorites::select($id_user);
            $userFavorites = $userFavorites ? $userFavorites['favorites'] : [];
        } else {
            $userFavorites = null;
        }

        return response([
            'list' => $items,
            'favorites' => $userFavorites
        ]);

    }
}
