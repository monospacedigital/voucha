<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $primaryKey = 'reward_id';

    protected $fillable = [
        'reward_name',
        'reward_description',
        'points_required',
        'reward_type',
        'reward_value',
        'is_active',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'reward_value' => 'decimal:2'
    ];
}
