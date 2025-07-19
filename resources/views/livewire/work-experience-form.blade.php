<div>
    @if (auth()->user()->application)
        {{ $this->table }}

        <x-filament-actions::modals />
    @else
        <p>After submitting your application you should be able to add internship/work experience.</p>
    @endif
</div>
