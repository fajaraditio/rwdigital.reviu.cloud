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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('rt_area_id')->nullable();
            $table->string('document_no')->nullable();
            $table->string('service')->nullable();
            $table->string('warga_name')->nullable();
            $table->string('rt_name')->nullable();
            $table->string('rw_name')->nullable();
            $table->string('data')->nullable();
            $table->string('file')->nullable();
            $table->string('rt_signed_at')->nullable();
            $table->string('rw_signed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
