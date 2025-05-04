<?php

namespace App\Filament\Resources\TourResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;

class TourAccommodationRelationManager extends RelationManager
{
    protected static string $relationship = 'accommodations';
    protected static ?string $recordTitleAttribute = 'hotel_name';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('city')->required()->maxLength(255),
            TextInput::make('hotel_name')->required()->maxLength(255),
            Textarea::make('description')->rows(4)->maxLength(1000),
        ]);
    }
    
    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('city')->searchable()->sortable(),
                TextColumn::make('hotel_name')->searchable()->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
    
}
