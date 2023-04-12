<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateImageProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Support\Facades\Storage;

class MeController extends Controller
{
    private UserService $userService;
    private $storage;

    public function __construct(UserService $userService, Storage $storage)
    {
        $this->userService = $userService;
        $this->storage = $storage::disk('s3');
    }

    public function index()
    {
        return new UserResource(auth()->user());
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $input = $request->validated();
        return new UserResource(
            $this->userService->updateProfile($input)
        );
    }

    public function updateImageProfile(UpdateImageProfileRequest $request)
    {
        $input = $request->validated();

        $file = $input->file('image_profile');

        $this->storage->put(auth()->user()->generateImageProfilePath(), $file);
    }
}
