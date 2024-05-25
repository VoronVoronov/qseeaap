<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

class Locale extends Middleware
{
    public function handle($request, Closure $next, ...$args)
    {
        if($request->hasHeader('Locale')){
            app()->setLocale($request->header('Locale'));
        }
        return $next($request);
    }
}
