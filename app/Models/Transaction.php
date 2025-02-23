<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'user_id',
        'brand_transaction_id',
        'transaction_type',
        'transaction_amount',
        'transaction_date',
        'status'
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'transaction_amount' => 'decimal:2'
    ];

    /**
     * Get the user who made the transaction
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the points associated with this transaction
     */
    public function points(): HasMany
    {
        return $this->hasMany(Point::class, 'transaction_id');
    }
}
