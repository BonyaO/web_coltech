<?php

namespace App\Filament\Resources\ApplicationResource\Widgets;

use App\Models\Application;
use Filament\Widgets\ChartWidget;

class ApplicationByGenderChart extends ChartWidget
{
    protected static ?string $heading = 'Applicants by gender';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => [
                        Application::query()->where('gender', 'male')->count(),
                        Application::query()->where('gender', 'female')->count(),
                    ],
                    'backgroundColor' => ['#36A2EB', 'orangered'],
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Males', 'Females'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
