<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChackCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->user()->role!=='user'&& auth()->user()->role!=='admin'&& auth()->user()->role!=='customer'){

            return \response()->json([
                'error'=>'you Do Not Have Permission you are not admin or user or user '
            ],400);
        }
        return $next($request);
    }
}
