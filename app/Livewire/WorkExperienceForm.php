<?php

namespace App\Livewire;

use App\Models\WorkExperience;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class WorkExperienceForm extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public WorkExperience $workExperience;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make("organization"),
                TextColumn::make('role'),
                TextColumn::make('start_date')->date(),
                TextColumn::make('end_date')->date()->default(now()),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form($this->formFields())
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        return $data;
                    }),
            ])
            ->emptyStateHeading('No internship/work experience')
            ->emptyStateDescription('Start adding your internship/work experience.')
            ->actions([
                EditAction::make()
                    ->form($this->formFields()),
                DeleteAction::make(),
            ]);
    }

    public function getTableQuery(): Builder
    {
        return WorkExperience::query()->where('user_id', auth()->id());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('Your internship/work experience')
                    ->schema([...$this->formFields()])
            ])
            ->statePath('data')
            ->model(WorkExperience::class);
    }

    public function formFields()
    {
        return [
            TextInput::make('organization')
                ->label('Organization or company')
                ->required(),
            TextInput::make('role')->required(),
            DatePicker::make('start_date')
                ->maxDate(now())
                ->native(false)
                ->required(),
            DatePicker::make("end_date")
                ->maxDate(now())
                ->placeholder("You can leave empty if you're still working here")
                ->native(false)
                ->nullable()
                ->helperText("When empty, it defaults to present"),
            Textarea::make("description")
                ->label("Work description")
                ->nullable()
        ];
    }

    public function create(): void
    {
        $experiences = array_values($this->form->getState());
        $collection = collect($experiences);
        $values = collect($collection->values()->first());
        $values->map(function ($value) {
            $value['user_id'] = auth()->id();
            WorkExperience::create($value);
        });

        Notification::make()
            ->title('Your internship/work experience(s) have been added')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.work-experience-form');
    }
}
