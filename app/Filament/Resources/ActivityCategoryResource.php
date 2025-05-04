<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityCategoryResource\Pages;
use App\Filament\Resources\ActivityCategoryResource\RelationManagers;
use App\Models\ActivityCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str; // Import Str facade

class ActivityCategoryResource extends Resource
{
    protected static ?string $model = ActivityCategory::class;

    // Choose an appropriate icon from heroicons.com (e.g., folder, tag, collection)
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    // Optional: Group it in the navigation sidebar

    // Optional: Control the sort order in the sidebar
    protected static ?int $navigationSort = 1;

    // Make 'name' searchable globally in Filament
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true) // Update slug when name changes (on blur)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                if ($state) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ActivityCategory::class, 'slug', ignoreRecord: true) // Check uniqueness, ignore current record on edit
                            ->readOnly() // Make slug read-only as it's generated
                            ->helperText('Slug is automatically generated from the name.'),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('Category Image')
                            ->directory('categories') // Directory within storage/app/public
                            ->image() // Specify it's an image for preview & validation
                            ->imageEditor() // Optional: Add image editor
                            ->nullable() // Make it optional
                            ->disk('public') // Use the public disk
                            ->visibility('public') // Ensure files are publicly accessible
                            ->placeholder('Upload an image for the category (optional)'),

                        Forms\Components\Textarea::make('description')
                            ->nullable()
                            ->rows(3)
                            ->maxLength(65535)
                            ->columnSpanFull(), // Make textarea take full width
                    ])->columns(2), // Arrange fields in 2 columns within the section
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public') // Specify the disk
                    ->toggleable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Often hidden by default

                // Display the count of related activities
                Tables\Columns\TextColumn::make('activities_count')
                    ->counts('activities') // Use Filament's built-in relationship counter
                    ->label('Activities')
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->limit(50) // Show only first 50 chars in table
                    ->tooltip(fn (ActivityCategory $record): ?string => $record->description) // Show full text on hover
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // No filters defined yet, add if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Add delete action
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc'); // Sort by name by default
    }

    public static function getRelations(): array
    {
        return [
            // You could add a RelationManager to show activities within each category here later
            // RelationManagers\ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityCategories::route('/'),
            'create' => Pages\CreateActivityCategory::route('/create'),
            'edit' => Pages\EditActivityCategory::route('/{record}/edit'),
        ];
    }
}