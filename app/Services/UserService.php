<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\Services\Base\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use function Laravel\Prompts\password;

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
        $data['password'] = Hash::isHashed($data['password']) ? $data['password'] : Hash::make($data['password']);
        $data['registered_at'] = now()->toDateTimeString();
        $data['register_ip'] = request()->ip();
        $user = $this->userRepository->create($data);
        $data['code'] = rand(1000, 9999);
        $data['message'] = __('user.your_sms_code', ['code' => $data['code']]);
        $this->codeService->sendCode($data);
        return $user->createToken('auth-access-token')->accessToken;
    }

    public function login(array $data): string
    {
        $user = $this->userRepository->findByPhone($data['phone']);
        if(!$user) {
            throw new ModelNotFoundException(__('user.not_found'), ResponseAlias::HTTP_BAD_REQUEST);
        }
        if (Hash::check($data['password'], $user->getAuthPassword())){
            $user->last_login_at = now()->toDateTimeString();
            $user->last_login_ip = request()->ip();
            $user->save();
            $user->tokens()->delete();
            if($data['remember']){
                $user->setRememberToken($user->id);
            }
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
            $user->phone_verified_at = now()->toDateTimeString();
            $user->save();
        }
        return $status;
    }

    public function sendSMS(array $data): array
    {
        $id = $this->codeService->sendCode($data);
        if($id == -1){
            throw new ModelNotFoundException(__('user.sms_already_sent'), ResponseAlias::HTTP_BAD_REQUEST);
        }else if ($id == 0) {
            throw new ModelNotFoundException(__('user.sms_not_sent'), ResponseAlias::HTTP_BAD_REQUEST);
        }
        return ['sms_id' => $id, 'message' => __('user.sms_sent')];
    }

    public function logout($user): bool
    {
        return $user->tokens()->delete();
    }

    public function resetPassword(array $all): array
    {
        $user = $this->userRepository->findByPhone($all['phone']);
        if(!$user){
            throw new ModelNotFoundException(__('user.not_found'), ResponseAlias::HTTP_BAD_REQUEST);
        }
        $password = \Str::password(8);
        $arr = array(
            'phone' => $all['phone'],
            'code' => $password,
            'message' => __('user.your_new_password', ['password' => $password]),
        );
        $id = $this->codeService->sendCode($arr, 'reset_password');
        if($id == -1){
            throw new ModelNotFoundException(__('user.sms_already_sent'), ResponseAlias::HTTP_BAD_REQUEST);
        }else if ($id == 0) {
            throw new ModelNotFoundException(__('user.sms_not_sent'), ResponseAlias::HTTP_BAD_REQUEST);
        }
        $this->userRepository->update($user->id, ['password' => Hash::make($password)]);
        return ['sms_id' => $id, 'message' => __('user.password_reset')];
    }
}
