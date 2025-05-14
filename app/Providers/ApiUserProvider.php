<?php

namespace App\Providers;


use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class ApiUserProvider implements UserProvider
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function retrieveById($identifier): ?Authenticatable
    {
        return User::findOrFail($identifier);
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        $user = User::findOrFail($identifier);
        if (!$user) {
            return null;
        }
        $rememberToken = $user->getRememberToken();
        if ($rememberToken) {
            if (hash_equals($rememberToken, $token)) {
                return $user;
            }
        }
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        $user->setRememberToken($token);
    }

    /**
     * @throws Exception
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $response = $this->userRepository->authenticate(
            $credentials['username'],
            $credentials['password'],
        );
        $token = $response->get('token');
        if (!$token) {
            return null;
        }
        $user = User::where('username', $response['user']['username'])->where(
            'email', $response['user']['email']
        )->first();
        if(!$user){
            $user = User::create(
                ['username' => $response['user']['username'], 'email' => $response['user']['email']]
            );
        }
        $user->remember_token = $token;
        $user->save();
        return $user;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return true;
    }
}
