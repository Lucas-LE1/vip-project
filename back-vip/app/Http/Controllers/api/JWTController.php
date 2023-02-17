<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

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
            'iat' => 1356999524,
            'nbf' => 1357000000,
            'exp' => time() + 10
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
    public static function JWTValidate(string $token): \stdClass
    {
        $key = env('JWT_SECRET_KEY');
        return JWT::decode($token, new Key($key, 'HS256'));
    }
}
