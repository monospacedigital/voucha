<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoyaltyTier extends Model
{
    protected $primaryKey = 'loyalty_tier_id';

    protected $fillable = [
        'tier_name',
        'points_required',
        'benefits_description'
    ];

    /**
     * Get the users belonging to this tier
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'loyalty_tier_id');
    }
}
