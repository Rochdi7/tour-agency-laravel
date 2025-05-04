<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\TourStats;

class Dashboard extends BaseDashboard
{
    public function getHeaderWidgets(): array
    {
        return [
            TourStats::class,
        ];
    }
}
