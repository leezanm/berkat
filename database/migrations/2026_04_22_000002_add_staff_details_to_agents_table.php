<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan field informasi staff ke jadual agents.
     * Agen adalah kakitangan dari Jabatan Akauntan Negara yang dilantik sebagai agen.
     */
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            // Maklumat peribadi staff
            $table->string('staff_name')->nullable()->after('user_id'); // Nama staff
            $table->string('staff_ic')->nullable()->after('staff_name'); // No. Kad Pengenalan
            $table->string('staff_email')->nullable()->after('staff_ic'); // Email staff/peribadi
            $table->string('staff_mobile')->nullable()->after('staff_email'); // No. HP staff

            // Maklumat pejabat dan jawatan
            $table->string('accounting_office')->nullable()->after('staff_mobile'); // Pejabat Perakaunan
            $table->string('position')->nullable()->after('accounting_office'); // Jawatan (cth: Pegawai, Pegawai Kanan)
            $table->string('grade')->nullable()->after('position'); // Gred (cth: N22, DG48)

            // Indexes
            $table->index('staff_ic');
            $table->index('accounting_office');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropIndex(['staff_ic']);
            $table->dropIndex(['accounting_office']);
            $table->dropColumn([
                'staff_name',
                'staff_ic',
                'staff_email',
                'staff_mobile',
                'accounting_office',
                'position',
                'grade'
            ]);
        });
    }
};
