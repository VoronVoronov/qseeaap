<?php

namespace App\DTO;

class UserDTO
{
    public string $name;
    public string $phone;
    public string $password;
    public string $registered_at;
    public string $last_login_at;
    public string $register_ip;
    public string $last_login_ip;
    public bool $is_active;
    public string $phone_verified_at;

    public function __construct(string $name, string $phone, string $password, string $registered_at, string $last_login_at, string $register_ip, string $last_login_ip, string $is_active, string $phone_verified_at)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->password = $password;
        $this->registered_at = $registered_at;
        $this->last_login_at = $last_login_at;
        $this->register_ip = $register_ip;
        $this->last_login_ip = $last_login_ip;
        $this->is_active = $is_active;
        $this->phone_verified_at = $phone_verified_at;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'password' => $this->password,
            'registered_at' => $this->registered_at,
            'last_login_at' => $this->last_login_at,
            'register_ip' => $this->register_ip,
            'last_login_ip' => $this->last_login_ip,
            'is_active' => $this->is_active,
            'phone_verified_at' => $this->phone_verified_at,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
