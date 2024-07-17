<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Color;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\RichEditor;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              TextInput::make('title_en')->required(),
              TextInput::make('title_ar')->required(),
                TextInput::make('name_en')->required(),
                TextInput::make('name_ar')->required(),
                RichEditor::make('description_en')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'link', 'bulletList', 'orderedList',
                        'blockquote', 'codeBlock',
                    ])->required(),
                RichEditor::make('description_ar')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'link', 'bulletList', 'orderedList',
                        'blockquote', 'codeBlock',
                    ])->required(),
                FileUpload::make('avatar_main')->required(),
                FileUpload::make('avatar_details')
                    ->multiple()
                    ->required(),
                TextInput::make('price_before_discount'),
                TextInput::make('price')->required(),
                TextInput::make('quantity'),
                Select::make('category_id')
                    ->relationship('category', 'name_en')->required(),
                MultiSelect::make('colors')
                    ->relationship('colors', 'name')
                    ->options(Color::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title_en')->sortable()->searchable(),
                TextColumn::make('title_ar')->sortable()->searchable(),
                TextColumn::make('name_en')->sortable()->searchable(),
                TextColumn::make('name_ar')->sortable()->searchable(),
                TextColumn::make('description_en')->limit(50),
                TextColumn::make('description_ar')->limit(50),
                ImageColumn::make('avatar_main')->label('Avatar')->sortable(),
                TextColumn::make('price')->sortable(),
                TextColumn::make('category.name_en')->label('Category')->sortable(),
                TextColumn::make('colors.name')
                    ->label('Colors')
                    ->formatStateUsing(function ($state) {
                        return collect($state)->map(function ($color) {
                            return "<span style='background-color: {$color}; padding: 2px 5px; color: white;'>{$color}</span>";
                        })->implode(', ');
                    })
                    ->html(),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
