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
        Schema::create('request_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_type_id')->constrained('request_types')->onDelete('cascade');
            $table->string('name'); // e.g., Kemasukan Persekolahan, Masuk Wad, etc.
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_categories');
    }
};
