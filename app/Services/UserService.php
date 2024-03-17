<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\Services\Base\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserService extends BaseService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly CodeService $codeService
    ){}

    /**
     * @throws GuzzleException
     */
    public function register(array $data): string
    {
        $find = $this->userRepository->findByPhone($data['phone']);
        if($find) {
            throw new ModelNotFoundException(__('user.phone_exists'), ResponseAlias::HTTP_BAD_REQUEST);
        }
        unset($data['password_confirmation']);
        $user = $this->userRepository->create($data);
        $this->codeService->sendCode($data['phone']);
        return $user->createToken('auth-access-token')->accessToken;
    }

    public function login(array $data): string
    {
        $user = $this->userRepository->findByPhone($data['phone']);
        if(!$user) {
            throw new ModelNotFoundException(__('user.not_found'), ResponseAlias::HTTP_BAD_REQUEST);
        }
        if (Hash::check($data['password'], $user->getAuthPassword())){
            $user->last_login_at = now();
            $user->last_login_ip = request()->ip();
            $user->save();
            $user->tokens()->delete();
            return $user->createToken("auth-access-token")->accessToken;
        }else{
            throw new InvalidArgumentException(__('user.wrong_password'), ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

    public function checkCode(array $data): bool
    {
        $status = $this->codeService->checkCode($data);
        if($status){
            $user = $this->userRepository->findByPhone($data['phone']);
            $user->is_active = true;
            $user->phone_verified_at = now();
            $user->save();
        }
        return $status;
    }

    public function logout($user): bool
    {
        return $user->tokens()->delete();
    }
}
