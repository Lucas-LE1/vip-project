<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class userExists
{
    protected string $email;

    /**
     * Handle an incoming request.
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse | JsonResponse
     */
    public function handle(Request $request, Closure $next): Response | RedirectResponse | JsonResponse
    {
        $filename = __DIR__ . '/../../../database/temp/users.json';

        $usersRead = json_decode(file_get_contents($filename));

        if (!empty($usersRead)) {
            $email = $request['email'];

            $new = array_filter($usersRead, function ($item) use ($email) {
                return $item->email == $email;
            });

            if (!empty($new))
                return $next($request);
        }

        return $next($request);

    }
}
