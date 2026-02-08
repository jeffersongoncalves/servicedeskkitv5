<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_kb_article_ticket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('service_desk_kb_articles')->cascadeOnDelete();
            $table->foreignId('ticket_id')->constrained('service_desk_tickets')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['article_id', 'ticket_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_kb_article_ticket');
    }
};
