<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'email',
        'whatsapp_number',
        'total_price',
        'payment_token',
        'payment_receipt',
        'status',
        'admin_notes',
        'client_notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user who requested the purchase (if registered).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product being purchased.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
