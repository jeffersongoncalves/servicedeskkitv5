<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('ticket_id')->constrained('service_desk_tickets')->cascadeOnDelete();
            $table->foreignId('comment_id')->nullable()->constrained('service_desk_ticket_comments')->nullOnDelete();
            $table->string('uploaded_by_type');
            $table->unsignedBigInteger('uploaded_by_id');
            $table->string('file_name');
            $table->string('file_path', 512);
            $table->string('disk', 32)->default('local');
            $table->string('mime_type', 128);
            $table->unsignedBigInteger('file_size');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['uploaded_by_type', 'uploaded_by_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_ticket_attachments');
    }
};
