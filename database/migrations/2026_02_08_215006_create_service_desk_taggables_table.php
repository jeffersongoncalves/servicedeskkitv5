<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_taggables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained('service_desk_tags')->cascadeOnDelete();
            $table->morphs('taggable');
            $table->timestamps();

            $table->unique(['tag_id', 'taggable_type', 'taggable_id'], 'sd_taggable_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_taggables');
    }
};
