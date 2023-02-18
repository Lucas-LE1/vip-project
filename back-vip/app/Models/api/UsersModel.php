<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Exception;

class UsersModel extends Model
{
    use HasFactory;

    protected static mixed $usersRead;
    protected static string $filename = __DIR__ . '/../../../database/temp/users.json';

    public function __construct()
    {
        parent::__construct();
        self::$usersRead = json_decode(file_get_contents(self::$filename));
    }

    /*
     * Model User
     * ----------------------
     * | id => int,         |
     * | email => string    |
     * | password => string |
     * | admin => bool      |
     * ----------------------
     *
     * @return int | JsonResponse
     * */

    public static function create(array $data): int|JsonResponse
    {

        $data['password'] = Hash::make($data['password']);

        if (empty(self::$usersRead)) {
            $id = 0;
        } else {
            $id = end(self::$usersRead)->id + 1;
        }
        self::$usersRead[] = array_merge(['id' => $id], $data);

        try {
            file_put_contents(self::$filename, json_encode(self::$usersRead));
            return $id;
        } catch (Exception $exception) {
            return response()->json([
                'error' => 'failed database save'
            ], 406);
        }

    }

    /**
     * @param array $data
     * @return mixed|null
     */
    public static function email_in_use(array $data): mixed
    {
        $email = $data['email'];

        if (is_null(self::$usersRead))
            return null;

        foreach (self::$usersRead as &$item) {
            if ($item->email == $email)
                return $item;
        }
        return null;

    }

    /**
     * @param array $data
     * @return mixed|null
     */
    public static function is_user(array $data): mixed
    {

        $user = self::email_in_use($data);

        if ($password = Hash::check($data['password'], $user->password))
            return $user;
        return null;

    }

    /**
     * @param string|null $token
     * @return mixed
     */
    public function is_admin(?string $token): mixed
    {

        return null;
    }


}
