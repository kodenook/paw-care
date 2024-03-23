<?php

namespace App\Filament\Resources\AppointmentSchedulingResource\Pages;

use App\Filament\Resources\AppointmentSchedulingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppointmentScheduling extends ListRecords
{
    protected static string $resource = AppointmentSchedulingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
