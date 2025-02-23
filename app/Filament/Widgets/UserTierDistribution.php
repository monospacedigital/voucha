<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UserTierDistribution extends ChartWidget
{
    protected static ?string $heading = 'User Tier Distribution';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $distribution = User::select('loyalty_tiers.tier_name', DB::raw('count(*) as count'))
            ->join('loyalty_tiers', 'users.loyalty_tier_id', '=', 'loyalty_tiers.loyalty_tier_id')
            ->groupBy('loyalty_tiers.tier_name')
            ->get();

        return [
            'labels' => $distribution->pluck('tier_name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $distribution->pluck('count')->toArray(),
                    'backgroundColor' => ['#FCD34D', '#9CA3AF', '#FCA5A5', '#60A5FA'],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
