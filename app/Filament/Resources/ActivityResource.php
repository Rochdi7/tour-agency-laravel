<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers\ItineraryDaysRelationManager;
use App\Models\Activity;
use App\Models\ActivityCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use App\Filament\Resources\ActivityResource\RelationManagers\ImagesRelationManager;


class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationLabel = 'Activities';
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
                            ->nullable()
                            ->maxLength(255)
                            ->label('Subtitle'),

                        Select::make('activity_category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(Forms\Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ActivityCategory::class, 'slug', ignoreRecord: true)
                                    ->maxLength(255),
                                Textarea::make('description')->nullable(),
                            ])
                            ->columnSpanFull(),

                        TextInput::make('duration_days')
                            ->label('Duration (Days)')
                            ->numeric()
                            ->required()
                            ->minValue(0),

                    ]),

                Section::make('Content & Details')
                    ->schema([
                        RichEditor::make('overview')
                            ->label('Overview')
                            ->nullable()
                            ->columnSpanFull(),

                        Placeholder::make('itinerary_placeholder')
                            ->label('Itinerary Days')
                            ->content('Manage day-by-day itinerary details using the relation manager below.')
                            ->visibleOn(['edit', 'view', 'create']),

                        Placeholder::make('images_placeholder')
                            ->label('Activity Images')
                            ->content('Upload and manage images using the relation manager below.')
                            ->visibleOn(['edit', 'view']),

                        Textarea::make('includes')
                            ->label('What\'s Included')
                            ->rows(5)
                            ->nullable(),

                        Textarea::make('excludes')
                            ->label('What\'s Not Included')
                            ->rows(5)
                            ->nullable(),
                    ]),

                Section::make('Practical Info')
                    ->columns(2)
                    ->schema([
                        TextInput::make('transportation')->nullable()->maxLength(255),
                        TextInput::make('accommodation')->nullable()->maxLength(255),
                        TextInput::make('departure')->label('Departure Location')->nullable()->maxLength(255),
                        TextInput::make('altitude')->label('Max Altitude')->nullable()->maxLength(255),
                        TextInput::make('best_season')->label('Best Season(s)')->nullable()->maxLength(255),
                        TextInput::make('tour_type')->label('Activity Type')->nullable()->maxLength(255),
                        TextInput::make('group_size')->nullable()->maxLength(255),
                        TextInput::make('min_age')->label('Minimum Age')->numeric()->nullable()->minValue(0),
                        TextInput::make('max_age')->label('Maximum Age')->numeric()->nullable()->minValue(0),
                    ]),

                Section::make('Pricing')
                    ->columns(2)
                    ->schema([
                        TextInput::make('price_adult')
                            ->label('Adult Price')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->minValue(0),

                        TextInput::make('price_child')
                            ->label('Child Price')
                            ->numeric()
                            ->prefix('$')
                            ->nullable()
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
                            ->placeholder('e.g. 15')
                            ->columnSpan(1),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('duration_days')
                    ->label('Duration')
                    ->formatStateUsing(fn($state) => $state . ' ' . Str::plural('Day', $state))
                    ->sortable(),
                TextColumn::make('price_adult')->money('USD', true)->sortable(),
                TextColumn::make('updated_at')->dateTime('M j, Y')->sortable(),
            ])
            ->filters([])
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
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
