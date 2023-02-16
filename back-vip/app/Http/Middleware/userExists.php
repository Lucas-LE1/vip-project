<?php

namespace App\Http\Middleware;

use App\Models\api\UsersModel;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function PHPUnit\Framework\isEmpty;

class userExists
{
    protected string $email;

    /**
     * Handle an incoming request.
     * @param Request $request
     * @param Closure $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next): Response | RedirectResponse | JsonResponse
    {

//        $model = new UsersModel();
        $validated = UsersModel::is_user($request['email']);

        if (is_null($validated))
            return $next($request);

        return \response()->json([
            'error'=>'email address in user'
        ],401);

    }
}
