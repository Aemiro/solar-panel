<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Perform action
         if ($request->user()->role=='ADMIN') {
            return $next($request);
        }
        // Display a 403 Forbidden error
        abort(403);
        return $response;
    }
}
