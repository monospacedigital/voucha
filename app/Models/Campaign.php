<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $primaryKey = 'campaign_id';

    protected $fillable = [
        'campaign_name',
        'campaign_description',
        'start_date',
        'end_date',
        'point_multiplier',
        'target_transaction_types',
        'target_user_segments'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'point_multiplier' => 'decimal:2'
    ];

    /**
     * Get the points associated with this campaign
     */
    public function points(): HasMany
    {
        return $this->hasMany(Point::class, 'campaign_id');
    }
}
