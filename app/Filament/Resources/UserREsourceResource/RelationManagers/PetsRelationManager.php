<?php

namespace App\Filament\Resources\UserREsourceResource\RelationManagers;

use App\Models\Specie;
use App\Rules\AlphaSpace;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PetsRelationManager extends RelationManager
{
    protected static string $relationship = 'Pets';

    public function form(Form $form): Form
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('specie.name'),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('specie')
                    ->relationship('specie', 'name')
                    ->searchable()->preload()->multiple(),
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
