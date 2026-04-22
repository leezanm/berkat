<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "✓ AGENT STAFF INFORMATION VERIFICATION\n";
echo "═════════════════════════════════════════════════════════════\n\n";

$agents = \App\Models\Agent::with('user', 'registeredBy')->get();

foreach ($agents as $agent) {
    echo "Agent ID: " . $agent->id . "\n";
    echo "─────────────────────────────────────────────────────────\n";
    echo "User Account: " . $agent->user->name . " (" . $agent->user->email . ")\n";
    echo "\nSTAFF INFORMATION:\n";
    echo "  Nama: " . ($agent->staff_name ?? 'N/A') . "\n";
    echo "  No. KP: " . ($agent->staff_ic ?? 'N/A') . "\n";
    echo "  Email: " . ($agent->staff_email ?? 'N/A') . "\n";
    echo "  No. HP: " . ($agent->staff_mobile ?? 'N/A') . "\n";
    echo "  Pejabat Perakaunan: " . ($agent->accounting_office ?? 'N/A') . "\n";
    echo "  Jawatan: " . ($agent->position ?? 'N/A') . "\n";
    echo "  Gred: " . ($agent->grade ?? 'N/A') . "\n";
    echo "\nOFFICE INFORMATION:\n";
    echo "  Pejabat: " . $agent->office_name . "\n";
    echo "  Alamat: " . ($agent->office_address ?? 'N/A') . "\n";
    echo "  No. Telefon Pejabat: " . ($agent->office_phone ?? 'N/A') . "\n";
    echo "  Email Pejabat: " . ($agent->office_email ?? 'N/A') . "\n";
    echo "  Jawatan di BERKAT: " . $agent->designation . "\n";
    echo "  Status: " . $agent->status . "\n";
    echo "\nREGISTRATION INFO:\n";
    echo "  Didaftarkan oleh: " . $agent->registeredBy->name . "\n";
    echo "  Didaftarkan pada: " . $agent->registered_at->format('d/m/Y H:i') . "\n";
    echo "  Disahkan pada: " . ($agent->verified_at ? $agent->verified_at->format('d/m/Y H:i') : 'N/A') . "\n";
    echo "\n\n";
}

echo "✓ ALL STAFF INFORMATION LOADED SUCCESSFULLY!\n";
