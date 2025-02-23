<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class TopCustomers extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $startDate = $this->filters['startDate'] ?? now()->subMonth();
        $endDate = $this->filters['endDate'] ?? now();

        return $table
            ->query(
                User::query()
                    ->join('transactions', 'users.id', '=', 'transactions.user_id')
                    ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
                    ->groupBy('users.id', 'users.name', 'users.email')
                    ->selectRaw('users.*, SUM(transactions.transaction_amount) as total_spent')
                    ->orderByDesc('total_spent')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_spent')
                    ->money('NGN')
                    ->label('Total Spent')
                    ->sortable(),
            ]);
    }
}
