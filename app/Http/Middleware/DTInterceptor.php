<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DTInterceptor
{
    public function handle(Request $request, Closure $next)
    {
        $hostList = [];
        $services = explode(',', env('OPBEANS_SERVICES'));
        $probability = floatval(env("OPBEANS_DT_PROBABILITY", "0.5"));

        foreach ($services as $service){
            if (empty($service) || str_contains($request->path(), 'stats')) {
                return $next($request);
            }

            $hostList[] = 'http://' . $service . ':3000/' . $request->path();
        }

        if( (mt_rand() / mt_getrandmax()) <= $probability){
            $response = Http::get($hostList[array_rand($hostList)])->json();

            abort(response()->json($response));
        }

        return $next($request);
    }
}
