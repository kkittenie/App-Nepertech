<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Rental extends Model
{
    protected $table = 'rentals';

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'email',
        'whatsapp_number',
        'duration_type',
        'duration_value',
        'total_price',
        'start_date',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user who requested the rental (if registered).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product being rented.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get a human-readable duration label.
     */
    public function getDurationLabelAttribute(): string
    {
        $unit = $this->duration_type === 'tahunan' ? 'Tahun' : 'Bulan';
        return $this->duration_value . ' ' . $unit;
    }
}
