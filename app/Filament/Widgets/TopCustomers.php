<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopCustomers extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::select('users.*')
                    ->selectRaw('SUM(CASE WHEN points.point_type = "earned" THEN points.point_value ELSE 0 END) as points_earned')
                    ->selectRaw('SUM(CASE WHEN points.point_type = "redeemed" THEN points.point_value ELSE 0 END) as points_redeemed')
                    ->leftJoin('points', 'users.id', '=', 'points.user_id')
                    ->groupBy('users.id')
                    ->orderByRaw('(points_earned - points_redeemed) DESC')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('loyaltyTier.tier_name')
                    ->label('Tier'),
                Tables\Columns\TextColumn::make('points_earned')
                    ->label('Points Earned')
                    ->numeric(),
                Tables\Columns\TextColumn::make('points_redeemed')
                    ->label('Points Redeemed')
                    ->numeric(),
                Tables\Columns\TextColumn::make('registration_date')
                    ->dateTime(),
            ]);
    }
}
