<?php

namespace App\Models\api;

use App\Http\Controllers\api\JWTController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Favorites extends Model
{
    use HasFactory;

    public static mixed $favoritesRead;
    protected static string $filename = __DIR__ . '/../../../database/temp/favorites.json';


    public function __construct()
    {
        parent::__construct();
        (array)self::$favoritesRead = json_decode(file_get_contents(self::$filename));
    }


    /**
     * @param array $favorites
     * @param string $token
     * //     * @return array
     * @throws \ErrorException
     */
    public static function updDoc(array $favorites, string $token): array
    {
        $jwt = JWTController::JWTValidate($token);
        $id_user = (int)$jwt['id'];

        $userFavorite = self::select($id_user);

        function data (int $id_favorite,int $id_user,array $favorites): array
        {
            return [
                'id_favorite' => $id_favorite,
                'id_user' => $id_user,
                'favorites' => $favorites
            ];
        };

        if ($userFavorite) {
            $id_favorite = $userFavorite->id_favorite;
            self::$favoritesRead[$id_favorite] = data($id_favorite,$id_user,$favorites);

        } else {
            if (self::$favoritesRead) {
                $id_favorite = end(self::$favoritesRead)->id_favorite + 1;
            } else {
                $id_favorite = 0;
            }
            self::$favoritesRead[] = data($id_favorite,$id_user,$favorites);
        }

        file_put_contents(self::$filename,json_encode(self::$favoritesRead));

        return data($id_favorite,$id_user,$favorites);
    }

    /**
     * @param int|null $id_user
     * @param string|null $token
     * @return mixed
     */
    public static function select(?int $id_user,?string $token=null): mixed
    {
        if (!self::$favoritesRead)
            return null;

        print_r($id_user);

        foreach (self::$favoritesRead as &$item) {

            if ($item->id_user == $id_user){
                print_r($item);
                return $item;
            }
        }
        return [
            'favorites'=>[]
        ];

    }

}
