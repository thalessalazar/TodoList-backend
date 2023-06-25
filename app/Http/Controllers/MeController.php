<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateImageProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Jobs\DeleteFile;
use App\Services\UserService;
use Illuminate\Support\Facades\Storage;

class MeController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService, Storage $storage)
    {
        $this->userService = $userService;
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
        $user = auth()->user();

        $path = $this->store($request->image_profile, $user->id);

        $oldImageProfileUrl = $user->image_profile;

        $user->image_profile = $path;

        $user->save();

        if ($oldImageProfileUrl)
            dispatch(new DeleteFile($oldImageProfileUrl));

        $user->fresh();

        return new UserResource($user);
    }

    public function store($image_profile, int $user_id)
    {
        $path = Storage::disk('s3')->put((string) $user_id, $image_profile);
        Storage::disk('s3')->setVisibility($path, 'public');
        return Storage::disk('s3')->url($path);
    }
}
