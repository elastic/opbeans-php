<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DTInterceptor
{
    public function handle(Request $request, Closure $next)
    {
        if (random_int(0, 1) == 1) {
            $apiRequest = substr($request->url(), strpos($request->url(), "/api/") + 1);
            $response = Http::get('http://opbeans-python-api:3000/' . $apiRequest)->json();

            abort(response()->json($response));
        }

        return $next($request);
    }
}
