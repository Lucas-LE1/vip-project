<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\UsersModel;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends JWTController
{
    protected UsersModel $model;

    public function __construct()
    {
        $this->model = new UsersModel();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addUser(Request $request): JsonResponse
    {
        $data = $request->only(['email', 'password', 'admin']);
        (int)$id = UsersModel::create($data);

        $token = $this->JWTCreateToken($request,$id);

        return $this->respondWithToken($token);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function loginUser(Request $request): JsonResponse
    {

        $data = $request->only(['email', 'password']);

        $user = UsersModel::is_user($data);

        $token = JWTController::JWTCreateToken($request,$user->id);

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
//            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
