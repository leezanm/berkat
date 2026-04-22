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
        Schema::table('request_subcategories', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->nullable()->after('description')->comment('Amaun bantuan untuk sub kategori ini');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_subcategories', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }
};
