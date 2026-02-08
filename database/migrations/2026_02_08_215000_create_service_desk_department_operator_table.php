<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_department_operator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('service_desk_departments')->cascadeOnDelete();
            $table->string('operator_type');
            $table->unsignedBigInteger('operator_id');
            $table->string('role', 32)->default('operator');
            $table->timestamps();

            $table->unique(['department_id', 'operator_type', 'operator_id'], 'sd_dept_operator_unique');
            $table->index(['operator_type', 'operator_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_department_operator');
    }
};
