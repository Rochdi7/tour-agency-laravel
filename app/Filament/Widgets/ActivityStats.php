<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Activity;

class ActivityStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Activities', Activity::count())
                ->description('Number of published activities')
                ->color('warning')
                ->icon('heroicon-o-sparkles'),
        ];
    }
}
