<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\Users;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends JWTController
{
    protected Users $model;

    public function __construct()
    {
        $this->model = new Users();
        date_default_timezone_set('America/Sao_Paulo');

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function insert(Request $request): JsonResponse
    {
        $inputs = ['email', 'password', 'admin'];

        $data = $request->only($inputs);
        (int)$id = Users::insert($data);

        $token = $this->JWTCreateToken($request, $id);

        return $this->respondWithToken($token);

    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function login(Request $request): ?JsonResponse
    {

        $data = $request->only(['email', 'password']);

        $user = Users::is_user($data);

        if (is_null($user))
            return response()->json(['error' => 'User or password incorrect'], 401);

        $token = JWTController::JWTCreateToken($request, $user->id);

        return $this->respondWithToken($token);

    }

    /**
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => date('d/m/Y \à\s H:i:s', time() + 3600)

        ]);
    }
}
