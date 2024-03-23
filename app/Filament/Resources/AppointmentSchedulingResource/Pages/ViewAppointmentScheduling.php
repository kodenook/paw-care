<?php

namespace App\Filament\Resources\AppointmentSchedulingResource\Pages;

use App\Filament\Resources\AppointmentSchedulingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAppointmentScheduling extends ViewRecord
{
    protected static string $resource = AppointmentSchedulingResource::class;

    protected function getHeaderActions(): array
    {
        $response = [];

        if ($this->record->deleted_at === null && $this->record->date > now()) {
            array_push(
                $response,
                Actions\EditAction::make(),
                Actions\DeleteAction::make()
                    ->label('Cancel Appointment')
            );
        }

        return $response;
    }
}
