<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_ticket_watchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('service_desk_tickets')->cascadeOnDelete();
            $table->string('watcher_type');
            $table->unsignedBigInteger('watcher_id');
            $table->timestamp('created_at')->nullable();

            $table->unique(['ticket_id', 'watcher_type', 'watcher_id'], 'sd_ticket_watcher_unique');
            $table->index(['watcher_type', 'watcher_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_ticket_watchers');
    }
};
