<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
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
                    ->required()->maxLength(17)->tel()
                    ->prefixIcon('heroicon-m-phone'),
                TextInput::make('password')
                    ->autofocus()
                    ->nullable()->minLength(8)->maxLength(255)->password()
                    ->prefixIcon('heroicon-m-key'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('email')
                    ->copyable()
                    ->Icon('heroicon-o-envelope'),
                TextColumn::make('phone')
                    ->icon('heroicon-o-phone')
                    ->formatStateUsing(fn (string $state): string => '+'.trim(strrev(chunk_split(strrev($state), 4, ' ')))),
            ])
            ->defaultSort(function ($query) {
                $query->select('id', 'first_name', 'last_name', 'email', 'phone');
                $query->addSelect(DB::raw('concat(first_name, " ", last_name) as full_name'));
                $query->orderBy('full_name');
            })
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (strtolower($data['first_name']) === 'admin') {
            $data['first_name'] = 'admin';
            $data['last_name'] = '';
        }

        return $data;
    }
}
