<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class TransactionsChart extends ChartWidget
{
    protected static ?string $heading = 'Transactions Over Time';

    protected function getData(): array
    {
        // Get date range from dashboard filter
        $dateRange = $this->filters['date_range'] ?? null;

        $query = Transaction::query();

        if ($dateRange) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) === 2) {
                $query->whereBetween('created_at', $dates);
            }
        }

        $data = $query
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Transactions',
                    'data' => $data->pluck('count')->toArray(),
                    'borderColor' => '#6366f1',
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->pluck('date')->map(function ($date) {
                return Carbon::parse($date)->format('M d');
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
