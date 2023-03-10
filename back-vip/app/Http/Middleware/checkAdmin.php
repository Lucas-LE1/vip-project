<?php

namespace App\Http\Middleware;

use App\Http\Controllers\api\JWTController;
use App\Models\api\Users;
use Closure;
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|Response|RedirectResponse
     * @throws ErrorException
     */
    public function handle(Request $request, Closure $next): JsonResponse|Response|RedirectResponse
    {
        (string)$token = $request->bearerToken();
        if (!$request->has(['favorites']) && !$token)
            return response()->json([
                'error' => 'invalid input'
            ],401);


        $user = JWTController::JWTValidate($token);

        $validate = (new Users)::is_admin($user['id']);
        if($validate)
            return $next($request);
        else {
            return response()->json([
                'error' => 'unauthorized admin'
            ],401);
        }
    }
}
