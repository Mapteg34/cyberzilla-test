<?php

declare(strict_types=1);

namespace App\Http\AdminApi\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use InvalidArgumentException;

class UserResource extends JsonResource
{
    /** @inheritDoc */
    public function toArray($request): array
    {
        $resource = $this->resource;
        if (! ($resource instanceof User)) {
            throw new InvalidArgumentException('invalid resource');
        }

        return [
            'id' => $resource->id,
            'email' => $resource->email,
            'name' => $resource->name,
            'phone' => $resource->phone,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
        ];
    }
}
