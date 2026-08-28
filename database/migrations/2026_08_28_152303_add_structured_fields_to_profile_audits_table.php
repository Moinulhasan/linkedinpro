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
        Schema::table('profile_audits', function (Blueprint $table) {
            $table->unsignedTinyInteger('score')->nullable()->after('result');
            $table->string('verdict')->nullable()->after('score');
            $table->json('recommendations')->nullable()->after('verdict');
            $table->json('sections')->nullable()->after('recommendations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_audits', function (Blueprint $table) {
            $table->dropColumn(['score', 'verdict', 'recommendations', 'sections']);
        });
    }
};
