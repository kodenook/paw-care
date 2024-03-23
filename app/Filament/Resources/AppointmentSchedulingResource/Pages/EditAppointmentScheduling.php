<?php

namespace App\Filament\Resources\AppointmentSchedulingResource\Pages;

use App\Filament\Resources\AppointmentSchedulingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppointmentScheduling extends EditRecord
{
    protected static string $resource = AppointmentSchedulingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Cancel Appointment'),
        ];
    }
}
