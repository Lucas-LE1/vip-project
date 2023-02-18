<?php

namespace App\Http\Middleware;

use App\Http\Controllers\api\JWTController;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class validateToken
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse

    {
        (string)$token = $request->bearerToken();
        if (is_null($token))
            return $next($request);

        try {
            $validate = JWTController::JWTValidate($token);
            return $next($request);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }
}
