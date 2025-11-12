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
        Schema::create('warranty_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warranty_request_id')->constrained('warranty_requests')->cascadeOnDelete();
            $table->string('certificate_no')->unique(); // e.g., RZ-2025-000123
            $table->string('pdf_path', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_certificates');
    }
};
