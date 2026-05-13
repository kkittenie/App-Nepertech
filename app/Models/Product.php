<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category',
        'price',
        'stock',
        'description',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function getStatusBadgeAttribute(): string
    {
        return match (true) {
            $this->stock === 0 => 'danger',
            $this->stock <= 10 => 'warning',
            default => 'success',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match (true) {
            $this->stock === 0 => 'Out of Stock',
            $this->stock <= 10 => 'Low Stock',
            default => 'In Stock',
        };
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 10);
    }

    public function scopeLowStock($query)
    {
        return $query->where('stock', '>', 0)->where('stock', '<=', 10);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', 0);
    }
}