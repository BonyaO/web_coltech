<?php

namespace App\Livewire;

use App\Models\Qualification;
use App\Models\QualificationType;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class QualificationForm extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Qualification $qualification;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Repeater::make('Your certificate')
                ->label('Your certificates')
                ->maxItems(3)
                ->minItems(1)
                ->schema([
                    ...$this->formFields(),
                ])->columns(2),
        ])->statePath('data')
            ->model(Qualification::class);
    }

    public function formFields()
    {
        return [
            Forms\Components\TextInput::make('level')
                ->default('test')
                ->hidden(),
            Forms\Components\TextInput::make('application_id')
                ->default(auth()->user()->application->id ?? '')
                ->hidden(),
            Forms\Components\Select::make('qualification_type_id')
                ->label('Level')
                ->native(false)
                ->required()
                ->options(function () {
                    $appLevel = auth()->user()->application?->level; // 0, 1, 2
                    // if 0 then sec and high school
                    if ($appLevel == 0) {
                        return QualificationType::where('level', 'secondary school')
                            ->orWhere('level', 'high school')
                            ->pluck('name', 'id');
                    } else {
                        return QualificationType::where('level', QualificationType::$levels[$appLevel])
                            ->pluck('name', 'id');
                    }
                }),
            Forms\Components\TextInput::make('school')
                ->required(),
            Forms\Components\TextInput::make('year')
                ->placeholder('E.g: 2020')
                ->required(),
            Forms\Components\TextInput::make('points')->numeric()
                ->minValue(0)
                ->maxValue(25)
                ->required(),
            Forms\Components\FileUpload::make('certificate')
                ->required()
                ->hint('Max size 500kb')
                ->maxSize(500)
                ->acceptedFileTypes(['application/pdf']),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Qualification::query()
                    ->where(
                        'application_id',
                        auth()->user()->application?->id
                    )
            )
            ->columns([
                // TextColumn::make('qualificationType.level')->label('Level'),
                TextColumn::make('school'),
                TextColumn::make('qualificationType.name'),
                TextColumn::make('year'),
                TextColumn::make('points'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form($this->formFields())
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        $data['application_id'] = auth()->user()->application->id;
                        return $data;
                    }),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make()
                    ->visible(isset(auth()->user()->application->validated_on))
                    ->form($this->formFields()),
                \Filament\Tables\Actions\DeleteAction::make()
                    ->visible(isset(auth()->user()->application->validated_on))
                    ->action(function (Qualification $record) {
                        Storage::delete($record->certificate);
                        $record->delete();
                        Notification::make()
                            ->title('Record has been removed')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public function create(): void
    {
        $qualifications = array_values($this->form->getState());
        foreach ($qualifications as $value) {
            Qualification::create([
                ...$value[0],
            ]);
        }
        Notification::make()
            ->title('Your qualifications have been added')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.qualification-form');
    }
}
