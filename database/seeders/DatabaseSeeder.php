<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo user
        User::firstOrCreate(
            ['email' => 'demo@inapp.com'],
            [
                'name'     => 'Shrina Tesla',
                'email'    => 'demo@inapp.com',
                'password' => Hash::make('password'),
            ]
        );

        // Seed sample products
        $products = [
            ['name' => 'Wireless Headphones', 'sku' => 'WH-001', 'category' => 'Electronics', 'price' => 129.99, 'stock' => 45, 'description' => 'Premium wireless headphones with noise cancellation.', 'image' => null],
            ['name' => 'Mechanical Keyboard', 'sku' => 'MK-002', 'category' => 'Electronics', 'price' => 89.99, 'stock' => 32, 'description' => 'Compact mechanical keyboard with RGB lighting.', 'image' => null],
            ['name' => 'USB-C Hub', 'sku' => 'UC-003', 'category' => 'Electronics', 'price' => 49.99, 'stock' => 8, 'description' => '7-in-1 USB-C hub with HDMI output.', 'image' => null],
            ['name' => 'Laptop Stand', 'sku' => 'LS-004', 'category' => 'Accessories', 'price' => 39.99, 'stock' => 60, 'description' => 'Adjustable aluminum laptop stand.', 'image' => null],
            ['name' => 'Webcam HD 1080p', 'sku' => 'WC-005', 'category' => 'Electronics', 'price' => 79.99, 'stock' => 5, 'description' => 'Full HD webcam with built-in microphone.', 'image' => null],
            ['name' => 'Mouse Pad XL', 'sku' => 'MP-006', 'category' => 'Accessories', 'price' => 19.99, 'stock' => 120, 'description' => 'Extra large gaming mouse pad.', 'image' => null],
            ['name' => 'Desk Lamp LED', 'sku' => 'DL-007', 'category' => 'Office', 'price' => 34.99, 'stock' => 0, 'description' => 'LED desk lamp with adjustable brightness.', 'image' => null],
            ['name' => 'Monitor Arm', 'sku' => 'MA-008', 'category' => 'Office', 'price' => 65.99, 'stock' => 18, 'description' => 'Single monitor arm with cable management.', 'image' => null],
            ['name' => 'Cable Organizer', 'sku' => 'CO-009', 'category' => 'Accessories', 'price' => 12.99, 'stock' => 200, 'description' => 'Cable management kit for desk setup.', 'image' => null],
            ['name' => 'Ergonomic Chair', 'sku' => 'EC-010', 'category' => 'Office', 'price' => 349.99, 'stock' => 3, 'description' => 'Ergonomic office chair with lumbar support.', 'image' => null],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }
    }
}