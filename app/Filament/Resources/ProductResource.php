<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $breadcrumb = 'Products';
    protected static ?string $title = 'Products';
    protected static ?string $slug = 'products';
    protected static ?string $navigationGroup = 'Products';
    protected static ?int $navigationSort = 1 ;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title_en')
                    ->required()
                    ->maxLength(255),
                TextInput::make('title_ar')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name_en')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name_ar')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description_en')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'link', 'bulletList', 'orderedList',
                        'blockquote', 'codeBlock',
                    ])->required(),
                Forms\Components\RichEditor::make('description_ar')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'link', 'bulletList', 'orderedList',
                        'blockquote', 'codeBlock',
                    ])->required(),
                FileUpload::make('avatar_main')
                    ->disk('public')
                    ->directory('products/main')
                    ->image()
                    ->maxSize(5120)
                    ->required(),
                FileUpload::make('avatar_details')
                    ->multiple()
                    ->disk('public')
                    ->directory('products/details')
                    ->image()
                    ->maxSize(5120)
                    ->required(),
                    TextInput::make('price_before_discount')
                    ->numeric()
                    ->nullable(),
                TextInput::make('price')
                    ->numeric()
                    ->required(),
                TextInput::make('quantity')
                    ->regex('/^\d+$/')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name_en')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title_en')
                    ->searchable(),
                TextColumn::make('title_ar')
                    ->searchable(),
                TextColumn::make('name_en')
                    ->searchable(),
                TextColumn::make('name_ar')
                    ->searchable(),
                TextColumn::make('description_en')
                    ->limit(50),
                TextColumn::make('description_ar')
                    ->limit(50),
                ImageColumn::make('avatar_main_url')
                    ->label('Avatar')
                    ->sortable(),
                TextColumn::make('price')
                    ->sortable(),
                TextColumn::make('category.name_en')
                    ->label('Category')
                    ->sortable(),
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Product')
                    ->modalButton('Save Changes')
                    ->using(function ($record, array $data) {
                        $record->update($data);
                    }),
                Tables\Actions\DeleteAction::make()
                    ->action(function ($record) {
                        $record->delete();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->modalHeading('Delete Product')
                    ->modalSubheading('Are you sure you want to delete this Product? This action cannot be undone.')
                    ->modalButton('Yes, delete'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
        ];
    }
}
