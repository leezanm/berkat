<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users with different roles using firstOrCreate to avoid duplicates
        User::firstOrCreate(
            ['email' => 'member@test.com'],
            ['name' => 'Member Test', 'password' => bcrypt('password'), 'role' => 'member']
        );

        User::firstOrCreate(
            ['email' => 'agent@berkat.com'],
            ['name' => 'Agen BERKAT', 'password' => bcrypt('password'), 'role' => 'agent']
        );

        User::firstOrCreate(
            ['email' => 'agent2@berkat.com'],
            ['name' => 'Agen BERKAT 2', 'password' => bcrypt('password'), 'role' => 'agent']
        );

        User::firstOrCreate(
            ['email' => 'jk@berkat.com'],
            ['name' => 'JK Committee', 'password' => bcrypt('password'), 'role' => 'jk']
        );

        User::firstOrCreate(
            ['email' => 'admin@berkat.com'],
            ['name' => 'Admin', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        // Seed request types, categories and subcategories
        $this->call([
            RequestTypeSeeder::class,
            DummyAssistanceRequestSeeder::class,
        ]);
    }
}
