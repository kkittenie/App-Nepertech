<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('whatsapp_number');
            $table->decimal('total_price', 15, 2);
            $table->string('payment_token')->nullable()->unique();
            $table->string('payment_receipt')->nullable();
            $table->string('status')->default('pending'); // pending, awaiting_payment, payment_submitted, completed, rejected
            $table->text('admin_notes')->nullable();
            $table->text('client_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
