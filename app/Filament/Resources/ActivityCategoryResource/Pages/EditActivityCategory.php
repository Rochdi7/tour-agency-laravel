<?php

namespace App\Filament\Resources\ActivityCategoryResource\Pages;

use App\Filament\Resources\ActivityCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActivityCategory extends EditRecord
{
    protected static string $resource = ActivityCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
