<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
                <a class="text-blue-600" href="{{ route('cashflows.index') }}">Pengeluaran</a> / Ubah
            </h2>
        </div>
    </x-slot>

    <div class="sm:mx-4">
        <x-form-section submit="update">
            <x-slot name="title"></x-slot>
            <x-slot name="description"></x-slot>

            <x-slot name="form">
                <div class="col-span-4">
                    <x-label :required="true">Tanggal</x-label>
                    <x-input type="date" wire:model="cashflow.saved_at" />
                    <x-input-error for="cashflow.saved_at" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Nama Pegawai</x-label>
                    <x-input type="text" wire:model.defer="pegawai" :disabled="true" />
                    <span class="text-xs text-gray-400">Pegawai tidak dapat diubah.</span>
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Tipe Pengeluaran</x-label>
                    <x-select wire:model.defer="cashflow.type">
                        @foreach($types as $i => $type)
                            <option value="{{ $i }}">{{ $type }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="cashflow.type" />
                </div>
                <div class="col-span-4">
                    <x-label>Sisa limit yang dapat digunakan pada bulan ini</x-label>
                    @if($limit_pinjaman)
                        <div class="font-bold text-gray-600">{{ \App\Helpers\Rupiah::format($limit_pinjaman) }}</div>
                    @else
                        <div class="text-gray-600">~</div>
                    @endif
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Nominal</x-label>
                    <x-input type="number" wire:model.defer="cashflow.nominal" />
                    <x-input-error for="cashflow.nominal" />
                </div>
                <div class="col-span-4">
                    <x-label>Keterangan</x-label>
                    <x-textarea wire:model.defer="cashflow.description" />
                    <x-input-error for="cashflow.description" />
                </div>


            </x-slot>
            <x-slot name="actions">
                <x-button color="primary">Ubah</x-button>
            </x-slot>
        </x-form-section>
    </div>
</div>
