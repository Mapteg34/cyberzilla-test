<?php

declare(strict_types=1);

namespace App\Http\AdminApi\Resources;

use App\Models\Payment;
use Illuminate\Http\Resources\Json\JsonResource;
use InvalidArgumentException;

class PaymentResource extends JsonResource
{
    /** @inheritDoc */
    public function toArray($request): array
    {
        $resource = $this->resource;
        if (! ($resource instanceof Payment)) {
            throw new InvalidArgumentException('invalid resource');
        }

        return [
            'id' => $resource->id,
            'sum' => $resource->sum,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
        ];
    }
}
