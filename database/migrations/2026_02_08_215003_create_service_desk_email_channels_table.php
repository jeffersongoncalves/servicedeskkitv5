<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_email_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained('service_desk_departments')->nullOnDelete();
            $table->string('name');
            $table->string('driver', 32);
            $table->string('email_address')->unique();
            $table->json('settings');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamp('last_polled_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_email_channels');
    }
};
