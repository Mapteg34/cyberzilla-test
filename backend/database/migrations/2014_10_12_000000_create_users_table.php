<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use JetBrains\PhpStorm\Pure;

return new class extends Migration {
    private Builder $builder;

    private string $table;

    public function __construct()
    {
        $this->builder = app(ConnectionInterface::class)->getSchemaBuilder();
        $this->table = app(User::class)->getTable();
    }

    public function up(): void
    {
        $this->getBuilder()->create($this->getTable(), function (Blueprint $table): void {
            $table->id();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('password');
            $table->string('phone');
            $table->timestamps();
        });
    }

    #[Pure]
    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    #[Pure]
    public function getTable(): string
    {
        return $this->table;
    }
};
