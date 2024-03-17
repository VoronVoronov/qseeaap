<?php

namespace App\Services;

use App\Services\Base\BaseService;
use App\Repository\TariffRepository;

class TariffService extends BaseService
{
    public function __construct(
        protected TariffRepository $tariffRepository
    ){}

    public function index()
    {
        return $this->tariffRepository->active();
    }

    public function show($id)
    {
        return $this->tariffRepository->show($id);
    }

    public function store($data)
    {
        return $this->tariffRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->tariffRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->tariffRepository->delete($id);
    }
}
