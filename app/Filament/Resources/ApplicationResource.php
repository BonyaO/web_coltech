<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\Widgets\ApplicationChart;
use App\Filament\Resources\ApplicationResource\Widgets\ApplicationOverview;
use App\Models\Application;
use App\Models\DepartmentOption;
use App\Models\Division;
use App\Models\ExamCenter;
use App\Models\QualificationType;
use App\Models\Region;
use App\Models\SubDivision;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use ZipArchive;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    // TAB1: FINANCE
                    Wizard\Step::make('Bank receipts')
                        ->schema([
                            Forms\Components\TextInput::make('bankref')
                                ->label('Bank transaction ref number')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\FileUpload::make('bankrecipt')
                                ->label('Upload your bank payment receipt')
                                ->hint('Should not exceed 500kb')
                                ->helperText('Only PDF allowed')
                                ->preserveFilenames(true)
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->maxSize(500),
                        ])->columns(2),

                    // TAB2: PERSONAL
                    Wizard\Step::make('Personal Information')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required(),
                            Forms\Components\TextInput::make('telephone')
                                ->tel()
                                ->required(),
                            Forms\Components\TextInput::make('country')
                                ->required()
                                ->maxLength(255)
                                ->default('Cameroon'),

                            Forms\Components\Select::make('region_id')
                                ->label('Region of origin')
                                ->native(false)
                                ->searchable()
                                ->options(Region::all()->pluck('name', 'id'))
                                ->live() // This makes the field reactive
                                ->afterStateUpdated(function (callable $set) {
                                    // Clear dependent fields when region changes
                                    $set('division_id', null);
                                    $set('sub_division_id', null);
                                }),

                            Forms\Components\Select::make('division_id')
                                ->label('Division of origin')
                                ->native(false)
                                ->searchable()
                                ->options(function (callable $get) {
                                    $regionId = $get('region_id');
                                    if (!$regionId) {
                                        return [];
                                    }
                                    return Division::where('region_id', $regionId)->pluck('name', 'id');
                                })
                                ->live() // This makes the field reactive
                                ->afterStateUpdated(function (callable $set) {
                                    // Clear sub-division when division changes
                                    $set('sub_division_id', null);
                                })
                                ->disabled(fn (callable $get) => !$get('region_id')), // Disable if no region selected

                            Forms\Components\Select::make('sub_division_id')
                                ->label('Sub-division of origin')
                                ->native(false)
                                ->searchable()
                                ->options(function (callable $get) {
                                    $divisionId = $get('division_id');
                                    if (!$divisionId) {
                                        return [];
                                    }
                                    return SubDivision::where('division_id', $divisionId)->pluck('name', 'id');
                                })
                                ->disabled(fn (callable $get) => !$get('division_id')), // Disable if no division selected

                            Forms\Components\TextInput::make('idc_number')
                                ->label('ID Card number')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\Select::make('gender')
                                ->options([
                                    'male' => 'Male',
                                    'female' => 'Female',
                                ])
                                ->required()
                                ->native(false)
                                ->default('male'),

                            Forms\Components\FileUpload::make('passport')
                                ->label('Upload your 4x4 passport photograph')
                                ->hint('Should not exceed 500kb')
                                ->image()
                                ->preserveFilenames(true)
                                ->maxSize(500)
                                ->required(),

                            Forms\Components\FileUpload::make('birthcert')
                                ->label('Upload your birth certificate')
                                ->hint('Should not exceed 500kb')
                                ->acceptedFileTypes(['application/pdf'])
                                ->preserveFilenames(true)
                                ->maxSize(500)
                                ->required(),

                            Forms\Components\Select::make('marital_status')
                                ->required()
                                ->native(false)
                                ->options([
                                    'single' => 'Single',
                                    'married' => 'Married',
                                    'divorced' => 'Divorced',
                                    'widowed' => 'Widowed',
                                ]),

                            Forms\Components\Toggle::make('is_civil_servant')->label('Are you a civil servant?')
                                ->required(),
                        ])->columns(2),

                    // TAB3: GUARDIAN
                    Wizard\Step::make('Guardian Information')
                        ->schema([
                            Fieldset::make('Mother')->schema([
                                Forms\Components\TextInput::make('mother_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mother_address')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mother_contact')
                                    ->tel()
                                    ->maxLength(255),
                            ]),
                            Fieldset::make('Father')->schema([
                                Forms\Components\TextInput::make('father_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('father_address')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('father_contact')
                                    ->maxLength(255),
                            ]),
                            Fieldset::make('Guardian')->schema([
                                Forms\Components\TextInput::make('guardian_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('guardian_address')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('guardian_contact')
                                    ->maxLength(255),
                            ]),
                        ])->columns(2),

                    // TAB4: Programme information
                    Wizard\Step::make('Degree Programme')->schema([
                        Forms\Components\Select::make('option1')
                            ->label('First choice')
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->options(function () {
                                $userLevel = auth()->user()->level ?? 1;
                                if ($userLevel == 1) {
                                    return DepartmentOption::where('level', 'year_1')->pluck('name', 'id');
                                } elseif ($userLevel == 2) {
                                    return DepartmentOption::where('level', 'year_3')->pluck('name', 'id');
                                } elseif ($userLevel == 3) {
                                    return DepartmentOption::where('level', 'year_4')->pluck('name', 'id');
                                }
                            }),

                        Forms\Components\Select::make('option2')
                            ->label('Second choice')
                            ->native(false)
                            ->searchable()
                            ->options(function () {
                                $userLevel = auth()->user()->level ?? 1;
                                
                                if ($userLevel == 1) {
                                    return DepartmentOption::where('level', 'year_1')->pluck('name', 'id');
                                } elseif ($userLevel == 2) {
                                    return DepartmentOption::where('level', 'year_3')->pluck('name', 'id');
                                } elseif ($userLevel == 3) {
                                    return DepartmentOption::where('level', 'year_4')->pluck('name', 'id');
                                }
                            }),

                        Forms\Components\Select::make('option3')
                            ->label('Third choice')
                            ->native(false)
                            ->searchable()
                            ->options(function () {
                                $userLevel = auth()->user()->level ?? 1;
                                if ($userLevel == 1) {
                                    return DepartmentOption::where('level', 'year_1')->pluck('name', 'id');
                                } elseif ($userLevel == 2) {
                                    return DepartmentOption::where('level', 'year_3')->pluck('name', 'id');
                                } elseif ($userLevel == 3) {
                                    return DepartmentOption::where('level', 'year_4')->pluck('name', 'id');
                                }
                            }),
                        Forms\Components\Select::make('exam_center_id')
                            ->label('Choose your examination center')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->relationship('examCenter', 'name'),
                        Forms\Components\Radio::make('primary_language')
                            ->label('What is your primary language?')
                            ->options([
                                'en' => 'English',
                                'fr' => 'French',
                            ]),
                    ])->columns(2),

                    Wizard\Step::make('Qualifications')->schema([
                        Fieldset::make('')->label('Maths and English check')
                            ->schema([
                                Forms\Components\Radio::make('has_math')
                                    ->required()
                                    ->options([
                                        'yes' => 'Yes',
                                        'no' => 'No',
                                    ])
                                    ->label('Do you have a pass in Maths at the ordinary level'),
                                Forms\Components\Radio::make('has_english')
                                    ->required()
                                    ->options([
                                        'yes' => 'Yes',
                                        'no' => 'No',
                                    ])
                                    ->label('Do you have a pass in English at the ordinary level'),
                            ]),
                        Repeater::make('Secondary school certifcates')
                            ->relationship('qualifications')
                            ->label('Secondary school certifcates')
                            ->maxItems(3)
                            ->minItems(1)
                            // ->hidden(true) // TODO: Hide this based on application level
                            ->schema([
                                Forms\Components\TextInput::make('level')
                                    ->label('Qualification level')
                                    ->default('secondary')
                                    ->disabled()
                                    ->required(),
                                Forms\Components\Select::make('name')
                                    ->required()
                                    ->native(false)
                                    ->options(QualificationType::where('level', 'secondary')
                                        ->pluck('name')),
                                Forms\Components\TextInput::make('school')
                                    ->required(),
                                Forms\Components\TextInput::make('year')->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('points')->numeric()
                                    ->minValue(0)
                                    ->maxValue(33)
                                    ->required(),
                                Forms\Components\FileUpload::make('certificate')
                                    ->required()
                                    ->hint('Max size 500kb')
                                    ->maxSize(500)
                                    ->preserveFilenames(true)
                                    ->acceptedFileTypes(['application/pdf']),
                            ])->columns(2),

                        Repeater::make('High school certifcates')
                            ->label('High school certifcates')
                            ->relationship('qualifications')
                            ->maxItems(3)
                            ->minItems(1)
                            // ->hidden(true) // TODO: Hide this based on application level
                            ->schema([
                                Forms\Components\TextInput::make('level')
                                    ->label('Qualification level')
                                    ->default('high school')
                                    ->disabled()
                                    ->required(),
                                Forms\Components\Select::make('name')
                                    ->native(false)
                                    ->required()
                                    ->options(QualificationType::where('level', 'high school')
                                        ->pluck('name')),
                                Forms\Components\TextInput::make('school')
                                    ->required(),
                                Forms\Components\TextInput::make('year')->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('points')->numeric()
                                    ->minValue(0)
                                    ->maxValue(25)
                                    ->required(),
                                Forms\Components\FileUpload::make('certificate')
                                    ->required()
                                    ->hint('Max size 500kb')
                                    ->maxSize(500)
                                    ->preserveFilenames(true)
                                    ->acceptedFileTypes(['application/pdf']),
                            ])->columns(2),
                    ]),

                ])->columnSpanFull(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Tabs::make()
                ->tabs([
                    Infolists\Components\Tabs\Tab::make('Personal information')
                        ->schema([
                            Infolists\Components\TextEntry::make('name'),
                            Infolists\Components\TextEntry::make('email'),
                            Infolists\Components\TextEntry::make('gender'),
                            Infolists\Components\TextEntry::make('dob'),
                            Infolists\Components\TextEntry::make('pob'),
                            Infolists\Components\TextEntry::make('country'),
                            Infolists\Components\TextEntry::make('region.name'),
                            Infolists\Components\TextEntry::make('division.name'),
                            Infolists\Components\TextEntry::make('sub_division.name'),
                            Infolists\Components\TextEntry::make('address'),
                            Infolists\Components\TextEntry::make('marital_status'),
                            Infolists\Components\TextEntry::make('is_civil_servant'),
                        ])->columns(3),
                    Infolists\Components\Tabs\Tab::make('Other information')
                        ->schema([
                            Infolists\Components\TextEntry::make('father_name'),
                            Infolists\Components\TextEntry::make('father_address'),
                            Infolists\Components\TextEntry::make('father_contact'),
                            Infolists\Components\TextEntry::make('mother_name'),
                            Infolists\Components\TextEntry::make('mother_address'),
                            Infolists\Components\TextEntry::make('mother_contact'),
                            Infolists\Components\TextEntry::make('guardian_name'),
                            Infolists\Components\TextEntry::make('guardian_address'),
                            Infolists\Components\TextEntry::make('guardian_contact'),
                        ])->columns(3),
                    Infolists\Components\Tabs\Tab::make('Files')
                        ->schema([
                            Infolists\Components\ImageEntry::make('passport'),
                            Infolists\Components\TextEntry::make('father_contact'),
                            Actions::make([
                                Action::make('download')->action(function (Application $record) {
                                    $userDirectory = storage_path('app/public/'.$record->getCode());
                                    $zipPath = $userDirectory.'.zip';
                                    if (file_exists($userDirectory)) {
                                        rmdir($userDirectory);
                                        mkdir($userDirectory, 0755, true);
                                    } else {
                                        mkdir($userDirectory, 0755, true);
                                    }

                                    $getExtension = function (string $alias, string $file) {
                                        if ($file) {
                                            return "$alias.".explode('.', $file)[1];
                                        }

                                        return '';
                                    };

                                    $zip = new ZipArchive;
                                    $addFile = function (string $file) use ($zip, $getExtension, $record) {
                                        if ($file) {
                                            $zip->addFile(public_path('/storage/'.$record[$file]), $getExtension($file, $record[$file]));
                                        }
                                    };
                                    if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
                                        $addFile('birthcert');
                                        $addFile('passport');
                                        $addFile('bankrecipt');
                                        foreach ($record->qualifications as $qualification) {
                                            $zip->addFile(
                                                public_path('/storage/'.$qualification->certificate),
                                                $getExtension(str_replace('/', '', $qualification->qualificationType->name), $qualification->certificate)
                                            );
                                        }
                                        $zip->close();
                                    }

                                    return response()->download($zipPath);
                                }),
                            ]),
                        ])->columns(3),
                ])->columnSpanFull(),
        ]);
    }

    public function downloadFiles()
    {
        return null;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('passport')->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('option1')
                    ->formatStateUsing(fn (string $state) => DepartmentOption::find($state)?->name ?? 'N/A')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('option2')
                    ->formatStateUsing(fn (string $state) => DepartmentOption::find($state)?->name ?? 'N/A')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('option3')
                    ->formatStateUsing(fn (string $state) => DepartmentOption::find($state)?->name ?? 'N/A')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('admitted_on')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('exam_center_id')
                    ->label('Exam centers')
                    ->options(fn (): array => ExamCenter::query()->pluck('name', 'id')->all()
                    ),
            ])
            ->actions([
                Tables\Actions\Action::make('Admit')
                    ->visible(fn (Application $record) => ! isset($record->admitted_on))
                    ->action(function (Application $record) {
                        $record->admitted_on = \Carbon\Carbon::now();
                        $record->save();

                        Notification::make()
                            ->title('Student has been admitted')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exports([
                            ExcelExport::make()->withColumns([
                                Column::make('name')->heading('Name'),
                                Column::make('dob')->heading('Date of birth'),
                                Column::make('pob')->heading('Place of birth'),
                                Column::make('gender')->heading('Gender'),
                                Column::make('email')->heading('Institutional Email'),
                                Column::make('address')->heading('Address'),
                                Column::make('option1')->heading('First Choice'),
                                Column::make('option2')->heading('Second Choice'),
                                Column::make('option3')->heading('Third Choice'),
                                Column::make('guardian_name')->heading('Guardian Name'),
                                Column::make('guardian_address')->heading('Guardian Address'),
                                Column::make('guardian_contact')->heading('Guardian Contact'),
                                Column::make('father_name')->heading('Father Name'),
                                Column::make('father_address')->heading('Father Address'),
                                Column::make('father_contact')->heading('Father Contact'),
                                Column::make('mother_name')->heading('Mother Name'),
                                Column::make('mother_address')->heading('Mother Address'),
                                Column::make('mother_contact')->heading('Mother Contact'),
                                Column::make('telephone')->heading('Phone number'),
                                Column::make('idc_number')->heading('NID/Passport'),
                                Column::make('country')->heading('Nationality'),
                                Column::make('region.name')->heading('Region/State'),
                                Column::make('division.name')->heading('Division'),
                                Column::make('sub_division.name')->heading('Sub-Division'),
                                Column::make('primary_language')->heading('Primary Language'),
                                Column::make('has_math')->heading('Has Maths'),
                                Column::make('has_english')->heading('Has English'),
                                Column::make('admitted_on')->format('d/m/Y')->heading('Admitted On'),
                            ]),
                            ]),
                            // ->modifyQueryUsing(fn ($query) => $query->whereNotNull('admitted_on')),
                        ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ApplicationOverview::class,
            ApplicationChart::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'view' => Pages\ViewApplication::route('/{record}'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
