<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_escalation_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sla_policy_id')->constrained('service_desk_sla_policies')->cascadeOnDelete();
            $table->string('breach_type', 32);
            $table->string('trigger_type', 16);
            $table->unsignedInteger('minutes_before')->default(0);
            $table->string('action', 32);
            $table->json('action_config')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_escalation_rules');
    }
};
