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

        try {
            $validated = JWTController::JWTValidate($token);

        } catch (\Exception $exception) {
            return response()->json(['error' => 'Unauthorized Token'], 401);
        }
            return $next($request);

    }
}
