<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class filesExists
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse | JsonResponse
     *
     */
    public function handle(Request $request, Closure $next)
    {

        $filename = [
            __DIR__ . '/../../../database/temp/favorites.json',
            __DIR__ . '/../../../database/temp/users.json',
        ];

        foreach ($filename as $name) {
            if (!file_exists($name)) {
                try {
                    $file = fopen($name, "w") or die("Unable to open file!");
                    fwrite($file, '');
                } catch (Exception $exception) {
                    return response()->json([
                        'error' => $exception
                    ]);
                }
            }
        }

        return $next($request);
    }
}
