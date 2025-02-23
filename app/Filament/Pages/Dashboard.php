<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ActiveCampaigns;
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\TopCustomers;
use App\Filament\Widgets\TransactionChart;
use App\Filament\Widgets\UserTierDistribution;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

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

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->label('Start Date')
                            ->default(now()->subMonth()),
                        DatePicker::make('endDate')
                            ->label('End Date')
                            ->default(now()),
                    ])
                    ->columns(2),
            ]);
    }
}
