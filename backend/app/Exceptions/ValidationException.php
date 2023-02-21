<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException as LaravelValidationException;
use RuntimeException;
use Throwable;

class ValidationException extends LaravelValidationException
{
    public function __construct(array $messages)
    {
        try {
            parent::__construct(tap(app(Factory::class)->make([], []), function ($validator) use ($messages) {
                foreach ($messages as $key => $value) {
                    $value = ! is_array($value) ? [$value] : $value;
                    foreach ($value as $message) {
                        $validator->errors()->add($key, $message);
                    }
                }
            }));
        } catch (Throwable $e) {
            throw new RuntimeException('failed create validator', 0, $e);
        }
    }
}
