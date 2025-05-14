<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Resources\UserResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        if ($request->wantsJson()) {
            $user = auth()->user();
            if ($user) {
                $token = $user->createToken('BrowserUsersGrantToken')->accessToken;
                return response(['status' => true, 'user' => $user, 'token' => $token, 'token_expiration' => now()->addDays(29)], 200);
            } else {
                return response(['status' => false, 'data' => $user->getRememberToken()], 400);
            }
        } else {
            return response(['status' => false, 'data' => []], 422);
        }
    }

    public function status(Request $request): UserResource
    {
        return new UserResource($this->userRepository->tokens());
    }
}
