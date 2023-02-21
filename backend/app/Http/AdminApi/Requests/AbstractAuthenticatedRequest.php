<?php

declare(strict_types=1);

namespace App\Http\AdminApi\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\UnauthorizedException;

abstract class AbstractAuthenticatedRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User|null $user */
        $user = $this->user();

        return ! empty($user) && ! empty($user->id);
    }

    /** @inheritDoc */
    public function user($guard = null): User
    {
        $user = parent::user($guard);

        if (empty($user)) {
            throw new UnauthorizedException();
        }

        if (! ($user instanceof User)) {
            throw new UnauthorizedException();
        }

        return $user;
    }
}
