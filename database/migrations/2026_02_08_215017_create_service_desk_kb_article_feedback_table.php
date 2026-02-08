<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_kb_article_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('service_desk_kb_articles')->cascadeOnDelete();
            $table->nullableMorphs('user');
            $table->boolean('is_helpful');
            $table->text('comment')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_kb_article_feedback');
    }
};
