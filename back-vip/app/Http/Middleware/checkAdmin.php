<?php

namespace App\Http\Middleware;

use App\Http\Controllers\api\JWTController;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PharIo\Version\Exception;

class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response|Application|ResponseFactory|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|Application|ResponseFactory| RedirectResponse

    {
        (string)$token = $request->bearerToken();

        try {
            $validate = JWTController::JWTValidate($token);
        } catch (\Exception $exception) {
            return response([]);
        }

        return \response([]);
    }
}
