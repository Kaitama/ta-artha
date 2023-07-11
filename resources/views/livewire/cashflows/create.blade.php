<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
                <a class="text-blue-600" href="{{ route('cashflows.index') }}">Pengeluaran</a> / Buat baru
            </h2>
        </div>
    </x-slot>

    <div class="sm:mx-4">
        <x-form-section submit="store">
            <x-slot name="title">Catatan Pengeluaran</x-slot>
            <x-slot name="description">Pengeluaran yang sudah dihitung saat penggajian tidak dapat diubah kembali atau dihapus.</x-slot>

            <x-slot name="form">
                <div class="col-span-4">
                    <x-label :required="true">Tanggal</x-label>
                    <x-input type="date" wire:model.defer="tanggal" />
                    <x-input-error for="tanggal" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Jabatan</x-label>
                    <x-select wire:model="jabatan">
                        <option value="">Pilih jabatan</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}">{{ ucwords(str_replace('-', ' ', $role)) }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="jabatan" />
                </div>
                @if($jabatan)
                    <div class="col-span-4">
                        <x-label :required="true">Nama Pegawai</x-label>
                        <x-select wire:model.defer="pegawai">
                            <option value="">Pilih pegawai</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->nip }} - {{ $user->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error for="pegawai" />
                    </div>
                @endif
                <div class="col-span-4">
                    <x-label :required="true">Tipe Pengeluaran</x-label>
                    <x-select wire:model.defer="tipe">
                        <option value="">Pilih tipe</option>
                        @foreach($types as $i => $type)
                            <option value="{{ $i }}">{{ $type }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="tipe" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Nominal</x-label>
                    <x-input type="number" wire:model.defer="nominal" />
                    <x-input-error for="nominal" />
                </div>
                <div class="col-span-4">
                    <x-label>Keterangan</x-label>
                    <x-textarea wire:model.defer="keterangan" />
                    <x-input-error for="keterangan" />
                </div>


            </x-slot>
            <x-slot name="actions">
                <x-button color="primary">Simpan</x-button>
            </x-slot>
        </x-form-section>
    </div>
</div>
