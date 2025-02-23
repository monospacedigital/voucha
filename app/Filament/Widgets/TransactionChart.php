<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Transaction Volume';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $days = now()->subDays(30);

        $data = Transaction::select(
            'transaction_type',
            DB::raw('DATE(transaction_date) as date'),
            DB::raw('COALESCE(SUM(transaction_amount), 0) as amount')
        )
            ->where('status', 'completed')
            ->where('transaction_date', '>=', $days)
            ->groupBy('date', 'transaction_type')
            ->orderBy('date')
            ->get();

        // Generate all dates in the range
        $dateRange = collect();
        for ($date = $days; $date <= now(); $date->addDay()) {
            $dateRange->push($date->format('Y-m-d'));
        }

        $types = ['airtime', 'bill_payment', 'transfer'];
        $colors = [
            'airtime' => '#60A5FA',
            'bill_payment' => '#34D399',
            'transfer' => '#F87171',
        ];

        $datasets = [];
        foreach ($types as $type) {
            $typeData = [];
            foreach ($dateRange as $date) {
                $amount = $data->where('date', $date)
                    ->where('transaction_type', $type)
                    ->first()?->amount ?? 0;
                $typeData[] = $amount;
            }

            $datasets[] = [
                'label' => ucfirst(str_replace('_', ' ', $type)),
                'data' => $typeData,
                'borderColor' => $colors[$type],
                'backgroundColor' => $colors[$type] . '40',
                'fill' => true,
                'tension' => 0.3,
            ];
        }

        return [
            'labels' => $dateRange->map(fn ($date) => Carbon::parse($date)->format('M d'))->toArray(),
            'datasets' => $datasets,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => "function(value) { return '$' + value.toLocaleString() }",
                    ],
                ],
            ],
            'elements' => [
                'line' => [
                    'borderWidth' => 2,
                ],
                'point' => [
                    'radius' => 4,
                    'hoverRadius' => 6,
                ],
            ],
        ];
    }
}
