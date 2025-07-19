<?php

namespace App\Filament\Guest\Pages\Guest;

use Filament\Pages\Page;

class ProcessPayment extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static string $view = 'filament.guest.pages.guest.process-payment';
}
