<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenMiddleware {
    public function handle($request, Closure $next) {
        if ($request->header('Authorization') !== 'vg@123') {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}

