<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistance_request_id')->constrained('assistance_requests')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // pemohon
            $table->foreignId('paid_by')->constrained('users'); // admin yang rekod
            $table->decimal('amount', 12, 2);
            $table->enum('payment_method', ['pindahan_bank', 'cek', 'tunai', 'lain'])->default('pindahan_bank');
            $table->string('payment_reference')->nullable(); // no rujukan / no cek
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
