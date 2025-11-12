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
        Schema::create('warranty_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('invoice_no', 50)->nullable();
            $table->string('invoice_file_path', 255)->nullable();
            $table->date('purchase_date')->nullable();
            // status: pending_verification | pending_qc | approved | rejected
            $table->enum('status', ['pending_verification', 'pending_qc', 'approved', 'rejected'])->default('pending_verification');
            $table->foreignId('qc_approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('qc_approved_at')->nullable();
            $table->text('qc_reject_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_requests');
    }
};
