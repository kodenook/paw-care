<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PetResource\Pages;
use App\Filament\Resources\PetResource\RelationManagers\MedicalRecordRelationManager;
use App\Models\Pet;
use App\Models\Specie;
use App\Models\User;
use App\Rules\AlphaSpace;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;

    protected static ?string $navigationIcon = 'tni-paw-o';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->required()->maxLength(50)->rules([new AlphaSpace()]),
                Select::make('specie_id')
                    ->relationship('specie', 'name')
                    ->required()->exists(Specie::class, 'id')
                    ->searchable()->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->autofocus()
                            ->required()->maxLength(100)->unique(ignoreRecord: true)->rules([new AlphaSpace()]),
                    ])
                    ->editOptionForm([
                        TextInput::make('name')
                            ->autofocus()
                            ->required()->maxLength(100)->unique(ignoreRecord: true)->rules([new AlphaSpace()]),
                    ]),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('specie.name'),
                TextColumn::make('user.full_name')
                    ->label('Owner')
                    ->searchable(['first_name', 'last_name']),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('specie')
                    ->relationship('specie', 'name')
                    ->searchable()->preload()->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MedicalRecordRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }
}
