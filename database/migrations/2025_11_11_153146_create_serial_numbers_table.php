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
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->unique();
            $table->string('pallet_id', 50)->nullable();
            $table->foreignId('ftr_upload_id')->nullable()->constrained('ftr_uploads')->nullOnDelete();

            // status: available | consumed | blocked
            $table->enum('status', ['available', 'consumed', 'blocked'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_numbers');
    }
};
