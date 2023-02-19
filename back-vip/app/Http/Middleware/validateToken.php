<?php

namespace App\Http\Middleware;

use App\Http\Controllers\api\JWTController;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class validateToken
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse|Response|RedirectResponse

    {
        (string)$token = $request->bearerToken();
        if (!$token)
            return $next($request);

        try {
            $validated = JWTController::JWTValidate($token);

            return $next($request);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }
}
