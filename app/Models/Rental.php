<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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

    // ── Relationships ──────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ── Computed Attributes ────────────────────────────────────────────────

    /**
     * Human-readable duration, e.g. "3 Bulan" or "1 Tahun".
     */
    public function getDurationLabelAttribute(): string
    {
        $unit = $this->duration_type === 'tahunan' ? 'Tahun' : 'Bulan';
        return $this->duration_value . ' ' . $unit;
    }

    /**
     * Calculated end date: start_date + duration.
     */
    public function getEndDateAttribute(): Carbon
    {
        $date = Carbon::parse($this->start_date);
        return $this->duration_type === 'tahunan'
            ? $date->addYears($this->duration_value)
            : $date->addMonths($this->duration_value);
    }

    /**
     * Days remaining until expiry.
     * Positive  → still active
     * Zero      → expires today
     * Negative  → already expired
     */
    public function getDaysRemainingAttribute(): int
    {
        return (int) now()->startOfDay()->diffInDays($this->end_date->copy()->startOfDay(), false);
    }

    // ── Static Helpers (for controller use) ────────────────────────────────

    /**
     * Return approved rentals expiring within $days days (inclusive of today).
     */
    public static function expiringSoon(int $days = 7)
    {
        return static::where('status', 'approved')
            ->with(['product', 'user'])
            ->get()
            ->filter(fn($r) => $r->days_remaining >= 0 && $r->days_remaining <= $days)
            ->sortBy('days_remaining')
            ->values();
    }

    /**
     * Return approved rentals that have already passed their end date.
     */
    public static function alreadyExpired()
    {
        return static::where('status', 'approved')
            ->with(['product', 'user'])
            ->get()
            ->filter(fn($r) => $r->days_remaining < 0)
            ->sortBy('days_remaining') // most recently expired first
            ->values();
    }
}
