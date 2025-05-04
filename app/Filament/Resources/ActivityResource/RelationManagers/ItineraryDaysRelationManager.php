<?php

namespace App\Filament\Resources\ActivityResource\RelationManagers;

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
    protected static string $relationship = 'itineraryDays'; // <-- IMPORTANT
    protected static ?string $title = 'Itinerary Days';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('day_number')
                ->required()
                ->numeric()
                ->minValue(1)
                ->label('Day Number'),

            TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->label('Title'),

            RichEditor::make('description')
                ->nullable()
                ->label('Description'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->reorderable('day_number')
            ->columns([
                TextColumn::make('day_number')
                    ->sortable()
                    ->label('Day'),

                TextColumn::make('title')
                    ->searchable()
                    ->label('Title'),

                TextColumn::make('description')
                    ->limit(60)
                    ->html()
                    ->label('Description'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('day_number', 'asc');
    }
    public static function getRelations(): array
{
    return [
        ItineraryDaysRelationManager::class,
    ];
}
}
