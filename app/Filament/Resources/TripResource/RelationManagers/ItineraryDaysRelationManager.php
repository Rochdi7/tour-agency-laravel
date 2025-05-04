<?php

namespace App\Filament\Resources\TripResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;

class ItineraryDaysRelationManager extends RelationManager
{
    protected static string $relationship = 'itineraryDays';
    protected static ?string $title = 'Itinerary Days';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('day_number')
                ->label('Day')
                ->required()
                ->numeric()
                ->minValue(1),

            TextInput::make('title')
                ->label('Title')
                ->required()
                ->maxLength(255),

            RichEditor::make('description')
                ->label('Details')
                ->nullable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->reorderable('day_number')
            ->columns([
                TextColumn::make('day_number')->sortable(),
                TextColumn::make('title')->searchable(),
                TextColumn::make('description')->limit(60)->html(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
            ]);
    }
}
