<?php

namespace App\Filament\Resources\BigCategoryResource\Pages;

use App\Filament\Resources\BigCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBigCategories extends ListRecords
{
    protected static string $resource = BigCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
