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
                    <x-input type="text" wire:model="nama_jabatan" autofocus />
                    <x-input-error for="nama_jabatan" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Potongan Absensi</x-label>
                    <x-input type="number" wire:model="potongan_absensi" />
                    <x-input-error for="potongan_absensi" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Travel</x-label>
                    <x-input type="number" wire:model="travel" />
                    <x-input-error for="travel" />
                </div>
                <div class="col-span-4">
                    <x-label>Gaji Pokok</x-label>
                    <x-input type="number" wire:model="gaji_pokok" />
                    <x-input-error for="gaji_pokok" />
                </div>
                <div class="col-span-4">
                    <x-label>Rate</x-label>
                    <x-input type="number" wire:model="rate" />
                    <x-input-error for="rate" />
                </div>
                <div class="col-span-4">
                    <x-label>Tunjangan Jabatan</x-label>
                    <x-input type="number" wire:model="tunjangan" />
                    <x-input-error for="tunjangan" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-button color="primary">Simpan</x-button>
            </x-slot>
        </x-form-section>
    </div>

</div>
