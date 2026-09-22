<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_desk_service_request_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id');
            $table->foreign('service_request_id', 'sd_request_approvals_service_request_fk')
                ->references('id')->on('service_desk_service_requests')->cascadeOnDelete();
            // Nullable: ApprovalService::createApprovalSteps() creates a pending
            // step with approver_id = null — no specific approver is assigned
            // until a decision is made (see ApprovalService::processDecision()).
            $table->nullableMorphs('approver', 'sd_request_approvals_approver_index');
            $table->string('status', 16)->default('pending');
            $table->text('comment')->nullable();
            $table->unsignedInteger('step_order')->default(1);
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_desk_service_request_approvals');
    }
};
