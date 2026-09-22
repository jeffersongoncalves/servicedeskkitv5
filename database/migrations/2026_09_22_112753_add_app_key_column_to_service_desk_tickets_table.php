<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_desk_tickets', function (Blueprint $table) {
            // Null for tickets created locally by this app; set to the
            // caller's app key for tickets created through the API
            // transport, so the central instance can scope every read/write
            // to the satellite that owns the ticket.
            $table->string('app_key')->nullable()->after('id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('service_desk_tickets', function (Blueprint $table) {
            $table->dropColumn('app_key');
        });
    }
};
