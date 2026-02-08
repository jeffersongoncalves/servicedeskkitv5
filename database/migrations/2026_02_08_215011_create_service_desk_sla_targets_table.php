<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_sla_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sla_policy_id')->constrained('service_desk_sla_policies')->cascadeOnDelete();
            $table->string('priority', 16);
            $table->unsignedInteger('first_response_time')->nullable();
            $table->unsignedInteger('next_response_time')->nullable();
            $table->unsignedInteger('resolution_time')->nullable();
            $table->timestamps();

            $table->unique(['sla_policy_id', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_sla_targets');
    }
};
