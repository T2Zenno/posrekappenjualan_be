<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Channel;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
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
        // Hapus pemanggilan seeder individual
        // $this->call([...]);

        // Buat pengguna pertama
        User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
        ]);

        // Buat pengguna kedua
        User::factory()->create([
            'name' => 'Another User',
            'username' => 'anotheruser',
        ]);

        // Loop melalui setiap user dan buat data terkait untuk mereka
        User::all()->each(function ($user) {
            // Buat data master untuk setiap user
            $products = Product::factory()->count(10)->for($user)->create();
            $customers = Customer::factory()->count(10)->for($user)->create();
            $channels = Channel::factory()->count(5)->for($user)->create();
            $payments = Payment::factory()->count(5)->for($user)->create();
            $admins = Admin::factory()->count(3)->for($user)->create();

            // Buat 50 data penjualan untuk setiap user, menggunakan data master di atas
            Sale::factory()->count(50)->for($user)->create([
                'product_id' => $products->random()->id,
                'customer_id' => $customers->random()->id,
                'channel_id' => $channels->random()->id,
                'payment_id' => $payments->random()->id,
                'admin_id' => $admins->random()->id,
            ]);
        });
    }
}
