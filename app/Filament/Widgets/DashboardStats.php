<?php

namespace App\Filament\Widgets;

use App\Models\Point;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPoints = Point::where('point_type', 'earned')->sum('point_value');
        $redeemedPoints = Point::where('point_type', 'redeemed')->sum('point_value');

        return [
            Stat::make('Total Users', User::count())
                ->description('Active loyalty program members')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart(User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                    ->groupBy('date')
                    ->limit(7)
                    ->pluck('count')
                    ->toArray()),

            Stat::make('Total Transactions', Transaction::count())
                ->description('Total value: $' . number_format(Transaction::sum('transaction_amount'), 2))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->chart(Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                    ->groupBy('date')
                    ->limit(7)
                    ->pluck('count')
                    ->toArray()),

            Stat::make('Points Balance', number_format($totalPoints - $redeemedPoints))
                ->description(number_format($redeemedPoints) . ' points redeemed')
                ->descriptionIcon('heroicon-m-star')
                ->chart(Point::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(point_value) as total'))
                    ->where('point_type', 'earned')
                    ->groupBy('date')
                    ->limit(7)
                    ->pluck('total')
                    ->toArray()),
        ];
    }
}
