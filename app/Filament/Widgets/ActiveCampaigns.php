<?php

namespace App\Filament\Widgets;

use App\Models\Campaign;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ActiveCampaigns extends BaseWidget
{
    protected static ?int $sort = 6;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Campaign::where('end_date', '>=', now())
                    ->orderBy('start_date')
            )
            ->columns([
                Tables\Columns\TextColumn::make('campaign_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('point_multiplier')
                    ->numeric(
                        decimalPlaces: 2,
                    ),
                Tables\Columns\TextColumn::make('start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date(),
                Tables\Columns\TextColumn::make('target_transaction_types'),
                Tables\Columns\TextColumn::make('target_user_segments'),
            ]);
    }
}
