<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assistance_request_children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistance_request_id')
                ->constrained('assistance_requests')
                ->cascadeOnDelete();
            $table->string('child_name')->comment('Nama Anak');
            $table->string('child_ic', 12)->nullable()->comment('No. Kad Pengenalan');
            $table->integer('age')->nullable()->comment('Umur');
            $table->string('school_name')->nullable()->comment('Nama Sekolah/IPT');
            $table->timestamps();

            // Index for faster queries
            $table->index('assistance_request_id');
            $table->index('child_ic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistance_request_children');
    }
};
