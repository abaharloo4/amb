<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('icon', 50)->default('layers');
            $table->boolean('featured')->default(false)->index();
            $table->string('status', 20)->default('published')->index();
            $table->integer('order')->default(0)->index();
            $table->boolean('is_demo')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('service_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('slug');
            $table->string('title');
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->json('deliverables')->nullable();
            $table->json('faq')->nullable();
            $table->text('search_text')->nullable();
            $table->timestamps();

            $table->unique(['service_id', 'locale']);
            $table->unique(['locale', 'slug']);
        });

        Schema::create('service_project', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->primary(['service_id', 'project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_project');
        Schema::dropIfExists('service_translations');
        Schema::dropIfExists('services');
    }
};
