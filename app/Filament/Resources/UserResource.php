<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->rules('unique:users,email'),
                FileUpload::make('avatar')
                    ->disk('public')
                    ->directory('avatars')
                    ->image()
                    ->maxSize(2024)
                    ->nullable(),
                Select::make('gender')
                    ->required()
                    ->options([
                        'male' => 'ذكر',
                        'female' => 'أنثى',
                    ]),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->maxLength(255),
                Toggle::make('admin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->getStateUsing(function ($record) {
                        return $record->avatar
                            ? asset('storage/' . $record->avatar)
                            : ($record->gender == 'male'
                                ? asset('storage/images/gender/man.png')
                                : asset('storage/images/gender/woman.png'));
                    }),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\IconColumn::make('admin')
                    ->boolean(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit User')
                    ->modalButton('Save Changes')
                    ->using(function ($record, array $data) {
                        if (User::where('email', $data['email'])->where('id', '<>', $record->id)->exists()) {
                            throw new \Exception('This email is already taken.');
                        }
                        $record->update($data);
                    }),
                Tables\Actions\DeleteAction::make()
                    ->action(function ($record) {
                        $record->delete();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->modalHeading('Delete User')
                    ->modalSubheading('Are you sure you want to delete this User? This action cannot be undone.')
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
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
