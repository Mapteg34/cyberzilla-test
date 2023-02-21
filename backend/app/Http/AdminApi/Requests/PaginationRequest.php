<?php

declare(strict_types=1);

namespace App\Http\AdminApi\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $currentPage
 * @property-read int $perPage
 */
class PaginationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'currentPage' => [
                'required',
                'integer',
            ],
            'perPage' => [
                'required',
                'integer',
            ],
        ];
    }
}
