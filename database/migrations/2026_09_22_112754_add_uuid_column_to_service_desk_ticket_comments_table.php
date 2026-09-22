<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_desk_ticket_comments', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        DB::table('service_desk_ticket_comments')->whereNull('uuid')->eachById(function ($comment) {
            DB::table('service_desk_ticket_comments')->where('id', $comment->id)->update(['uuid' => (string) Str::uuid()]);
        });
    }

    public function down(): void
    {
        Schema::table('service_desk_ticket_comments', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
