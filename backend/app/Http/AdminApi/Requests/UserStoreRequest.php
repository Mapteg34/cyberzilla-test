<?php

declare(strict_types=1);

namespace App\Http\AdminApi\Requests;

use App\Models\User;
use Illuminate\Validation\Rules\Unique;

/**
 * @property-read string $email
 * @property-read string $password
 * @property-read string $name
 * @property-read string $phone
 */
class UserStoreRequest extends AbstractAuthenticatedRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                new Unique(app(User::class)->getTable(), 'email'),
            ],
            'password' => [
                'required',
                'string',
            ],
            'name' => [
                'required',
                'string',
            ],
            'phone' => [
                'required',
                'string',
            ],
        ];
    }
}
