<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->autofocus()
                    ->required()->alpha()->maxLength(20)
                    ->disabled(function ($record) {
                        return strtolower($record?->first_name) === 'admin';
                    }),
                TextInput::make('last_name')
                    ->autofocus()
                    ->required()->alpha()->maxLength(20)
                    ->disabled(function ($record) {
                        return strtolower($record?->first_name) === 'admin';
                    }),
                TextInput::make('email')
                    ->autofocus()
                    ->required()->maxLength(255)->email()->unique(ignoreRecord: true)
                    ->prefixIcon('heroicon-m-envelope'),
                TextInput::make('phone')
                    ->autofocus()
                    ->required()->maxLength(15)->tel()
                    ->prefixIcon('heroicon-m-phone'),
                $this->getPasswordFormComponent()
                    ->autofocus()
                    ->nullable()->minLength(8)->maxLength(255)
                    ->prefixIcon('heroicon-m-key'),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
