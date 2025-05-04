<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Trip;

class TripStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Trips', Trip::count())
                ->description('Number of published trips')
                ->color('info')
                ->icon('heroicon-o-briefcase'),
        ];
    }
}
