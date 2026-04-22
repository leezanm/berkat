<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user untuk merekod agen
        $admin = User::where('email', 'admin@example.com')->first();

        // Dapatkan atau cipta user agen pertama
        $agentUser = User::where('email', 'agent@example.com')->first();
        if (!$agentUser) {
            $agentUser = User::create([
                'name' => 'Agen BERKAT Utama',
                'email' => 'agent@example.com',
                'password' => bcrypt('password'),
                'role' => 'agent',
                'email_verified_at' => now(),
            ]);
        }

        // Cipta profil agen untuk user pertama jika belum ada
        if (!Agent::where('user_id', $agentUser->id)->exists()) {
            Agent::create([
                'user_id' => $agentUser->id,
                'staff_name' => 'Mohd Rauf bin Abdullah',
                'staff_ic' => '750315-12-5678',
                'staff_email' => 'mohd.rauf@akauntan.gov.my',
                'staff_mobile' => '019-2345678',
                'accounting_office' => 'Pejabat Akauntan Negara (Federal)',
                'position' => 'Pegawai Kanan',
                'grade' => 'DG48',
                'office_name' => 'Pejabat BERKAT Kuala Lumpur',
                'office_address' => 'Jalan Merdeka, Kuala Lumpur',
                'office_phone' => '+60-3-2144-1111',
                'office_email' => 'berkat.kl@example.com',
                'designation' => 'Agen Pengesahan Dokumen',
                'description' => 'Bertanggungjawab untuk pengesahan kelengkapan dokumen permohonan bantuan.',
                'status' => 'active',
                'remarks' => 'Agen utama sistem BERKAT',
                'registered_by' => $admin ? $admin->id : 1,
                'registered_at' => now(),
                'verified_at' => now(),
                'last_activity_at' => now(),
                'requests_verified_count' => 0,
            ]);
        }

        // Dapatkan atau cipta user agen kedua
        $agentUser2 = User::where('email', 'agent2@example.com')->first();
        if (!$agentUser2) {
            $agentUser2 = User::create([
                'name' => 'Agen BERKAT Kedua',
                'email' => 'agent2@example.com',
                'password' => bcrypt('password'),
                'role' => 'agent',
                'email_verified_at' => now(),
            ]);
        }

        // Cipta profil agen untuk user kedua jika belum ada
        if (!Agent::where('user_id', $agentUser2->id)->exists()) {
            Agent::create([
                'user_id' => $agentUser2->id,
                'staff_name' => 'Siti Nurhaliza binti Mohamed',
                'staff_ic' => '800722-10-9876',
                'staff_email' => 'siti.nurhaliza@akauntan.gov.my',
                'staff_mobile' => '016-7654321',
                'accounting_office' => 'Pejabat Akauntan Negara (Selangor)',
                'position' => 'Pegawai',
                'grade' => 'N22',
                'office_name' => 'Pejabat BERKAT Selangor',
                'office_address' => 'Jalan Industri, Shah Alam, Selangor',
                'office_phone' => '+60-3-5522-2222',
                'office_email' => 'berkat.selangor@example.com',
                'designation' => 'Agen Pengesahan Dokumen Kanan',
                'description' => 'Bertanggungjawab untuk pengesahan kelengkapan dokumen permohonan bantuan di wilayah Selangor.',
                'status' => 'active',
                'remarks' => 'Agen kanan sistem BERKAT',
                'registered_by' => $admin ? $admin->id : 1,
                'registered_at' => now(),
                'verified_at' => now(),
                'last_activity_at' => now(),
                'requests_verified_count' => 0,
            ]);
        }
    }
}
