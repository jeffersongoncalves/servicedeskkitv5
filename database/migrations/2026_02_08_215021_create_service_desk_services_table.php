<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('service_desk_service_categories')->restrictOnDelete();
            $table->foreignId('sla_policy_id')->nullable()->constrained('service_desk_sla_policies')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('service_desk_departments')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('requires_approval')->default(false);
            $table->string('default_priority', 16)->default('medium');
            $table->unsignedInteger('expected_duration_minutes')->nullable();
            $table->string('visibility', 16)->default('public');
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_services');
    }
};
