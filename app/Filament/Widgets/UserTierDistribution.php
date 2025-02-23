<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class UserTierDistribution extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'User Tier Distribution';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? now()->subMonth();
        $endDate = $this->filters['endDate'] ?? now();

        $distribution = User::query()
            ->join('loyalty_tiers', 'users.loyalty_tier_id', '=', 'loyalty_tiers.loyalty_tier_id')
            ->whereBetween('users.registration_date', [$startDate, $endDate])
            ->selectRaw('loyalty_tiers.tier_name, COUNT(*) as count')
            ->groupBy('loyalty_tiers.tier_name')
            ->orderBy('loyalty_tiers.tier_name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Users per Tier',
                    'data' => $distribution->pluck('count')->toArray(),
                    'backgroundColor' => ['#FCD34D', '#9CA3AF', '#FCA5A5', '#60A5FA'],
                ],
            ],
            'labels' => $distribution->pluck('tier_name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
