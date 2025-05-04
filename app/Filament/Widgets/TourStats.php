<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Tour; // ✅ Make sure you have a Tour model

class TourStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Tours', Tour::count())
                ->description('Number of published tours')
                ->color('success')
                ->icon('heroicon-o-map'),
        ];
    }
}
