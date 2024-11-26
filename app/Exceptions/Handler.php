<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $status = Response::HTTP_BAD_REQUEST;
        if($e->getCode() > 0) {
            $status = $e->getCode();
        }
        if($request->expectsJson()) {
            return response()->json([
                'message' => $e->getMessage()
            ], $status);
        } else {
            return response($e->getMessage(), $status);
        }
    }

}
