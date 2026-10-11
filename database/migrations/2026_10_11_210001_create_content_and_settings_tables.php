<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('status', 20)->default('published')->index();
            $table->boolean('is_demo')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->longText('content')->nullable();
            $table->text('search_text')->nullable();
            $table->timestamps();

            $table->unique(['page_id', 'locale']);
        });

        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->string('key')->index();
            $table->integer('order')->default(0)->index();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('page_section_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_section_id')->constrained('page_sections')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->unique(['page_section_id', 'locale']);
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('group', 30)->default('general')->index();
            $table->string('type', 20)->default('text');
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->constrained('settings')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['setting_id', 'locale']);
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 50);
            $table->string('url');
            $table->string('icon', 50)->default('link');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('social_link_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('social_link_id')->constrained('social_links')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('label');
            $table->timestamps();

            $table->unique(['social_link_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_link_translations');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('setting_translations');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('page_section_translations');
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('pages');
    }
};
