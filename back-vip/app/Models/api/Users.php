<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Exception;

class Users extends Model
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
     */

    /*
     * @return int | JsonResponse
     * */

    public static function insert(array $data): int|JsonResponse
    {
        $data['password'] = Hash::make($data['password']);

        if (!self::$usersRead) {
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
     * @param array|null $data
     * @param int|null $id_user
     * @return mixed|null
     */
    public static function email_in_use(?array $data = null, ?int $id_user = null): mixed
    {

        if (!self::$usersRead)
            return null;

        foreach (self::$usersRead as &$item) {

            if (isset($id_user)) {
                if ($item->id == $id_user) {
                    return $item;
                }
            } elseif ($data) {
                $emailOld = strtolower($item->email);
                $emailNew = strtolower($data['email']);
                if ($emailOld === $emailNew ) {
                    return $item;
                }
            }

        }
        return null;

    }

    /**
     * @param array|null $data
     * @param int|null $id_user
     * @return mixed|null
     */
    public static function is_user(array $data = null, int $id_user = null): mixed
    {
        $user = self::email_in_use(data: $data, id_user: $id_user);


        if (isset($id_user))
            return $user;

        if ($user && Hash::check($data['password'], $user->password))
            return $user;
        return null;

    }

    /**
     * @param int|null $id_user
     * @return bool|null
     */
    public static function is_admin(?int $id_user): ?bool
    {
        $user = self::is_user(id_user: $id_user);
        if ($user) {
            return $user->admin === 1;
        } else {
            return false;
        }
    }


}
