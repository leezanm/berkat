<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Membuat jadual untuk agen yang mendaftarkan dan mengesahkan permohonan.
     * Agen adalah pengguna dengan role 'agent' yang berfungsi memeriksa dan
     * mengesahkan kelengkapan dokumen permohonan daripada ahli.
     */
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();

            // Hubungan ke jadual users
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            // Maklumat pejabat agen
            $table->string('office_name'); // Nama pejabat (cth: Pejabat BERKAT Kuala Lumpur)
            $table->string('office_address')->nullable(); // Alamat pejabat
            $table->string('office_phone')->nullable(); // Telefon pejabat
            $table->string('office_email')->nullable(); // Email pejabat (boleh berbeza dari user email)

            // Maklumat jawatan
            $table->string('designation'); // Jawatan agen (cth: Agen Verifikasi, Agen Kanan)
            $table->text('description')->nullable(); // Penerangan tugas atau kekhususan

            // Status agen
            $table->enum('status', ['active', 'inactive', 'on_leave', 'suspended'])->default('active');
            $table->text('remarks')->nullable(); // Catatan tambahan

            // Pendaftaran oleh Pentadbir
            $table->foreignId('registered_by')->constrained('users')->onDelete('restrict');
            $table->dateTime('registered_at');
            $table->dateTime('verified_at')->nullable(); // Tarikh agen disahkan/aktif

            // Tracking
            $table->dateTime('last_activity_at')->nullable(); // Aktiviti terakhir
            $table->integer('requests_verified_count')->default(0); // Bilangan permohonan disahkan

            $table->timestamps();

            // Indexes untuk prestasi
            $table->index('status');
            $table->index('registered_at');
            $table->index('office_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
