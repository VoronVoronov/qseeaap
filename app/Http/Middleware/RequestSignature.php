<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        if(!$request->hasHeader('X-API-Signature')){
//            return response()->json(['message' => 'Not Signature Request'], Response::HTTP_UNAUTHORIZED);
//        }
//        if($request->header('X-API-Signature') !== $this->hash($request->getContent())){
//            return response()->json(['message' => 'Not Validate Signature'], Response::HTTP_UNAUTHORIZED);
//        }
        return $next($request);
    }

    public function hash($data)
    {
        return hash_hmac('sha256', $data, env('API_SECRET'));
    }
}
