<?php

namespace App\Filament\Widgets;

use App\Models\Campaign;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ActiveCampaigns extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 6;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $startDate = $this->filters['startDate'] ?? now()->subMonth();
        $endDate = $this->filters['endDate'] ?? now();

        return $table
            ->query(
                Campaign::query()
                    ->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate)
            )
            ->columns([
                Tables\Columns\TextColumn::make('campaign_name')
                    ->label('Campaign')
                    ->searchable(),
                Tables\Columns\TextColumn::make('point_multiplier')
                    ->label('Point Multiplier')
                    ->numeric(
                        decimalPlaces: 2,
                    ),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_transaction_types')
                    ->label('Transaction Types'),
                Tables\Columns\TextColumn::make('target_user_segments')
                    ->label('User Segments'),
            ]);
    }
}
