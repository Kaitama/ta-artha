<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
                <a class="text-blue-600" href="{{ route('roles.index') }}">Jabatan</a> / Buat baru
            </h2>
        </div>
    </x-slot>

    <div class="sm:mx-4">
        <x-form-section submit="store">
            <x-slot name="title"></x-slot>
            <x-slot name="description"></x-slot>

            <x-slot name="form">
                <div class="col-span-4">
                    <x-label :required="true">Nama Jabatan</x-label>
                    <x-input type="text" wire:model.defer="nama_jabatan" autofocus />
                    <x-input-error for="nama_jabatan" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Potongan Absensi</x-label>
                    <x-input type="number" wire:model.defer="potongan_absensi" />
                    <x-input-error for="potongan_absensi" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Travel</x-label>
                    <x-input type="number" wire:model.defer="travel" />
                    <x-input-error for="travel" />
                </div>
                <div class="col-span-4">
                    <x-label>Gaji Pokok</x-label>
                    <x-input type="number" wire:model.defer="gaji_pokok" />
                    <x-input-error for="gaji_pokok" />
                </div>
                <div class="col-span-4">
                    <x-label>Rate</x-label>
                    <x-input type="number" wire:model.defer="rate" />
                    <x-input-error for="rate" />
                </div>
                <div class="col-span-4">
                    <x-label>Tunjangan Jabatan</x-label>
                    <x-input type="number" wire:model.defer="tunjangan" />
                    <x-input-error for="tunjangan" />
                </div>
                <div class="col-span-4">
                    <x-label>Maksimal Pinjaman/Bulan</x-label>
                    <x-input type="number" wire:model.defer="limit" />
                    <x-input-error for="limit" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-button color="primary">Simpan</x-button>
            </x-slot>
        </x-form-section>
    </div>

</div>
