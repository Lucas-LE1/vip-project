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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createUser(Request $request): JsonResponse
    {
        $data = $request->only(['email', 'password', 'admin']);
        (int)$id = UsersModel::create($data);

        $token = JWTController::JWTCreateToken($request,$id);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);

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

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);

    }
}
