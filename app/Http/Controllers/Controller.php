<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendResponse(array $data, int $customStatus = ResponseAlias::HTTP_OK): JsonResponse
    {
        return response()->json($data, $customStatus);
    }

    public function sendErrorResponse(array $data, int $code = ResponseAlias::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json($data, $code);
    }

}
