<?php

namespace App\Models\api;

use App\Http\Controllers\api\JWTController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

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
     * //     * @return mixed
     */
    public static function updDoc(array $favorites, string $token): mixed
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
     * @param int $id_user
     * @return mixed
     */
    public static function select(int $id_user): mixed
    {

        if (!self::$favoritesRead)
            return null;

        foreach (self::$favoritesRead as &$item) {
            if ($item->id_user == $id_user)
                return $item;
        }
        return null;

    }

}
