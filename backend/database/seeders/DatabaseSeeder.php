<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Payment::factory(100)->create();
        \App\Models\User::factory()->create([
            'email' => 'test-cyberzilla@malahov-artem.ru',
            'password' => bcrypt('BqlxFiMYHmCdjnDngJiTpJTgtuAZGQwk'),
        ]);
    }
}
