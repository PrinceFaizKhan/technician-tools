<?php

namespace App\Filament\Resources\ErrorCodeResource\Pages;

use App\Filament\Resources\ErrorCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListErrorCodes extends ListRecords
{
    protected static string $resource = ErrorCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
