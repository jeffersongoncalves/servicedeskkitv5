<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('service_desk_departments')->cascadeOnDelete();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('service_desk_categories')->nullOnDelete();
            $table->unique(['department_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_categories');
    }
};
