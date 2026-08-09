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
        Schema::table('github_projects', function (Blueprint $table) {
            $table->unsignedInteger('stargazers_count')->default(0)->after('flag_fork');
            $table->unsignedInteger('forks_count')->default(0)->after('stargazers_count');
            $table->json('topics')->nullable()->after('forks_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('github_projects', function (Blueprint $table) {
            $table->dropColumn(['stargazers_count', 'forks_count', 'topics']);
        });
    }
};
