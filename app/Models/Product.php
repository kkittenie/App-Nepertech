<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'subtitle',
        'subjudul_atas',
        'slug',
        'category_id',
        'harga_jual',
        'harga_sewa_bulanan',
        'harga_sewa_tahunan',
        'link',
        'description',
        'subjudul_bawah',
        'deskripsi_bawah',
        'display_image',
        'hero_image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Check if the product is currently available for rent or purchase.
     */
    public function isAvailable(): bool
    {
        // 1. Check if there is an active rental (status: completed, and days_remaining >= 0)
        $activeRentals = Rental::where('product_id', $this->id)
            ->where('status', 'completed')
            ->get();
            
        foreach ($activeRentals as $rental) {
            if ($rental->days_remaining >= 0) {
                return false; // Currently being rented
            }
        }
        
        // 2. Check if it has been permanently sold (status: completed)
        $isSold = Sale::where('product_id', $this->id)
            ->where('status', 'completed')
            ->exists();
            
        if ($isSold) {
            return false; // Already sold permanently
        }
        
        return true;
    }
}