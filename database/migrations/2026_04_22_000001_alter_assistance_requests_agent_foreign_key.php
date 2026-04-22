<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Mengubah agent_id di jadual assistance_requests untuk merujuk ke jadual agents
     * bukannya jadual users.
     */
    public function up(): void
    {
        Schema::table('assistance_requests', function (Blueprint $table) {
            // Buang constraint foreign key yang sedia ada
            try {
                $table->dropForeignKey('assistance_requests_agent_id_foreign');
            } catch (\Exception $e) {
                // Constraint mungkin tidak wujud
            }
            
            // Ubah agent_id menjadi foreign key ke agents table
            $table->foreign('agent_id')
                ->references('id')
                ->on('agents')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assistance_requests', function (Blueprint $table) {
            // Kembalikan foreign key ke users
            try {
                $table->dropForeignKey('assistance_requests_agent_id_foreign');
            } catch (\Exception $e) {
                // Constraint mungkin tidak wujud
            }
        });
    }
};
