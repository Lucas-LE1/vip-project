<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
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

    public static function create(array $data) : int | JsonResponse
    {

        if (empty(self::$usersRead)) {
            $id = 0;
        } else {
            $id = end(self::$usersRead)->id+1;
        }
        self::$usersRead[] = array_merge(['id'=>$id], $data);

        try {
            file_put_contents(self::$filename, json_encode(self::$usersRead));
            return $id;
        } catch (Exception $exception) {
            return response()->json([
                'error'=>'failed database save'
            ],406);
        }

    }

    public static function is_user(string $email) {

        if (!empty(self::$usersRead)) {

            $userFilter = array_filter(self::$usersRead, function ($item) use ($email) {
                return $item->email == $email;
            });
            if (!empty($userFilter))
                return $userFilter;
        }
        return null;
    }

    public function is_admin(array|null $email) {
        $user = $this->is_user($email);

        return $user->admin;

    }


}
