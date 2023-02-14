<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    use HasFactory;

    public string $mode;

    public function validateFile() {
//        file_exists(__DIR__);
        echo(__DIR__);
    }


}
