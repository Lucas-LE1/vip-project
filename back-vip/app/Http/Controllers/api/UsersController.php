<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\UsersModel;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected UsersModel $model;

    public function __construct()
    {
        $this->model = new UsersModel();
    }

    public function createUser(Request $request): JsonResponse
    {
        $data = $request->only(['email', 'password', 'admin']);
        $statusData = UsersModel::create($data);

        $key = env('JWT_SECRET_KEY');
        $payload = [
            'id' => $statusData,
            'iss' => env('APP_URL'),
            'aud' => $request->fullUrl(),
            'iat' => 1356999524,
            'nbf' => 1357000000,
            'exp' => time() + 10
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $payload['exp']
        ]);

    }
}
