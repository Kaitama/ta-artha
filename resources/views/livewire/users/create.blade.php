<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
                <a class="text-blue-600" href="{{ route('users.index') }}">Pegawai</a> / Buat baru
            </h2>
        </div>
    </x-slot>

    <div class="sm:mx-4">
        <x-form-section submit="store">
            <x-slot name="title">Buat Akun</x-slot>
            <x-slot name="description">Password default akun baru adalah <span class="font-medium text-rose-800">sdadvent2</span>. Password tersebut dapat diganti setelah login.</x-slot>

            <x-slot name="form">
                <div class="col-span-4">
                    <x-label :required="true">Jabatan</x-label>
                    <x-select wire:model="jabatan">
                        <option value="" selected>Pilih salah satu</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}">{{ ucwords(str_replace('-', ' ', $role)) }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="jabatan" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Nomor Induk Pegawai/Guru</x-label>
                    <x-input type="text" wire:model="nomor_induk" />
                    <x-input-error for="nomor_induk" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Nama Lengkap</x-label>
                    <x-input type="text" wire:model="nama_lengkap" />
                    <x-input-error for="nama_lengkap" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Login Username</x-label>
                    <x-input type="text" wire:model="username" />
                    <x-input-error for="username" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Alamat Email</x-label>
                    <x-input type="text" wire:model="email" />
                    <x-input-error for="email" />
                </div>
                <div class="col-span-4">
                    <x-label>Nomor Telepon/WA</x-label>
                    <x-input type="text" wire:model="telepon" />
                    <x-input-error for="telepon" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Jam Masuk Absensi</x-label>
                    <x-input type="text" wire:model="jam_masuk" />
                    <x-input-error for="jam_masuk" />
                </div>
                @if($jabatan === 'guru-tetap' || $jabatan === 'kasir' || $jabatan === 'kepala-sekolah')
                <div class="col-span-4">
                    <x-label :required="true">Point</x-label>
                    <x-input type="number" wire:model="point" />
                    <x-input-error for="point" />
                </div>
                @endif
                @if($jabatan === 'guru-honor')
                <div class="col-span-4">
                    <x-label :required="true">Jumlah Jam Mengajar/Bulan</x-label>
                    <x-input type="number" wire:model="jam_mengajar" />
                    <x-input-error for="jam_mengajar" />
                </div>
                @endif
                <div class="col-span-4">
                    <x-label>Status</x-label>
                    <label class="relative inline-flex items-center mr-5 cursor-pointer">
                        <input type="checkbox" wire:model="status" value="" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $status ? 'Aktif' : 'Nonaktif' }}</span>
                    </label>
                </div>

            </x-slot>

            <x-slot name="actions">
                <x-button color="primary">Simpan</x-button>
            </x-slot>
        </x-form-section>
    </div>
</div>
