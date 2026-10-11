<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('category', 50)->default('backend');
            $table->integer('proficiency')->default(90);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('skill_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')->constrained('skills')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('name');
            $table->timestamps();

            $table->unique(['skill_id', 'locale']);
        });

        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('experience_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experience_id')->constrained('experiences')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('company');
            $table->string('role');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['experience_id', 'locale']);
        });

        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->string('start_year', 10);
            $table->string('end_year', 10)->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('education_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('education_id')->constrained('educations')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('institution');
            $table->string('degree');
            $table->string('field')->nullable();
            $table->timestamps();

            $table->unique(['education_id', 'locale']);
        });

        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->date('issue_date')->nullable();
            $table->string('url')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('certification_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certification_id')->constrained('certifications')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title');
            $table->string('issuer');
            $table->timestamps();

            $table->unique(['certification_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certification_translations');
        Schema::dropIfExists('certifications');
        Schema::dropIfExists('education_translations');
        Schema::dropIfExists('educations');
        Schema::dropIfExists('experience_translations');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('skill_translations');
        Schema::dropIfExists('skills');
    }
};
