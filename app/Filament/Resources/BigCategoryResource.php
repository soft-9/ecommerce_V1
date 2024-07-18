<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BigCategoryResource\Pages;
use App\Models\BigCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class BigCategoryResource extends Resource
{
    protected static ?string $model = BigCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    protected static ?string $navigationLabel = 'bigCategory';
    protected static ?string $breadcrumb = 'bigCategory';
    protected static ?string $title = 'bigCategory';
    protected static ?string $slug = 'bigCategory';
    protected static ?string $navigationGroup = 'Category';
    protected static ?int $navigationSort = 0 ;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_en')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_ar')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('avatar')
                    ->disk('public')
                    ->directory('bigcategory')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_en')
                    ->searchable(),
                TextColumn::make('name_ar')
                    ->searchable(),
                ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Big Category')
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
                    ->modalHeading('Delete Big Category')
                    ->modalSubheading('Are you sure you want to delete this Big Category? This action cannot be undone.')
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
            'index' => Pages\ListBigCategories::route('/'),
        ];
    }
}

