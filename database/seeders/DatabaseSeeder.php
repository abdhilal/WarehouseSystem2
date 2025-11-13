<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            WarehouseSeeder::class,
            AreaSeeder::class,
            FactorySeeder::class,
            RepresentativeSeeder::class,
            PharmacySeeder::class,
            ProductSeeder::class,
            TransactionSeeder::class,
            FileSeeder::class,
            UserSeeder::class,
        ]);
    }
}
