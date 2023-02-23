<?php

namespace App\Models\api;

use App\Http\Controllers\api\JWTController;
use ErrorException as ErrorExceptionAlias;
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
     * @throws ErrorExceptionAlias
     */
    public static function updDoc(array $favorites, string $token): array
    {
        $jwt = JWTController::JWTValidate($token);
        $id_user = $jwt['id'];

        $userFavorite = self::select($id_user);

        function data(int $id_favorite, int $id_user, array $favorites): array
        {
            return [
                'id_favorite' => $id_favorite,
                'id_user' => $id_user,
                'favorites' => $favorites
            ];
        }

        if ($userFavorite) {
            $id_favorite = $userFavorite['id_favorite'];
            $key = $userFavorite['key'];
            self::$favoritesRead[$key] = data($id_favorite, $id_user, $favorites);

        } else {
            if (self::$favoritesRead) {
                $id_favorite = end(self::$favoritesRead)->id_favorite + 1;
            } else {
                $id_favorite = 0;
            }
            self::$favoritesRead[] = data($id_favorite, $id_user, $favorites);
        }

        file_put_contents(self::$filename, json_encode(self::$favoritesRead));

        return data($id_favorite, $id_user, $favorites);
    }

    /**
     * @param int|null $id_user
     * @param string|null $token
     * @return array|null
     */
    public static function select(?int $id_user = null, ?string $token = null): ?array
    {
        if (self::$favoritesRead) {
            foreach (self::$favoritesRead as $key => $item) {
                if ($item->id_user === $id_user) {
                    return array_merge(['key' => $key],(array)$item );
                }
            }
        }
        return null;

    }

}
