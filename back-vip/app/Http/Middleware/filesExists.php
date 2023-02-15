<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class filesExists
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse | JsonResponse
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
                } catch (\Exception $exception) {
                    return response()->json([
                        'error' => $exception
                    ]);
                }
            }
        }

        return $next($request);
    }
}
