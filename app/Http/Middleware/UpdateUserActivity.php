<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserActivity
{
    
    public function handle(Request $request, Closure $next): Response
    {
        $request->user()->active_time= now();
        $request->user()->save();
        return $next($request);
    }
}
