<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Selamat datang, {{ auth()->user()->name }}!
        </h2>
    </x-slot>

    <div class="sm:px-4 pb-10">
        <div class="grid grid-cols-2 lg:grid-cols-6 gap-6">
            <div class="col-span-2 space-y-4">
                <x-layout.user-card />
                <x-absence-card />
                <livewire:components.paycheck-card />
            </div>
            <div class="col-span-2 lg:col-span-4 space-y-4">
                <livewire:components.absence-history />
                <livewire:components.cashflow-history />
            </div>
        </div>
    </div>
</x-app-layout>
