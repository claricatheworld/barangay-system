<?php

namespace App\Filament\Official\Resources\Residents\Pages;

use App\Filament\Official\Resources\Residents\ResidentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewResident extends ViewRecord
{
    protected static string $resource = ResidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
