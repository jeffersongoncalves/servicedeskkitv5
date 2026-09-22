<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_desk_tickets', function (Blueprint $table) {
            $table->string('user_name')->nullable()->after('user_id');
            $table->string('user_email')->nullable()->after('user_name');
            $table->string('assigned_to_name')->nullable()->after('assigned_to_id');
            $table->string('assigned_to_email')->nullable()->after('assigned_to_name');
        });

        Schema::table('service_desk_ticket_comments', function (Blueprint $table) {
            $table->string('author_name')->nullable()->after('author_id');
            $table->string('author_email')->nullable()->after('author_name');
        });

        Schema::table('service_desk_ticket_attachments', function (Blueprint $table) {
            $table->string('uploaded_by_name')->nullable()->after('uploaded_by_id');
            $table->string('uploaded_by_email')->nullable()->after('uploaded_by_name');
        });

        Schema::table('service_desk_ticket_history', function (Blueprint $table) {
            $table->string('performer_name')->nullable()->after('performer_id');
            $table->string('performer_email')->nullable()->after('performer_name');
        });

        Schema::table('service_desk_ticket_watchers', function (Blueprint $table) {
            $table->string('watcher_name')->nullable()->after('watcher_id');
            $table->string('watcher_email')->nullable()->after('watcher_name');
        });
    }

    public function down(): void
    {
        Schema::table('service_desk_tickets', function (Blueprint $table) {
            $table->dropColumn(['user_name', 'user_email', 'assigned_to_name', 'assigned_to_email']);
        });

        Schema::table('service_desk_ticket_comments', function (Blueprint $table) {
            $table->dropColumn(['author_name', 'author_email']);
        });

        Schema::table('service_desk_ticket_attachments', function (Blueprint $table) {
            $table->dropColumn(['uploaded_by_name', 'uploaded_by_email']);
        });

        Schema::table('service_desk_ticket_history', function (Blueprint $table) {
            $table->dropColumn(['performer_name', 'performer_email']);
        });

        Schema::table('service_desk_ticket_watchers', function (Blueprint $table) {
            $table->dropColumn(['watcher_name', 'watcher_email']);
        });
    }
};
