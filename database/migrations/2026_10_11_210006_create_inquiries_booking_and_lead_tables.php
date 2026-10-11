<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->string('avatar_url')->nullable();
            $table->string('status', 20)->default('published')->index();
            $table->integer('order')->default(0);
            $table->boolean('is_demo')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('testimonial_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testimonial_id')->constrained('testimonials')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('author_name');
            $table->string('author_role');
            $table->string('author_company')->nullable();
            $table->text('content');
            $table->timestamps();

            $table->unique(['testimonial_id', 'locale']);
        });

        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->char('public_id', 26)->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('budget_range')->nullable();
            $table->string('status', 20)->default('new')->index();
            $table->string('ip_address', 45)->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('inquiry_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id')->constrained('inquiries')->cascadeOnDelete();
            $table->string('event_type', 50);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('estimator_rules', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->decimal('multiplier', 8, 2)->default(1.0);
            $table->bigInteger('base_amount')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('estimator_rule_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estimator_rule_id')->constrained('estimator_rules')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['estimator_rule_id', 'locale']);
        });

        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->char('public_id', 26)->unique();
            $table->string('scope_type');
            $table->bigInteger('estimated_amount');
            $table->string('currency', 10)->default('IRR');
            $table->json('breakdown')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('meeting_types', function (Blueprint $table) {
            $table->id();
            $table->integer('duration_minutes')->default(30);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('meeting_type_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_type_id')->constrained('meeting_types')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['meeting_type_id', 'locale']);
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->char('public_id', 26)->unique();
            $table->foreignId('meeting_type_id')->nullable()->constrained('meeting_types')->nullOnDelete();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone')->nullable();
            $table->dateTime('start_time')->index();
            $table->dateTime('end_time')->index();
            $table->string('status', 20)->default('pending')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('meeting_type_translations');
        Schema::dropIfExists('meeting_types');
        Schema::dropIfExists('estimates');
        Schema::dropIfExists('estimator_rule_translations');
        Schema::dropIfExists('estimator_rules');
        Schema::dropIfExists('inquiry_events');
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('testimonial_translations');
        Schema::dropIfExists('testimonials');
    }
};
