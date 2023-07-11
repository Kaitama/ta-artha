<div>
    <x-card>
        <x-slot name="title">Slip Gaji</x-slot>
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="col-span-2">
                <x-select wire:model="month">
                    @foreach($months as $i => $bulan)
                        <option value="{{ $i }}">{{ $bulan }}</option>
                    @endforeach
                </x-select>
            </div>
            <x-input type="number" wire:model="year" />
        </div>
        @if($paycheck)
            <div>
                <div class="flex items-center justify-between mb-6">
                    <span class="font-normal text-gray-600">Total gaji {{ $months[$month] }} {{ $year }}</span>
                    <span class="font-bold">Rp. {{ \App\Helpers\Rupiah::format($paycheck->salary) }}</span>
                </div>
                <x-button type="button" color="primary" wire:click="downloadPaycheck" class="w-full">Unduh slip gaji</x-button>
            </div>
        @else
            <div class="text-center">
                <x-empty-row />
            </div>
        @endif
    </x-card>
</div>
