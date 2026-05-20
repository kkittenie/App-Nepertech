<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // New pricing columns
            $table->decimal('harga_jual', 15, 2)->nullable()->after('category_id');
            $table->decimal('harga_sewa_bulanan', 15, 2)->nullable()->after('harga_jual');
            $table->decimal('harga_sewa_tahunan', 15, 2)->nullable()->after('harga_sewa_bulanan');

            // Display image (cover photo)
            $table->string('display_image')->nullable()->after('description');

            // SEO-friendly slug
            $table->string('slug')->nullable()->unique()->after('name');
        });

        // Migrate existing price data to harga_jual
        DB::statement('UPDATE products SET harga_jual = price WHERE price IS NOT NULL');

        // Generate slugs for existing products
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $slug = \Illuminate\Support\Str::slug($product->name);
            // Ensure uniqueness
            $existing = DB::table('products')->where('slug', $slug)->where('id', '!=', $product->id)->exists();
            if ($existing) {
                $slug = $slug . '-' . $product->id;
            }
            DB::table('products')->where('id', $product->id)->update(['slug' => $slug]);
        }

        // Migrate existing image to display_image
        DB::statement('UPDATE products SET display_image = image WHERE image IS NOT NULL');

        // Drop old columns
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price', 'image']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->nullable()->after('category_id');
            $table->string('image')->nullable()->after('description');
        });

        DB::statement('UPDATE products SET price = harga_jual WHERE harga_jual IS NOT NULL');
        DB::statement('UPDATE products SET image = display_image WHERE display_image IS NOT NULL');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['harga_jual', 'harga_sewa_bulanan', 'harga_sewa_tahunan', 'display_image', 'slug']);
        });
    }
};
