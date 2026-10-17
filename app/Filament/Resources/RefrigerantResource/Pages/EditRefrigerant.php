<?php

namespace App\Filament\Resources\RefrigerantResource\Pages;

use App\Filament\Resources\RefrigerantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefrigerant extends EditRecord
{
    protected static string $resource = RefrigerantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
