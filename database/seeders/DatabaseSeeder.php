<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user for authentication
        User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
        ]);

        // Seed all entities
        $this->call([
            ProductSeeder::class,
            CustomerSeeder::class,
            ChannelSeeder::class,
            PaymentSeeder::class,
            AdminSeeder::class,
            SaleSeeder::class,
        ]);
    }
}
