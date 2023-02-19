<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;

class JWTController extends Controller
{
    protected static array $payload;

    /**
     * @param int $id
     * @param string $uri
     * @return void
     */
    public static function init(int $id, string $uri): void
    {
        self::$payload = [
            'id' => $id,
            'iss' => env('APP_URL'),
            'aud' => $uri,
            'iat' => time(),
            'nbf' => 1357000000,
            'exp' => time() + 3600
        ];

    }

    /**
     * @param Request $request
     * @param int $id
     * @return string
     */
    public function JWTCreateToken(Request $request, int $id): string
    {
        self::init($id,$request->getUri());

        $key = env('JWT_SECRET_KEY');

        return JWT::encode(self::$payload, $key, 'HS256');

    }
    public static function JWTValidate(string $token): JsonResponse|array
    {
        $key = env('JWT_SECRET_KEY');

        try {

        return (array)JWT::decode($token, new Key($key, 'HS256'));
        }catch (ExpiredException|SignatureInvalidException $exception) {
            return response()->json([
                'error' => 'unauthorized token'
            ],401);
        }
    }
}
