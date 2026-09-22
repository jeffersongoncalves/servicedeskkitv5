<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_ticket_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('service_desk_tickets')->cascadeOnDelete();
            $table->nullableMorphs('user');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamp('created_at');

            $table->index('ticket_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_ticket_feedback');
    }
};
