<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_ticket_sla', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->unique()->constrained('service_desk_tickets')->cascadeOnDelete();
            $table->foreignId('sla_policy_id')->constrained('service_desk_sla_policies')->restrictOnDelete();
            $table->string('priority_at_assignment', 16);
            $table->timestamp('first_response_due_at')->nullable();
            $table->timestamp('next_response_due_at')->nullable();
            $table->timestamp('resolution_due_at')->nullable();
            $table->timestamp('first_responded_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->boolean('first_response_breached')->default(false);
            $table->boolean('next_response_breached')->default(false);
            $table->boolean('resolution_breached')->default(false);
            $table->unsignedInteger('paused_minutes')->default(0);
            $table->timestamp('paused_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_ticket_sla');
    }
};
