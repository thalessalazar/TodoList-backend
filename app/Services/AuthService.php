<?php

namespace App\Services;

use App\Events\PasswordResetRequested;
use App\Events\UserRegistered;
use App\Exceptions\AuthWrongPasswordException;
use App\Exceptions\LoginInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\VerifyEmailTokenInvalidException;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(string $email, string $password): array
    {
        $login = [
            'email' => $email,
            'password' => $password
        ];

        if (!$token = auth()->attempt($login)) {
            throw new LoginInvalidException;
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
    }

    public function register(
        string $first_name,
        string $last_name,
        string $email,
        string $password
    ): User {
        if (User::where('email', $email)->first()) {
            throw new UserHasBeenTakenException();
        }

        $user = User::create(
            [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => bcrypt($password),
                'confirmation_token' => Str::random(60),
            ]
        );

        event(new UserRegistered($user));

        return $user;
    }

    public function verifyEmail(string $verify_token): User
    {
        $user = User::where('confirmation_token', $verify_token)->first();

        if (empty($user))
            throw new VerifyEmailTokenInvalidException();

        $user->verifiedEmail()->save();

        return $user;
    }

    public function forgotPassword(string $email): void
    {
        $user = User::where('email', $email)->firstOrFail();

        if ($password_reset_finded = PasswordReset::where('email', $email)->first())
            $password_reset_finded->delete();

        $password_reset = PasswordReset::create([
            'email' => $user->email,
            'token' => Str::random(60),
        ]);

        event(new PasswordResetRequested($password_reset, $user));

        return;
    }

    public function resetPassword(
        string $email,
        string $new_password,
        string $token
    ): void {
        $user = User::where('email', $email)->firstOrFail();

        $passwordReset = PasswordReset::where([
            ['email', $email],
            ['token', $token]
        ])->firstOrFail();

        $user->password = bcrypt($new_password);

        $user->save();

        $passwordReset->delete();

        return;
    }

    public function verifyForgotPasswordToken(string $token)
    {
        PasswordReset::where('token', $token)->firstOrFail();

        return;
    }

    public function updatePassword(string $password, string $new_password): void
    {
        $user = auth()->user();

        if (!!Hash::check($new_password, $user->password)) {
            throw new AuthWrongPasswordException();
        }

        $user->password = bcrypt($new_password);

        $user->save();

        return;
    }
}
