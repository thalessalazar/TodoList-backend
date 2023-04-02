<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function updateProfile(
        array $data
    ) {
        $user = auth()->user();

        $user->fill($data);

        $user->save();

        return $user->fresh();
    }
}
