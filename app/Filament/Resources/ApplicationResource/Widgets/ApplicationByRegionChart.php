<?php

namespace App\Filament\Resources\ApplicationResource\Widgets;

use App\Models\Region;
use Filament\Widgets\ChartWidget;

class ApplicationByRegionChart extends ChartWidget
{
    protected static ?string $heading = 'Application by region';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => Region::withCount('applications')->orderBy('name')->pluck('applications_count'),
                    'backgroundColor' => '#36ACEF',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => Region::orderBy('name')->pluck('name'),

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
