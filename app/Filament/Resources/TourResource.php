<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Filament\Resources\TourResource\RelationManagers\ItineraryDaysRelationManager;
use App\Filament\Resources\TourResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\TourResource\RelationManagers\TourAccommodationRelationManager;
use Filament\Forms\Components\Select;
use App\Models\Tour;
use App\Models\Place; // Make sure Place model is imported
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

// Form Components
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
// use Filament\Forms\Components\Placeholder; // Not actively used for relations in form anymore
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;

// Table Columns
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Tours';
    protected static ?string $navigationGroup = 'Destinations';
    protected static ?int $navigationSort = 1;

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
                            ->unique(Tour::class, 'slug', ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Auto-generated from title, or can be manually set.'),

                        TextInput::make('subtitle')
                            ->label('Subtitle')
                            ->maxLength(255)
                            ->placeholder('e.g. Discover the magic of the Sahara')
                            ->columnSpanFull(),

                        TextInput::make('duration_days')
                            ->required()
                            ->label('Duration')
                            ->placeholder('e.g. 7, 3 Days, 1/2 Day')
                            ->hint('Examples: "7", "3 Days", "Half Day", "2.5 Days"')
                            ->maxLength(50),

                        TextInput::make('tour_type')
                            ->nullable()
                            ->maxLength(255)
                            ->label('Tour Type (e.g., Adventure, Cultural)'),
                    ]),

                Section::make('Content & Inclusions') // Grouped Content
                    ->collapsible()
                    ->schema([
                        RichEditor::make('overview')
                            ->required()
                            ->columnSpanFull(),

                        Textarea::make('includes')
                            ->rows(4)
                            ->label('What’s Included')
                            ->columnSpanFull(), // Make full width if desired

                        Textarea::make('excludes')
                            ->rows(4)
                            ->label('What’s Not Included')
                            ->columnSpanFull(), // Make full width if desired
                    ]),

                // SECTION FOR ITINERARY DAYS - USES REPEATER
                Section::make('Itinerary Days')
                    ->description('Add day-by-day itinerary. You can reorder days.')
                    ->collapsible()
                    ->collapsed() // Start collapsed
                    ->schema([
                        Repeater::make('itineraryDays')
                            ->relationship()
                            ->schema([
                                TextInput::make('day_number')->required()->numeric()->minValue(1)->default(1),
                                TextInput::make('title')->required()->maxLength(255),
                                RichEditor::make('description')->nullable()->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->addActionLabel('Add Itinerary Day')
                            ->reorderable('day_number')
                            ->defaultItems(0)
                            ->grid(1)
                            ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
                    ]),

                // SECTION FOR TOUR IMAGES - USES REPEATER
                Section::make('Tour Images')
                    ->description('Upload images for the tour gallery.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('images')
                            ->relationship()
                            ->schema([
                                FileUpload::make('image_path')
                                    ->label('Image File')
                                    ->image()
                                    ->directory('images/tours')
                                    ->disk('public')
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('caption')
                                    ->label('Caption (optional)')
                                    ->maxLength(255),
                                TextInput::make('alt')
                                    ->label('Alt Text (optional)')
                                    ->maxLength(255)
                                    ->helperText('Describe the image for SEO and accessibility.'),
                                Textarea::make('description') // Now a Textarea
                                    ->label('Image Description')
                                    ->rows(3),
                            ])
                            ->addActionLabel('Add Image')
                            ->defaultItems(0)
                            ->grid(1)
                            ->itemLabel(fn(array $state): ?string => $state['caption'] ?? 'New Image'),
                    ]),

                // SECTION FOR PLACES VISITED - USES SELECT (Works for Create & Edit)
                Section::make('Places Visited')
                    ->description('Select the key places visited during this tour.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Select::make('places')
                            ->relationship('places', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->placeholder('Select places visited')
                            ->helperText('You can select multiple places. These places must already exist in the "Places" table.')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Place::class, 'name'),
                            ])
                            ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                                return $action
                                    ->modalHeading('Create New Place')
                                    ->modalButton('Create Place');
                            }),
                    ]),

                // SECTION FOR ACCOMMODATIONS - USES REPEATER
                Section::make('Tour Accommodations')
                    ->description('Detail the accommodations for the tour.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('accommodations')
                            ->relationship()
                            ->schema([
                                TextInput::make('city')
                                    ->required()->maxLength(255),
                                TextInput::make('hotel_name')
                                    ->required()->maxLength(255),
                                Textarea::make('description')
                                    ->rows(3)->maxLength(1000)->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add Accommodation')
                            ->defaultItems(0)
                            ->grid(1)
                            ->itemLabel(fn(array $state): ?string => $state['hotel_name'] ? "{$state['hotel_name']} ({$state['city']})" : null),
                    ]),

                Section::make('Practical Details')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('transportation')->nullable()->maxLength(255),
                        TextInput::make('accommodation_summary')
                            ->label('Accommodation Summary')
                            ->nullable()
                            ->maxLength(255)
                            ->helperText('Brief summary like "Hotels, Guesthouses". Detailed accommodation added above/separately.'),
                        TextInput::make('departure')->nullable()->label('Departure Location')->maxLength(255),
                        TextInput::make('altitude')->nullable()->maxLength(255)->label('Max Altitude'),
                        TextInput::make('best_season')->nullable()->maxLength(255),
                        TextInput::make('group_size')->nullable()->label('Group Size Info (e.g., Min 2, Max 10)')->maxLength(255),
                        TextInput::make('min_age')->numeric()->nullable()->minValue(0)->label('Minimum Age'),
                        TextInput::make('max_age')->numeric()->nullable()->minValue(0)->label('Maximum Age (optional)'),
                        Textarea::make('map_embed_code')
                            ->label('Map Embed Code')
                            ->placeholder('<iframe src="..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>')
                            ->hint('Paste the Google Map iframe embed code here.')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Pricing')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
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
                            ->label('Old Price Adult (for display)')
                            ->numeric()
                            ->nullable()
                            ->prefix('$'),
                        TextInput::make('old_price_child')
                            ->label('Old Price Child (for display)')
                            ->numeric()
                            ->nullable()
                            ->prefix('$'),
                        TextInput::make('discount_percentage')
                            ->label('Discount (%)')
                            ->numeric()
                            ->nullable()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->placeholder('e.g. 10'),
                    ]),

                Section::make('Status & Visibility')
                    ->schema([
                        Toggle::make('is_popular')
                            ->label('Mark as Popular')
                            ->inline(false)
                            ->default(false),

                    ]),
            ]);
    }

    // ... table(), getRelations(), getPages(), getRecordTitleAttribute() methods remain the same
    // Make sure they are as per the previous correct versions.
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('firstImage.image_path')
                    ->disk('public')
                    ->label('Image')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder-tour.jpg')), // Ensure placeholder image exists or remove

                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('duration_days')->label('Duration')->sortable(),
                TextColumn::make('tour_type')->label('Type')->searchable()->limit(30)->placeholder('-'),
                TextColumn::make('price_adult')->money('USD', true)->sortable()->placeholder('N/A'),
                IconColumn::make('is_popular')->label('Popular')->boolean()->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean()->sortable(),
                TextColumn::make('updated_at')->label('Last Updated')->dateTime('M j, Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_popular'),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         ImagesRelationManager::class,
    //         ItineraryDaysRelationManager::class,
    //         TourAccommodationRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'view' => Pages\ViewTour::route('/{record}'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return 'title';
    }
}