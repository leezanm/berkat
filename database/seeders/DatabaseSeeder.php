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
        // Cipta pengguna ujian dengan peranan berbeza menggunakan firstOrCreate
        // untuk mengelakkan duplikat

        // Cipta Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Pentadbir Sistem BERKAT', 'password' => bcrypt('password'), 'role' => 'admin', 'email_verified_at' => now()]
        );

        User::firstOrCreate(
            ['email' => 'admin@berkat.com'],
            ['name' => 'Admin', 'password' => bcrypt('password'), 'role' => 'admin', 'email_verified_at' => now()]
        );

        // Cipta Agen
        User::firstOrCreate(
            ['email' => 'agent@example.com'],
            ['name' => 'Agen BERKAT', 'password' => bcrypt('password'), 'role' => 'agent', 'email_verified_at' => now()]
        );

        User::firstOrCreate(
            ['email' => 'agent@berkat.com'],
            ['name' => 'Agen BERKAT', 'password' => bcrypt('password'), 'role' => 'agent', 'email_verified_at' => now()]
        );

        User::firstOrCreate(
            ['email' => 'agent2@example.com'],
            ['name' => 'Agen BERKAT Kedua', 'password' => bcrypt('password'), 'role' => 'agent', 'email_verified_at' => now()]
        );

        User::firstOrCreate(
            ['email' => 'agent2@berkat.com'],
            ['name' => 'Agen BERKAT 2', 'password' => bcrypt('password'), 'role' => 'agent', 'email_verified_at' => now()]
        );

        // Cipta JK
        User::firstOrCreate(
            ['email' => 'jk@example.com'],
            ['name' => 'Jawatankuasa BERKAT', 'password' => bcrypt('password'), 'role' => 'jk', 'email_verified_at' => now()]
        );

        User::firstOrCreate(
            ['email' => 'jk@berkat.com'],
            ['name' => 'JK Committee', 'password' => bcrypt('password'), 'role' => 'jk', 'email_verified_at' => now()]
        );

        // Cipta Ahli
        User::firstOrCreate(
            ['email' => 'member@example.com'],
            ['name' => 'Ahli Sistem BERKAT', 'password' => bcrypt('password'), 'role' => 'member', 'email_verified_at' => now()]
        );

        User::firstOrCreate(
            ['email' => 'member@test.com'],
            ['name' => 'Member Test', 'password' => bcrypt('password'), 'role' => 'member', 'email_verified_at' => now()]
        );

        // Seed jenis permohonan, kategori dan sub-kategori
        $this->call([
            RequestTypeSeeder::class,
            AgentSeeder::class,
            DummyAssistanceRequestSeeder::class,
        ]);
    }
}
