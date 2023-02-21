<?php

declare(strict_types=1);

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use JetBrains\PhpStorm\Pure;

return new class extends Migration {
    private Builder $builder;

    private string $paymentsTable;

    public function __construct()
    {
        $this->builder = app(ConnectionInterface::class)->getSchemaBuilder();
        $this->paymentsTable = app(Payment::class)->getTable();
    }

    public function up(): void
    {
        $this->getBuilder()->create($this->getPaymentsTable(), function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->double('sum')->unsigned();
            $table->timestamps();
        });
    }

    #[Pure]
    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    #[Pure]
    public function getPaymentsTable(): string
    {
        return $this->paymentsTable;
    }
};
