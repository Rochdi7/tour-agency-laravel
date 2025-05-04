<?php

namespace App\Filament\Resources\TourResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';
    protected static ?string $title = 'Tour Images';

    public function form(Form $form): Form
{
    return $form->schema([
        FileUpload::make('image_path')
            ->image()
            ->directory('images/tours')
            ->disk('public')
            ->required(),

        Forms\Components\TextInput::make('caption')
            ->label('Caption')
            ->maxLength(255),

        Forms\Components\TextInput::make('alt')
            ->label('Alt Text')
            ->maxLength(255)
            ->helperText('Describe the image for SEO and accessibility.'),

        Forms\Components\Textarea::make('description')
            ->label('Image Description')
            ->rows(3),
    ]);
}


public function table(Table $table): Table
{
    return $table
        ->recordTitleAttribute('caption')
        ->columns([
            ImageColumn::make('image_path')
                ->disk('public')
                ->label('Image')
                ->width(100)
                ->height('auto'),

            TextColumn::make('caption')->limit(30),
            TextColumn::make('alt')->limit(30)->label('Alt Text'),
            TextColumn::make('created_at')->dateTime()->label('Uploaded'),
        ])
        ->headerActions([Tables\Actions\CreateAction::make()])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}

}
