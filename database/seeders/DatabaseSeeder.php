<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CurrencyRate;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Wallet::factory(5)->create();
        CurrencyRate::factory()->create([
            'from' => 'RUB',
            'to' => 'USD',
            'rate' => 0.012
        ]);
        CurrencyRate::factory()->create([
            'from' => 'USD',
            'to' => 'RUB',
            'rate' => 81.7
        ]);
    }
}
