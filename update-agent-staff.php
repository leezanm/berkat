<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Update agent 1
$agent1 = \App\Models\Agent::find(1);
if ($agent1) {
    $agent1->update([
        'staff_name' => 'Mohd Rauf bin Abdullah',
        'staff_ic' => '750315-12-5678',
        'staff_email' => 'mohd.rauf@akauntan.gov.my',
        'staff_mobile' => '019-2345678',
        'accounting_office' => 'Pejabat Akauntan Negara (Federal)',
        'position' => 'Pegawai Kanan',
        'grade' => 'DG48',
    ]);
    echo "✓ Agent 1 updated with staff information\n";
}

// Update agent 2
$agent2 = \App\Models\Agent::find(2);
if ($agent2) {
    $agent2->update([
        'staff_name' => 'Siti Nurhaliza binti Mohamed',
        'staff_ic' => '800722-10-9876',
        'staff_email' => 'siti.nurhaliza@akauntan.gov.my',
        'staff_mobile' => '016-7654321',
        'accounting_office' => 'Pejabat Akauntan Negara (Selangor)',
        'position' => 'Pegawai',
        'grade' => 'N22',
    ]);
    echo "✓ Agent 2 updated with staff information\n";
}

echo "\n✓ All agents updated successfully!\n";
