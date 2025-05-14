<?php

namespace App\Repositories;


use Illuminate\Support\Collection;

class UserRepository extends BaseApiRepository implements UserRepositoryInterface
{

    public function authenticate($username, $password): Collection
    {
        $response = $this->post("/api/auth/login/", [
            'username' => $username,
            'password' => $password
        ]);
        return collect(
            $response
        );
    }

    public function register($data): Collection
    {
        $response = $this->post("/api/auth/register/", [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'name' => $data['name'],
            'company' => $data['company'],
        ]);
        return collect(
            $response
        );
    }

    public function tokens():array
    {
        $this->setHeaderToken();
        return $this->get("/api/auth/user/get-tokens/");
    }
}
