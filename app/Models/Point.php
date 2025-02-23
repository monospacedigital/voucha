<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point extends Model
{
    protected $primaryKey = 'point_id';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'point_type',
        'point_value',
        'point_reason',
        'point_date',
        'expiry_date',
        'campaign_id'
    ];

    protected $casts = [
        'point_date' => 'datetime',
        'expiry_date' => 'date'
    ];

    /**
     * Get the user who owns the points
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transaction associated with these points
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    /**
     * Get the campaign associated with these points
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
