<div>
    @if (auth()->user()->application)
        {{-- @if (!auth()->user()->application->validated_on)
            <form wire:submit="create">
                {{ $this->form }}

                <x-filament::button type="sumbit" style="margin: 1rem 0 4rem;">
                    Submit qualifications
                </x-filament::button>
            </form>
        @endif --}}

        {{ $this->table }}

        <x-filament-actions::modals />
    @else
        <p>After submitting your application you should be able to load your certificates</p>
    @endif
</div>
