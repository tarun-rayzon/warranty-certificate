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
        Schema::create('warranty_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warranty_request_id')->constrained('warranty_requests')->cascadeOnDelete();
            $table->string('serial');
            // verification_state: pending | verified | not_found | already_consumed | invalid
            $table->enum('verification_state', ['pending', 'verified', 'not_found', 'already_consumed', 'invalid'])->default('pending');
            $table->foreignId('serial_number_id')->nullable()->constrained('serial_numbers')->nullOnDelete();
            $table->timestamps();

            $table->unique(['warranty_request_id','serial']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_request_items');
    }
};
