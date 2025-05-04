<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Filament\Resources\TripResource\RelationManagers\ItineraryDaysRelationManager;
use App\Filament\Resources\TripResource\RelationManagers\ImagesRelationManager;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Destinations';
    protected static ?string $navigationLabel = 'Trips';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Core Info')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    TextInput::make('duration_days')
                        ->required()
                        ->numeric()
                        ->minValue(1)
                        ->label('Duration (Days)'),

                    TextInput::make('tour_type')
                        ->nullable()
                        ->label('Trip Type'),
                ]),

            Section::make('Content')
                ->schema([
                    RichEditor::make('overview')->required()->columnSpanFull(),

                    Placeholder::make('itinerary_placeholder')
                        ->label('Itinerary Days')
                        ->content('Manage day-by-day itinerary details using the relation manager below.')
                        ->visibleOn(['edit', 'view']),

                    Placeholder::make('images_placeholder')
                        ->label('Trip Images')
                        ->content('Upload and manage images using the relation manager below.')
                        ->visibleOn(['edit', 'view']),

                    Textarea::make('includes')->label('What\'s Included')->nullable(),
                    Textarea::make('excludes')->label('What\'s Not Included')->nullable(),
                    RichEditor::make('faq')->label('FAQs')->nullable(),
                ]),

            Section::make('Details')
                ->columns(2)
                ->schema([
                    TextInput::make('transportation')->nullable(),
                    TextInput::make('accommodation')->nullable(),
                    TextInput::make('departure')->label('Departure Point')->nullable(),
                    TextInput::make('altitude')->label('Max Altitude')->nullable(),
                    TextInput::make('best_season')->label('Best Season')->nullable(),
                    TextInput::make('group_size')->nullable(),
                    TextInput::make('min_age')->numeric()->nullable()->minValue(0),
                    TextInput::make('max_age')->numeric()->nullable()->minValue(0),
                ]),

            Section::make('Pricing')
                ->columns(2)
                ->schema([
                    TextInput::make('price_adult')
                        ->label('Adult Price')
                        ->required()
                        ->numeric()
                        ->prefix('$'),

                    TextInput::make('price_child')
                        ->label('Child Price')
                        ->numeric()
                        ->nullable()
                        ->prefix('$'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images.0.image_path')
                    ->disk('public')
                    ->label('Image')
                    ->circular()
                    ->limit(1),

                TextColumn::make('title')->sortable()->searchable(),

                TextColumn::make('duration_days')
                    ->label('Duration')
                    ->formatStateUsing(fn ($state) => $state . ' ' . Str::plural('Day', $state))
                    ->sortable(),

                TextColumn::make('price_adult')
                    ->label('Adult Price')
                    ->money('USD', true)
                    ->sortable(),

                TextColumn::make('updated_at')->dateTime('M j, Y')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
    public static function shouldRegisterNavigation(): bool
{
    return false;
}
}
