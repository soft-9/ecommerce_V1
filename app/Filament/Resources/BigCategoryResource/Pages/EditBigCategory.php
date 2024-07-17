<?php

namespace App\Filament\Resources\BigCategoryResource\Pages;

use App\Filament\Resources\BigCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBigCategory extends EditRecord
{
    protected static string $resource = BigCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
