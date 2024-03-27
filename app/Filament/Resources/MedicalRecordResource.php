<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalRecordResource\Pages;
use App\Models\MedicalRecord;
use App\Models\Pet;
use App\Models\Specie;
use App\Models\User;
use App\Rules\AlphaSpace;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class MedicalRecordResource extends Resource
{
    protected static ?string $model = MedicalRecord::class;

    protected static ?string $navigationIcon = 'bi-journal-medical';

    public static function form(Form $form): Form
    {
        $appointmentId = request()->query('appointment_id');

        return $form
            ->schema([
                Split::make([
                    Section::make([
                        RichEditor::make('prescription')->disableToolbarButtons([
                            'attachFiles',
                        ]),
                    ]),
                    Section::make([
                        Select::make('pet_id')
                            ->relationship('pet', 'name')
                            ->required()->exists(Pet::class, 'id')
                            ->searchable()->preload()
                            ->createOptionForm([
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
                            ]),
                        TextInput::make('weight')->numeric()->suffix('kg'),
                        FileUpload::make('attachments')
                            ->directory('prescriptions')
                            ->multiple()->preserveFilenames()->previewable(false)->openable()->reorderable()->appendFiles()->downloadable(),
                        Hidden::make('appointment_id')->default($appointmentId),
                    ])->grow(false),
                ])->from('sm')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pet.name')->searchable(),
                TextColumn::make('prescription')->html()
                    ->wrap()->limit(50),
                TextColumn::make('weight'),
                TextColumn::make('created_at'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                ViewAction::make(),
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
            'index' => Pages\ListMedicalRecords::route('/'),
            'create' => Pages\CreateMedicalRecord::route('/create'),
        ];
    }
}
