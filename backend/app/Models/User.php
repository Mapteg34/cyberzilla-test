<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $phone
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection<Payment> $payments
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getJWTIdentifier(): int
    {
        return $this->id;
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
