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
        Schema::create('github_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('github_id')->nullable();
            $table->string('name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('language')->nullable();
            $table->string('html_url')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('repo_pushed_at')->nullable();
            $table->dateTime('repo_created_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('github_projects');
    }
};
