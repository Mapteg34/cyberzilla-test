<?php

declare(strict_types=1);

namespace App\Http\AdminApi\Requests;

class AuthenticatedRequest extends AbstractAuthenticatedRequest
{
    public function rules(): array
    {
        return [];
    }
}
