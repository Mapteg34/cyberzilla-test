<?php

declare(strict_types=1);

namespace App\Http\AdminApi\Controllers;

use App\Http\AbstractController;
use App\Http\AdminApi\Resources\PaymentResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersPaymentsController extends AbstractController
{
    public function index(User $user): AnonymousResourceCollection
    {
        return PaymentResource::collection($user->payments()->paginate());
    }
}
