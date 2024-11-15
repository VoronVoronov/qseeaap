<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\User\RegisterRequest;
use App\Http\Requests\API\v1\User\LoginRequest;
use App\Http\Requests\API\v1\User\CheckCodeRequest;
use App\Http\Requests\API\v1\User\ResetPasswordRequest;
use App\Services\UserService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\API\v1\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $service
    ) {}

    /**
     * @throws GuzzleException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->sendResponse(['token' => $this->service->register($request->all())]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->sendResponse($this->service->login($request->all()));
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->sendResponse($this->service->resetPassword($request->all()));
    }

    public function checkCode(CheckCodeRequest $request): JsonResponse
    {
        return $this->sendResponse($this->service->checkCode($request->all()));
    }

    public function sendSms(Request $request)
    {
        return $this->sendResponse($this->service->sendSMS($request->all()));
    }

    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }


    public function getUser(Request $request): UserResource
    {
        return $this->show($request->user());
    }

    public function logout(Request $request)
    {
        return $this->sendResponse(['status' => $this->service->logout($request->user())]);
    }
}
