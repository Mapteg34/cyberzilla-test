<?php

declare(strict_types=1);

namespace App\Http\AdminApi\Controllers;

use App\Http\AbstractController;
use App\Http\AdminApi\Requests\PaginationRequest;
use App\Http\AdminApi\Requests\UserStoreRequest;
use App\Http\AdminApi\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersController extends AbstractController
{
    public function index(PaginationRequest $request): AnonymousResourceCollection
    {
        return UserResource::collection(User::query()->orderBy('id')->paginate($request->perPage));
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->save();

        return new UserResource($user);
    }

    public function destroy(User $user): void
    {
        $user->delete();
    }
}
