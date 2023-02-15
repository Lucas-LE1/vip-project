<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use PHPUnit\Exception;

class UsersModel extends Model
{
    use HasFactory;

    public string $mode;

    protected mixed $usersRead;
    protected string $filename = __DIR__ . '/../../../database/temp/users.json';

    public function __construct()
    {
        parent::__construct();
        $this->usersRead = json_decode(file_get_contents($this->filename));
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

    public function create(array $data) : int | JsonResponse
    {

        if (empty($this->usersRead)) {
            $id = 0;
        } else {
            $id = end($this->usersRead)->id+1;
        }
        $this->usersRead[] = array_merge(['id'=>$id], $data);

        try {
            file_put_contents($this->filename, json_encode($this->usersRead));
            return $id;
        } catch (Exception $exception) {
            return response()->json([
                'error'=>'failed database save'
            ],406);
        }

    }


}
