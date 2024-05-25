<?php

namespace App\Services;

use App\Repository\CodeRepository;
use App\Services\Base\BaseService;
use App\Traits\SMS;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CodeService extends BaseService
{
    use SMS;
    public function __construct(
        protected CodeRepository $codeRepository,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function sendCode(string $phone, $action = 'register'): int
    {
        $lastCode = $this->codeRepository->getByPhone($phone);
        if ($lastCode && $lastCode->expired_at > Carbon::now()) {
            return -1;
        }
        $code = rand(1000, 9999);
        $message = "Ваш код подтверждения QSee: " . $code;
        $id = $this->Mobizon($phone, $message);
        if ($id == 0) {
            throw new ModelNotFoundException(__('user.sms_not_sent'), ResponseAlias::HTTP_BAD_REQUEST);
        }
        $data = array(
            'phone' => $phone,
            'code' => $code,
            'expired_at' => Carbon::now()->addMinutes(5),
            'message' => $message,
            'sms_id' => $id,
            'action' => $action,
        );
        unset($data['message']);
        $this->codeRepository->create($data);
        return $id;
    }

    public function checkCode(array $data): bool
    {
        $code = $this->codeRepository->getByPhone($data['phone']);
        if ($code->code == $data['code'] && $code->expired_at > Carbon::now() && !$code->is_used) {
            $this->codeRepository->update($code->id, ['is_used' => true]);
            return true;
        }elseif ($code->code != $data['code']){
            throw new ModelNotFoundException(__('user.code_not_valid'), ResponseAlias::HTTP_BAD_REQUEST);
        }
        throw new ModelNotFoundException(__('user.code_already_used'), ResponseAlias::HTTP_BAD_REQUEST);
    }

}
