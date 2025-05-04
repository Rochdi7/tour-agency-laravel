<?php

namespace App\Filament\Resources\TourImageResource\Pages;

use App\Filament\Resources\TourImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourImage extends EditRecord
{
    protected static string $resource = TourImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
