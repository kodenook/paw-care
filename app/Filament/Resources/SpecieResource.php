<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecieResource\Pages;
use App\Filament\Resources\SpecieResource\RelationManagers\PetsRelationManager;
use App\Models\Specie;
use App\Rules\AlphaSpace;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SpecieResource extends Resource
{
    protected static ?string $model = Specie::class;

    protected static ?string $navigationIcon = 'fluentui-animal-cat-20-o';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->required()->maxLength(100)->unique(ignoreRecord: true)->rules([new AlphaSpace()]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
            ])
            ->defaultSort('name')
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PetsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecies::route('/'),
            'create' => Pages\CreateSpecie::route('/create'),
            'edit' => Pages\EditSpecie::route('/{record}/edit'),
        ];
    }
}
