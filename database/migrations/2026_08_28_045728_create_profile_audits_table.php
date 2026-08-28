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
        Schema::create('profile_audits', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('original_filename');
            $table->string('pdf_path');
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->longText('result')->nullable();
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_audits');
    }
};
