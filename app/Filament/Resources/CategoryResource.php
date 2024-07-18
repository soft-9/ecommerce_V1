<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
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

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox';


    protected static ?string $navigationLabel = 'Category';
    protected static ?string $breadcrumb = 'Category';
    protected static ?string $title = 'Category';
    protected static ?string $slug = 'category';
    protected static ?string $navigationGroup = 'Category';
    protected static ?int $navigationSort = 0 ;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Select::make('big_category_id')
              ->relationship('bigCategory', 'name_en')->required(),
          TextInput::make('name_en')->required(),
          TextInput::make('name_ar')->required(),
          FileUpload::make('avatar')
              ->disk('public')
              ->directory('categories')
              ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              TextColumn::make('bigCategory.name_en')->label('Big Category')->sortable(),
              TextColumn::make('name_en')->sortable()->searchable(),
              TextColumn::make('name_ar')->sortable()->searchable(),
              ImageColumn::make('avatar')
                  ->label('Avatar')
                  ->getStateUsing(function ($record) {
                      return $record->avatar ? asset('/storage/' . $record->avatar) : null;
                  })
                  ->sortable(),
              TextColumn::make('creator.name')->label('Created By')->sortable(),
              TextColumn::make('updater.name')->label('Updated By')->sortable(),
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
              ->modalHeading('Edit Category')
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
              ->modalHeading('Delete Category')
              ->modalSubheading('Are you sure you want to delete this Category? This action cannot be undone.')
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
            'index' => Pages\ListCategories::route('/'),
        ];
    }
}
