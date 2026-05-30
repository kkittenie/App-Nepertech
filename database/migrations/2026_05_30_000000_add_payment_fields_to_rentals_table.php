<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            // Token used in payment page URL (like sales)
            $table->string('payment_token')->nullable()->after('admin_notes');
            // Path to uploaded payment receipt image
            $table->string('payment_receipt')->nullable()->after('payment_token');
            // Expand status options to match sale flow:
            // 'pending' → 'awaiting_payment' → 'payment_submitted' → 'completed' | 'rejected'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['payment_token', 'payment_receipt']);
        });
    }
};
