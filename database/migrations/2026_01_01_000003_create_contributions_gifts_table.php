<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contributor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('contributor_name', 100)->nullable();
            $table->string('contributor_phone', 20)->nullable();
            $table->enum('type', ['cash', 'gift'])->default('cash');
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('payment_method', ['mpesa','airtel_money','tigopesa','cash','bank_transfer','other'])->default('cash');
            $table->string('payment_reference', 100)->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('donor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('donor_name', 100)->nullable();
            $table->string('donor_phone', 20)->nullable();
            $table->string('item_name', 200);
            $table->enum('category', ['kitchen_dining','bedroom_linen','electronics','furniture','clothing','other'])->default('other');
            $table->decimal('estimated_value', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->enum('status', ['pledged', 'received', 'cancelled'])->default('pledged');
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
        });

        Schema::create('confirmations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contribution_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('gift_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('sent_to_phone', 20)->nullable();
            $table->string('sent_to_email')->nullable();
            $table->enum('sent_via', ['sms', 'email', 'whatsapp'])->default('sms');
            $table->text('message_body')->nullable();
            $table->enum('status', ['sent', 'failed', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('confirmations');
        Schema::dropIfExists('gifts');
        Schema::dropIfExists('contributions');
    }
};
