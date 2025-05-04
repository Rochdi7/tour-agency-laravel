<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Blog Articles';
    protected static ?string $pluralModelLabel = 'Blogs';
    protected static ?string $modelLabel = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
    
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
    
                Forms\Components\TextInput::make('written_by')
                    ->label('Author')
                    ->required(),
    
                Forms\Components\TextInput::make('quote')->nullable(),
                Forms\Components\TextInput::make('quote_author')->nullable(),
    
                Forms\Components\Textarea::make('summary')
                    ->rows(3)
                    ->nullable(),
    
                Forms\Components\Textarea::make('content')
                    ->rows(8)
                    ->required(),
    
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->required(),
    
                Forms\Components\Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->label('Tags'),
    
                Forms\Components\FileUpload::make('featured_image')
                    ->image()
                    ->directory('images/blogs')
                    ->preserveFilenames()
                    ->label('Featured Image')
                    ->nullable(),
    
                // ✅ NEW FIELDS FOR IMAGE META
                Forms\Components\TextInput::make('featured_image_caption')
                    ->label('Image Caption')
                    ->maxLength(255)
                    ->nullable(),
    
                Forms\Components\TextInput::make('featured_image_alt')
                    ->label('Alt Text')
                    ->maxLength(255)
                    ->nullable()
                    ->helperText('Describe the image for SEO and accessibility.'),
    
                Forms\Components\Textarea::make('featured_image_description')
                    ->label('Image Description')
                    ->rows(3)
                    ->nullable(),
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('written_by')->label('Author'),
                Tables\Columns\TextColumn::make('category.name')->label('Category'),
                Tables\Columns\ImageColumn::make('featured_image')->label('Image')->circular(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Example: RelationManagers\TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
