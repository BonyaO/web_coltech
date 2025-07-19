<?php

namespace App\Filament\Resources\ApplicationResource\Widgets;

use App\Models\Application;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApplicationOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total applicants', Application::query()->count()),
            Stat::make('Males', Application::query()->where('gender', 'male')->count()),
            Stat::make('Females', Application::query()->where('gender', 'female')->count()),
        ];
    }
}
