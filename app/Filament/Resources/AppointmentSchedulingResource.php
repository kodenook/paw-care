<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentSchedulingResource\Pages;
use App\Models\AppointmentScheduling;
use App\Rules\AlphaSpace;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class AppointmentSchedulingResource extends Resource
{
    protected static ?string $model = AppointmentScheduling::class;

    protected static ?string $navigationIcon = 'sui-calendar-date';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('owner and date')
                        ->schema([
                            TextInput::make('owner_name')
                                ->autofocus()
                                ->required()->rules([new AlphaSpace()])->maxLength(50),
                            TextInput::make('owner_email')
                                ->required()->maxLength(255)->email()
                                ->prefixIcon('heroicon-m-envelope'),
                            TextInput::make('owner_phone')
                                ->autofocus()
                                ->required()->maxLength(17)->tel()
                                ->prefixIcon('heroicon-m-phone'),
                            DatePicker::make('date')
                                ->native(false)->closeOnDateSelection()->disabledDates(function (): array {
                                    return DB::table('appointment_scheduling')
                                        ->groupBy('date')
                                        ->havingRaw('COUNT(DISTINCT CASE WHEN TIME_FORMAT(`time`, "%H:%i") IN
                                    ("9:00", "9:30", "10:00", "10:30", "11:00",
                                    "11:30", "12:00", "12:30", "13:00", "13:30",
                                    "14:00", "14:30", "15:00", "15:30", "16:00", "16:30",
                                    "17:00", "17:30")
                                    THEN TIME_FORMAT(`time`, "%H:%i") END) = 18')
                                        ->pluck('date')
                                        ->toArray();
                                })
                                ->prefixIcon('uiw-date')
                                ->live()
                                ->columnStart(1),
                            Radio::make('time')
                                ->options([
                                    '9:00' => '9:00',
                                    '9:30' => '9:30',
                                    '10:00' => '10:00',
                                    '10:30' => '10:30',
                                    '11:00' => '11:00',
                                    '11:30' => '11:30',
                                    '12:00' => '12:00',
                                    '12:30' => '12:30',
                                    '13:00' => '13:00',
                                    '13:30' => '13:30',
                                    '14:00' => '14:00',
                                    '14:30' => '14:30',
                                    '15:00' => '15:00',
                                    '15:30' => '15:30',
                                    '16:00' => '16:00',
                                    '16:30' => '16:30',
                                    '17:00' => '17:00',
                                    '17:30' => '17:30',
                                ])->inline()->inlineLabel(false)
                                ->disableOptionWhen(function (string $value, Get $get): bool {
                                    $result = DB::table('appointment_scheduling')
                                        ->whereRaw('CASE WHEN time = ? and date = ? THEN 1 ELSE 0 END', [$value, $get('date')])
                                        ->exists();

                                    return $result;
                                }),
                        ])->columns(),
                    Wizard\Step::make('Patient Information')
                        ->schema([
                            TextInput::make('pet_name')
                                ->label('name')
                                ->helperText('Your pet name here.')
                                ->autofocus()
                                ->required()->rules([new AlphaSpace()])->maxLength(50),
                            RichEditor::make('reason')
                                ->label('Reason For Consultation')
                                ->autofocus()
                                ->required()->maxLength(1000),
                        ]),
                    Wizard\Step::make('Confirm')
                        ->schema([
                            TextInput::make('owner_name')->disabled(),
                            TextInput::make('owner_email')->disabled(),
                            TextInput::make('owner_phone')->disabled(),
                            TextInput::make('pet_name')->disabled(),
                            TextInput::make('date')->disabled(),
                            TextInput::make('time')->disabled(),
                            RichEditor::make('reason')->disabled(),
                            Hidden::make('pet_name'),
                            Hidden::make('owner_name'),
                            Hidden::make('owner_email'),
                            Hidden::make('owner_phone'),
                            Hidden::make('date'),
                            Hidden::make('reason'),
                            Hidden::make('time'),
                        ])->columns(2),
                ])->columnSpanFull(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Split::make([
                    Section::make([
                        TextEntry::make('pet_name')
                            ->weight(FontWeight::Bold)
                            ->badge()->color('primary'),
                        TextEntry::make('reason')
                            ->label('Reason For Consultation')->html()->prose(),
                    ]),
                    Tabs::make('Tabs')
                        ->tabs([
                            Tabs\Tab::make('Appointment Details')
                                ->schema([
                                    TextEntry::make('date')
                                        ->date()
                                        ->badge()->color('primary'),
                                    TextEntry::make('time')
                                        ->time()
                                        ->badge()->color('primary'),
                                    TextEntry::make('created_at')
                                        ->dateTime()
                                        ->badge()->color('primary'),
                                ])->columns(2),
                            Tabs\Tab::make('Contact Details')
                                ->schema([
                                    TextEntry::make('owner_name')
                                        ->badge()->color('primary'),
                                    TextEntry::make('owner_email')
                                        ->icon('heroicon-o-envelope')
                                        ->copyable()
                                        ->badge()->color('primary'),
                                    TextEntry::make('owner_phone')
                                        ->icon('heroicon-o-phone')
                                        ->badge()->color('primary')
                                        ->formatStateUsing(fn (string $state): string => '+'.trim(strrev(chunk_split(strrev($state), 4, ' ')))),
                                ]),
                        ])
                        ->activeTab(1)
                        ->grow(false),
                ])->from('sm')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pet_name')
                    ->searchable(),
                TextColumn::make('owner_name')
                    ->searchable(),
                TextColumn::make('date'),
                TextColumn::make('time'),
                TextColumn::make('owner_email')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('owner_phone')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn (string $state): string => '+'.trim(strrev(chunk_split(strrev($state), 4, ' ')))),
                TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort(function ($query) {
                $query->select('id', 'pet_name', 'owner_name', 'date', 'time', 'owner_email', 'owner_phone', 'created_at', 'deleted_at');
                $query->orderBy('created_at', 'desc');
            })
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('add medical record')
                    ->url(fn (AppointmentScheduling $record): string => route('filament.admin.resources.medical-records.create', ['appointment_id' => $record->id]))
                    ->visible(fn (AppointmentScheduling $record): bool => ! empty($record->medicalRecord()->getResults()) && Carbon::parse($record->date)->format('Y-m-d') === now()->format('Y-m-d')),
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
            'index' => Pages\ListAppointmentScheduling::route('/'),
            'create' => Pages\CreateAppointmentScheduling::route('/create'),
            'view' => Pages\ViewAppointmentScheduling::route('/{record}'),
            'edit' => Pages\EditAppointmentScheduling::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
