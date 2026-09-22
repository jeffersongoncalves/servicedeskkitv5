<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_automation_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('trigger_event', 32);
            $table->json('conditions')->nullable();
            $table->string('action', 32);
            $table->json('action_config')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['trigger_event', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_automation_rules');
    }
};
