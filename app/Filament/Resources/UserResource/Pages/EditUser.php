<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        $response = [];

        /* This code snippet is checking if the current user is not trying to edit the user with ID 1
        (Admin) and is not the same user as the one being edited. If these conditions are met, it adds
        a delete action to the header actions array. This logic is used to determine whether to
        display the delete action for the user being edited, excluding the user with ID 1 and the
        user themselves. */
        if ($this->record->id != 1 && Auth::Id() !== $this->record->id) {
            array_push(
                $response,
                Actions\DeleteAction::make()
            );
        }

        return $response;
    }
}
