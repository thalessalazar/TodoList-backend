<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthForgotPasswordRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthResetPasswordRequest;
use App\Http\Requests\AuthUpdatePasswordRequest;
use App\Http\Requests\AuthVerifyEmailRequest;
use App\Http\Requests\AuthVerifyForgotPasswordTokenRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthLoginRequest $request)
    {
        $input = $request->validated();

        $token = $this->authService->login($input['email'], $input['password']);

        return (new UserResource(auth()->user()))->additional($token);
    }

    public function register(AuthRegisterRequest $request)
    {
        $input = $request->validated();

        return new UserResource(
            $this->authService->register(
                $input['first_name'],
                $input['last_name'],
                $input['email'],
                $input['password'],
            )
        );
    }

    public function verifyEmail(AuthVerifyEmailRequest $request)
    {
        $input = $request->validated();

        return new UserResource($this->authService->verifyEmail($input['token']));
    }

    public function forgotPassword(AuthForgotPasswordRequest $request)
    {
        $input = $request->Validated();

        return $this->authService->forgotPassword($input['email']);
    }

    public function resetPassword(AuthResetPasswordRequest $request)
    {
        $input = $request->validated();

        return $this->authService->resetPassword(
            $input['email'],
            $input['new_password'],
            $input['token']
        );
    }

    public function verifyForgotPasswordToken(AuthVerifyForgotPasswordTokenRequest $request)
    {
        $input = $request->validated();
        return $this->authService->verifyForgotPasswordToken($input['token']);
    }

    public function updatePassword(AuthUpdatePasswordRequest $request)
    {
        $input = $request->validated();
        return $this->authService->updatePassword($input['password'], $input['new_password']);
    }
}
