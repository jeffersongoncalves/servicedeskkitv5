<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_inbound_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_channel_id')->nullable()->constrained('service_desk_email_channels')->nullOnDelete();
            $table->string('message_id')->unique();
            $table->string('in_reply_to')->nullable()->index();
            $table->text('references')->nullable();
            $table->string('from_address')->index();
            $table->string('from_name')->nullable();
            $table->json('to_addresses');
            $table->json('cc_addresses')->nullable();
            $table->string('subject')->nullable();
            $table->longText('text_body')->nullable();
            $table->longText('html_body')->nullable();
            $table->longText('raw_payload')->nullable();
            $table->foreignId('ticket_id')->nullable()->constrained('service_desk_tickets')->nullOnDelete();
            $table->foreignId('comment_id')->nullable()->constrained('service_desk_ticket_comments')->nullOnDelete();
            $table->string('status', 32)->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_inbound_emails');
    }
};
