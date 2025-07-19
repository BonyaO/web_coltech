<?php

namespace App\Filament\Guest\Pages;

use Filament\Forms\Components\Select;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        Select::make('level')
                            ->native(false)
                            ->label('What level are you applying for?')
                            ->options([
                                1 => 'Year 1',
                                2 => 'Year 3',
                                3 => 'Year 4',
                            ])
                            ->default(1)
                            ->required(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
}
