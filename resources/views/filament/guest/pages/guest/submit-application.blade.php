<x-filament-panels::page>
    @if (auth()->user()->payment)
        @if (auth()->user()->payment->status == 'PENDING')
            <x-filament::button wire:click="validatePayment">
                Validate
            </x-filament::button>
            <x-filament::button color="danger" wire:click="cancelPayment">
                Cancel
            </x-filament::button>
        @elseif (auth()->user()->payment->status == 'FAILED')
            <div class="border border-gray-400 rounded-lg p-4 space-y-4 text-center">
                <h3 class="text-2xl font-semibold text-orange-600">Oops!! An error occured</h3>
                <p>Your payment has failed or it was cancelled</p>
                <x-filament::button color="warning" tag="a" href="/guest/process-payment">
                    Try again
                </x-filament::button>
            </div>
        @else
            <div x-data="{ activeTab: 1 }">
                <x-filament::tabs label="Application tabs" class="mb-4">
                    <x-filament::tabs.item alpine-active="activeTab == 1" @click="activeTab = 1">
                        Basic student information
                    </x-filament::tabs.item>

                    <x-filament::tabs.item alpine-active="activeTab == 2" @click="activeTab = 2">
                        Qualifications
                    </x-filament::tabs.item>

                    @if (auth()->user()->level > 1)
                        <x-filament::tabs.item alpine-active="activeTab == 3" @click="activeTab = 3">
                            Work Experience
                        </x-filament::tabs.item>
                    @endif

                </x-filament::tabs>

                <div x-show="activeTab == 1">
                    @livewire('application-form')
                </div>

                <div x-show="activeTab == 2">
                    @livewire('qualification-form')
                </div>
                
                @if (auth()->user()->level > 1)
                    <div x-show="activeTab == 3">
                        @livewire('work-experience-form')
                    </div> 
                @endif
            </div>
        @endif
    @else
        <x-filament::button tag="a" href="/guest/process-payment">
            Make payment
        </x-filament::button>
    @endif
</x-filament-panels::page>
