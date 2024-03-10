<?php

namespace App\Filament\Resources\SpecieResource\RelationManagers;

use App\Models\User;
use App\Rules\AlphaSpace;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class PetsRelationManager extends RelationManager
{
    protected static string $relationship = 'pets';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->required()->maxLength(50)->rules([new AlphaSpace()]),
                Select::make('user_id')
                    ->label('Owner')
                    ->relationship('user', 'full_name', function ($query) {
                        $query->select('id', 'first_name', 'last_name', 'email', 'phone');
                        $query->addSelect(DB::raw('concat(first_name, " ", last_name) as full_name'));
                        $query->orderBy('full_name');
                        $query->whereNot('id', 1);
                    })
                    ->exists(User::class, 'id')
                    ->searchable()->preload()
                    ->createOptionForm([
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
                    ])
                    ->editOptionForm([
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
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('user.full_name')
                    ->label('Owner')
                    ->searchable(['first_name', 'last_name']),
            ])
            ->defaultSort('name')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
