<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assistance_request_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistance_request_id')->constrained('assistance_requests')->onDelete('cascade');
            $table->string('document_key');
            $table->string('document_label');
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();

            $table->unique(['assistance_request_id', 'document_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assistance_request_documents');
    }
};
