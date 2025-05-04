<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Filament\Resources\TourResource\RelationManagers\ItineraryDaysRelationManager;
use App\Filament\Resources\TourResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\TourResource\RelationManagers\PlacesRelationManager;
use App\Filament\Resources\TourResource\RelationManagers\TourAccommodationRelationManager;

use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Tours';
    protected static ?string $navigationGroup = 'Destinations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Core Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Forms\Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),


                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('subtitle')
                            ->label('Subtitle')
                            ->maxLength(255)
                            ->placeholder('e.g. Discover the magic of the Sahara')
                            ->columnSpanFull(),


                        TextInput::make('duration_days')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label('Duration (Days)'),

                        TextInput::make('tour_type')
                            ->nullable()
                            ->maxLength(255)
                            ->label('Tour Type (e.g., Adventure, Cultural)'),
                    ]),

                Section::make('Content')
                    ->schema([
                        RichEditor::make('overview')
                            ->required()
                            ->columnSpanFull(),

                        Placeholder::make('itinerary_placeholder')
                            ->label('Itinerary Days')
                            ->content('Manage day-by-day itinerary below.')
                            ->visibleOn(['edit', 'view']),

                        Placeholder::make('images_placeholder')
                            ->label('Tour Images')
                            ->content('Upload/manage images below.')
                            ->visibleOn(['edit', 'view']),

                        Placeholder::make('places_placeholder')
                            ->label('Places')
                            ->content('Manage visited places below.')
                            ->visibleOn(['edit', 'view']),

                        Textarea::make('includes')
                            ->rows(4)
                            ->label('What’s Included'),

                        Textarea::make('excludes')
                            ->rows(4)
                            ->label('What’s Not Included'),

                    ]),

                Section::make('Practical Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('transportation')->nullable()->maxLength(255),
                        TextInput::make('accommodation')->nullable()->maxLength(255),
                        TextInput::make('departure')->nullable()->label('Departure Location')->maxLength(255),
                        TextInput::make('altitude')->nullable()->maxLength(255),
                        TextInput::make('best_season')->nullable()->maxLength(255),
                        TextInput::make('group_size')->nullable()->label('Group Size Info')->maxLength(255),
                        TextInput::make('min_age')->numeric()->nullable()->minValue(0),
                        TextInput::make('max_age')->numeric()->nullable()->minValue(0),
                    ]),

                Section::make('Pricing')
                    ->columns(2)
                    ->schema([
                        TextInput::make('price_adult')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0),

                        TextInput::make('price_child')
                            ->numeric()
                            ->nullable()
                            ->prefix('$')
                            ->minValue(0),
                        TextInput::make('old_price_adult')
                            ->label('Old Price Adult')
                            ->numeric()
                            ->prefix('$')
                            ->columnSpan(1),

                        TextInput::make('old_price_child')
                            ->label('Old Price Child')
                            ->numeric()
                            ->prefix('$')
                            ->columnSpan(1),

                        TextInput::make('discount')
                            ->label('Discount (%)')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(100)
                            ->prefix('%')
                            ->placeholder('e.g. 10')
                            ->columnSpan(1),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('firstImage.image')
                    ->disk('public')
                    ->label('Image')
                    ->circular(),

                TextColumn::make('title')->sortable()->searchable(),

                TextColumn::make('duration_days')
                    ->label('Duration')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state . ' ' . Str::plural('Day', $state)),

                TextColumn::make('tour_type')->label('Type')->searchable()->limit(30),

                TextColumn::make('places_count')
                    ->counts('places')
                    ->label('Places')
                    ->sortable(),

                TextColumn::make('price_adult')->money('USD', true)->sortable(),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            ItineraryDaysRelationManager::class,
            ImagesRelationManager::class,
            PlacesRelationManager::class,
            TourAccommodationRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'view' => Pages\ViewTour::route('/{record}'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}
