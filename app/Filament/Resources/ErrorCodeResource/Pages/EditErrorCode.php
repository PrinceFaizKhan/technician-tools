<?php

namespace App\Filament\Resources\ErrorCodeResource\Pages;

use App\Filament\Resources\ErrorCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditErrorCode extends EditRecord
{
    protected static string $resource = ErrorCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
