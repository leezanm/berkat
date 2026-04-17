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
        Schema::create('assistance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('request_type_id')->constrained('request_types');
            $table->foreignId('request_category_id')->constrained('request_categories');
            $table->foreignId('request_subcategory_id')->constrained('request_subcategories');
            $table->text('purpose'); // Tujuan Permohonan
            $table->string('applicant_name');
            $table->string('applicant_ic');
            $table->decimal('applicant_salary', 12, 2)->nullable();
            $table->string('applicant_position')->nullable();
            $table->text('applicant_office_address')->nullable();
            $table->string('applicant_accounting_office')->nullable();
            $table->string('applicant_phone');
            $table->string('applicant_email');
            $table->string('applicant_bank_account')->nullable();
            $table->decimal('household_income', 12, 2)->nullable();
            $table->integer('dependents_count')->default(0);
            $table->integer('disabled_dependents_count')->default(0);

            // Spouse information
            $table->string('spouse_name')->nullable();
            $table->string('spouse_ic')->nullable();
            $table->decimal('spouse_salary', 12, 2)->nullable();
            $table->string('spouse_position')->nullable();

            // Status
            $table->enum('status', ['draft', 'submitted', 'in_process', 'approved', 'rejected'])->default('draft');
            $table->enum('agent_verification', ['pending', 'verified', 'rejected'])->default('pending');

            // Approval details
            $table->decimal('approved_amount', 12, 2)->nullable();
            $table->text('rejection_reason')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->text('jk_recommendation')->nullable();

            // Submission tracking
            $table->dateTime('submitted_at')->nullable();
            $table->foreignId('agent_id')->nullable()->constrained('users');
            $table->boolean('agent_filled')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistance_requests');
    }
};
