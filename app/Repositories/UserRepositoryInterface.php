<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function authenticate($username, $password);
}
