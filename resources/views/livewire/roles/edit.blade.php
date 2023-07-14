<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
                <a class="text-blue-600" href="{{ route('roles.index') }}">Jabatan</a> / Ubah
            </h2>
        </div>
    </x-slot>

    <div class="sm:mx-4">
        <x-form-section submit="update">
            <x-slot name="title"></x-slot>
            <x-slot name="description"></x-slot>

            <x-slot name="form">
                <div class="col-span-4">
                    <x-label :required="true">Nama Jabatan</x-label>
                    <x-input type="text" wire:model.defer="nama_jabatan" :disabled="$role->priority" />
                    @if($role->priority)
                        <span class="text-xs text-gray-400">Nama jabatan ini tidak dapat diubah.</span>
                    @else
                        <x-input-error for="role.name" />
                    @endif
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Potongan Absensi</x-label>
                    <x-input type="number" wire:model.defer="role.absence_cut" />
                    <x-input-error for="role.absence_cut" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Travel</x-label>
                    <x-input type="number" wire:model.defer="role.travel" />
                    <x-input-error for="role.travel" />
                </div>
                <div class="col-span-4">
                    <x-label>Gaji Pokok</x-label>
                    <x-input type="number" wire:model.defer="role.base" />
                    <x-input-error for="role.base" />
                </div>
                <div class="col-span-4">
                    <x-label>Rate</x-label>
                    <x-input type="number" wire:model.defer="role.rate" />
                    <x-input-error for="role.rate" />
                </div>
                <div class="col-span-4">
                    <x-label>Tunjangan Jabatan</x-label>
                    <x-input type="number" wire:model.defer="role.bonus" />
                    <x-input-error for="role.bonus" />
                </div>
                <div class="col-span-4">
                    <x-label>Maksimal Pinjaman/Bulan</x-label>
                    <x-input type="number" wire:model.defer="role.limit" />
                    <x-input-error for="role.limit" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-button color="primary">Ubah</x-button>
            </x-slot>
        </x-form-section>
    </div>

</div>
