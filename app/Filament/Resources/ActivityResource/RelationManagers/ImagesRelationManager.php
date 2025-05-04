<?php

namespace App\Filament\Resources\ActivityResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';
    protected static ?string $title = 'Activity Images';

    public function form(Form $form): Form
{
    return $form->schema([
        FileUpload::make('image')
            ->image()
            ->directory('images/activities')
            ->disk('public')
            ->required(),

        TextInput::make('caption')
            ->label('Caption')
            ->maxLength(255)
            ->nullable(),

        TextInput::make('alt')
            ->label('Alt Text')
            ->maxLength(255)
            ->nullable()
            ->helperText('Used for SEO and accessibility.'),

        Forms\Components\Textarea::make('description')
            ->label('Image Description')
            ->rows(3)
            ->nullable(),
    ]);
}


public function table(Table $table): Table
{
    return $table
        ->columns([
            ImageColumn::make('image')
                ->disk('public')
                ->label('Image'),

            TextColumn::make('caption')->label('Caption')->limit(40),
            TextColumn::make('alt')->label('Alt')->limit(40),
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
