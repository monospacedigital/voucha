<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? now()->subMonth();
        $endDate = $this->filters['endDate'] ?? now();

        $query = Transaction::query();
        $usersQuery = User::query();

        if ($startDate && $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
            $usersQuery->whereBetween('registration_date', [$startDate, $endDate]);
        }

        return [
            Stat::make('Total Transactions', $query->count())
                ->description('All processed transactions')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Total Users', $usersQuery->count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('info'),

            Stat::make('Total Revenue', '₦' . number_format($query->sum('transaction_amount'), 2))
                ->description('Overall revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('warning'),
        ];
    }
}
