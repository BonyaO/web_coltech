<?php

namespace App\Filament\Resources\ApplicationResource\Widgets;

use App\Models\ExamCenter;
use Filament\Widgets\ChartWidget;

class ApplicationChart extends ChartWidget
{
    protected static ?string $heading = 'Applicants by examination center';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => ExamCenter::withCount('applications')->orderBy('name')->pluck('applications_count'),
                    'backgroundColor' => ['red', 'green', 'blue', 'orange'],
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ExamCenter::orderBy('name')->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
