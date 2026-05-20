<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('name');
            $table->string('subjudul_atas')->nullable()->after('subtitle');
            $table->string('subjudul_bawah')->nullable()->after('description');
            $table->text('deskripsi_bawah')->nullable()->after('subjudul_bawah');
            $table->string('hero_image')->nullable()->after('display_image');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'subjudul_atas', 'subjudul_bawah', 'deskripsi_bawah', 'hero_image']);
        });
    }
};
