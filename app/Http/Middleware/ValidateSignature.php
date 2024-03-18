<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ValidateSignature as Middleware;
use Symfony\Component\HttpFoundation\Response;

class ValidateSignature extends Middleware
{
    /**
     * The names of the query string parameters that should be ignored.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',
        // 'utm_campaign',
        // 'utm_content',
        // 'utm_medium',
        // 'utm_source',
        // 'utm_term',
    ];

    public function handle($request, Closure $next, ...$args)
    {
        if(!$request->hasHeader('X-API-Signature')){
            return response()->json(['message' => 'Not Signature Request'], Response::HTTP_UNAUTHORIZED);
        }
        if($request->header('X-API-Signature') !== $this->hash($request->getContent())){
            return response()->json(['message' => 'Not Validate Signature'], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }

    public function hash($data): string
    {
        return hash_hmac('sha256', $data, env('API_SECRET'));
    }
}
