<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ActiveCampaigns;
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\TopCustomers;
use App\Filament\Widgets\TransactionChart;
use App\Filament\Widgets\UserTierDistribution;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getWidgets(): array
    {
        return [
            DashboardStats::class,
            TransactionChart::class,
            UserTierDistribution::class,
            TopCustomers::class,
            ActiveCampaigns::class,
        ];
    }
}
