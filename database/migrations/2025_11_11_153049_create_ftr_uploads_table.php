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
        Schema::create('ftr_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('original_name', 255);
            $table->string('path', 255); // storage/app/ftr/...
            $table->unsignedInteger('rows_parsed')->default(0);
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ftr_uploads');
    }
};
