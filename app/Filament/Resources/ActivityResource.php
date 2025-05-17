<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
// Make sure these Relation Managers are specific to Activity or generic enough
use App\Filament\Resources\ActivityResource\RelationManagers\ItineraryDaysRelationManager;
use App\Filament\Resources\ActivityResource\RelationManagers\ImagesRelationManager;

use App\Models\Activity;
use App\Models\ActivityCategory;
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
use Filament\Forms\Components\Select;
// use Filament\Forms\Components\Placeholder; // Will be replaced by Repeaters
use Filament\Forms\Components\Toggle; // Added
use Filament\Forms\Components\Repeater; // Added
use Filament\Forms\Components\FileUpload; // Added

// Table Columns
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn; // For table display if needed
use Filament\Tables\Columns\IconColumn; // For table display if needed


class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationLabel = 'Activities';
    protected static ?string $navigationGroup = 'Destinations';
    protected static ?int $navigationSort = 2; // Example sort order

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
                            ->unique(Activity::class, 'slug', ignoreRecord: true) // Specify model for unique rule
                            ->maxLength(255),

                        TextInput::make('subtitle')
                            ->nullable()
                            ->maxLength(255)
                            ->label('Subtitle'),

                        Select::make('activity_category_id')
                            ->label('Category')
                            ->relationship('category', 'name') // Assumes 'category' relationship in Activity model
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
                            ->createOptionAction(function (Forms\Components\Actions\Action $action) { // Nicer modal title
                                return $action
                                    ->modalHeading('Create New Activity Category')
                                    ->modalButton('Create Category');
                            })
                            ->columnSpanFull(),

                        TextInput::make('duration_days') // Assuming this is what you meant, not duration in days
                            ->label('Duration (e.g., 3 Days, Half Day)')
                            ->required()
                            ->maxLength(50) // Allow text like "Half Day"
                            ->placeholder("e.g. 3 Days, Half Day, 2 hours"),

                    ]),

                Section::make('Content & Details')
                    ->collapsible()
                    ->schema([
                        RichEditor::make('overview')
                            ->label('Overview')
                            ->nullable()
                            ->columnSpanFull(),

                        Textarea::make('includes')
                            ->label('What\'s Included')
                            ->rows(4) // Adjusted rows
                            ->nullable()
                            ->columnSpanFull(),

                        Textarea::make('excludes')
                            ->label('What\'s Not Included')
                            ->rows(4) // Adjusted rows
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                // SECTION FOR ITINERARY DAYS - USES REPEATER
                Section::make('Itinerary Days')
                    ->description('Add day-by-day itinerary if applicable for this activity.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('itineraryDays') // Matches 'itineraryDays' relationship in Activity model
                            ->relationship()
                            ->schema([
                                TextInput::make('day_number')->required()->numeric()->minValue(1)->default(1)
                                    ->helperText('For multi-day activities, otherwise 1.'),
                                TextInput::make('title')->required()->maxLength(255),
                                RichEditor::make('description')->nullable()->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->addActionLabel('Add Itinerary Day')
                            ->reorderable('day_number')
                            ->defaultItems(0)
                            ->grid(1)
                            ->itemLabel(fn(array $state): ?string => $state['title'] ?? 'New Itinerary Day'),
                    ]),

                // SECTION FOR ACTIVITY IMAGES - USES REPEATER
                Section::make('Activity Images')
                    ->description('Upload images for the activity gallery.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('images') // Matches 'images' relationship in Activity model
                            ->relationship()
                            ->schema([
                                FileUpload::make('image') // Field in your ActivityImage model
                                    ->label('Image File')
                                    ->image()
                                    ->directory('images/activities') // Specific directory for activity images
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
                                Textarea::make('description')
                                    ->label('Image Description (optional)')
                                    ->rows(3),
                            ])
                            ->addActionLabel('Add Image')
                            ->defaultItems(0)
                            ->grid(1) // Each image item takes its own "row"
                            ->itemLabel(fn(array $state): ?string => $state['caption'] ?? ($state['image'] ? basename($state['image']) : 'New Image')),
                    ]),


                Section::make('Practical Info')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('transportation')->nullable()->maxLength(255),
                        TextInput::make('accommodation')->nullable()->maxLength(255)
                            ->helperText("Relevant if activity spans multiple days."),
                        TextInput::make('departure')->label('Departure Location/Meeting Point')->nullable()->maxLength(255),
                        TextInput::make('altitude')->label('Max Altitude (if applicable)')->nullable()->maxLength(255),
                        TextInput::make('best_season')->label('Best Season(s)')->nullable()->maxLength(255),
                        // TextInput::make('tour_type')->label('Activity Type')->nullable()->maxLength(255), // 'tour_type' is usually for Tours
                        TextInput::make('group_size')->label('Group Size (e.g., Min 2, Max 10)')->nullable()->maxLength(255),
                        TextInput::make('min_age')->label('Minimum Age')->numeric()->nullable()->minValue(0),
                        TextInput::make('max_age')->label('Maximum Age (optional)')->numeric()->nullable()->minValue(0),
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
                            ->label('Adult Price')
                            ->numeric()
                            ->prefix('$') // Or your currency symbol
                            ->required()
                            ->minValue(0),

                        TextInput::make('price_child')
                            ->label('Child Price (optional)')
                            ->numeric()
                            ->prefix('$')
                            ->nullable()
                            ->minValue(0),

                        TextInput::make('old_price_adult')
                            ->label('Old Price Adult (for display)')
                            ->numeric()
                            ->prefix('$')
                            ->nullable(),

                        TextInput::make('old_price_child')
                            ->label('Old Price Child (for display)')
                            ->numeric()
                            ->prefix('$')
                            ->nullable(),

                        TextInput::make('discount_percentage') // Renamed for clarity
                            ->label('Discount (%)')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%') // Use suffix for percentage
                            ->placeholder('e.g. 10')
                            ->nullable(),
                    ]),

                Section::make('Activity Status')
                    ->schema([
                        Toggle::make('is_popular')
                            ->label('Mark as Popular')
                            ->inline(false)
                            ->default(false),
                    
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
    ->circular()
    ->defaultImageUrl(url('/images/placeholder-activity.jpg')),


                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('category.name')->label('Category')->sortable()->searchable(),
                TextColumn::make('duration_days')
                    ->label('Duration')
                    // ->formatStateUsing(fn($state) => $state . ' ' . Str::plural('Day', (int) filter_var($state, FILTER_SANITIZE_NUMBER_INT))) // More robust for "Half Day" etc.
                    ->sortable(),
                TextColumn::make('price_adult')->money('USD', true)->sortable(),
                IconColumn::make('is_popular')->label('Popular')->boolean()->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean()->sortable(),
                TextColumn::make('updated_at')->dateTime('M j, Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('activity_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
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
    //     // These Relation Managers will appear as tabs on the Edit Activity page
    //     return [
    //         ItineraryDaysRelationManager::class, // Ensure this is specific to Activity or generic
    //         ImagesRelationManager::class,        // Ensure this is specific to Activity or generic
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            // 'view' => Pages\ViewActivity::route('/{record}'), // Filament v3 uses {record}
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }

    // Optional: For better UX with slugs & titles
    public static function getRecordTitleAttribute(): ?string
    {
        return 'title';
    }

    // If 'slug' is your primary route key for Activity model:
    // In App\Models\Activity: public function getRouteKeyName() { return 'slug'; }
}