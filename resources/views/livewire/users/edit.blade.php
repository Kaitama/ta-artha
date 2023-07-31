<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
                <a class="text-blue-600" href="{{ route('users.index') }}">Pegawai</a> / Ubah
            </h2>
        </div>
    </x-slot>

    <div class="sm:mx-4">
        <x-form-section submit="update">
            <x-slot name="title">Ubah Akun</x-slot>
            <x-slot name="description">Password akun hanya dapat diubah oleh pegawai yang bersangkutan.</x-slot>

            <x-slot name="form">
                <div class="col-span-4">
                    <x-label :required="true">Tanggal Masuk</x-label>
                    <x-input type="date" wire:model.defer="user.joined_at" max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" />
                    <x-input-error for="user.joined_at" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Jabatan</x-label>
                    <x-select wire:model="jabatan">
                        <option value="" selected>Pilih salah satu</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ isset($role_exists[$role]) && $role_exists[$role] ? 'disabled' : '' }}>{{ ucwords(str_replace('-', ' ', $role)) }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="jabatan" />
                </div>
                <div class="col-span-4">
                    <x-label>Keterangan Jabatan</x-label>
                    <x-input type="text" wire:model.defer="user.description" />
                    <x-input-error for="user.description" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Nomor Induk Pegawai/Guru</x-label>
                    <x-input type="text" wire:model.defer="user.nip" />
                    <x-input-error for="user.nip" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Nama Lengkap</x-label>
                    <x-input type="text" wire:model.defer="user.name" />
                    <x-input-error for="user.name" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Tempat Lahir</x-label>
                    <x-input type="text" wire:model.defer="user.birthplace" />
                    <x-input-error for="user.birthplace" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Tanggal Lahir</x-label>
                    <x-input type="date" wire:model.defer="user.birthdate" max="{{ \Carbon\Carbon::now()->addYears(-16)->format('Y-m-d') }}" min="{{ \Carbon\Carbon::now()->addYears(-40)->format('Y-m-d') }}" />
                    <x-input-error for="user.birthdate" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Jenis Kelamin</x-label>
                    <x-select wire:model.defer="user.gender">
                        <option value="1">Laki-laki</option>
                        <option value="0">Perempuan</option>
                    </x-select>
                    <x-input-error for="user.gender" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Agama</x-label>
                    <x-select wire:model.defer="user.religion">
                        <option value="">Pilih salah satu</option>
                        @foreach((new \App\Models\User())->religions as $key => $religion)
                            <option value="{{ $key }}">{{ $religion }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="user.religion" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Login Username</x-label>
                    <x-input type="text" wire:model.defer="user.username" />
                    <x-input-error for="user.username" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Alamat Email</x-label>
                    <x-input type="text" wire:model.defer="user.email" />
                    <x-input-error for="user.email" />
                </div>
                <div class="col-span-4">
                    <x-label>Nomor Telepon/WA</x-label>
                    <x-input type="text" wire:model.defer="user.phone" />
                    <span class="mt-1 text-xs text-gray-600">Jangan gunakan awalan "+62"</span>
                    <x-input-error for="user.phone" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Pendidikan Terakhir</x-label>
                    <x-select wire:model.defer="user.education">
                        <option value="">Pilih salah satu</option>
                        @foreach((new \App\Models\User())->educations as $key => $education)
                            <option value="{{ $key }}">{{ $education }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="user.education" />
                </div>
                <div class="col-span-4">
                    <x-label>Jurusan/Program Studi</x-label>
                    <x-input type="text" wire:model.defer="user.major" />
                    <x-input-error for="user.major" />
                </div>
                <div class="col-span-4">
                    <x-label :required="true">Asal Sekolah/Perguruan Tinggi</x-label>
                    <x-input type="text" wire:model.defer="user.university" />
                    <x-input-error for="user.university" />
                </div>
{{--                <div class="col-span-4">--}}
{{--                    <x-label :required="true">Jam Masuk Absensi</x-label>--}}
{{--                    <x-input type="text" wire:model.defer="user.check_in" />--}}
{{--                    <x-input-error for="user.check_in" />--}}
{{--                </div>--}}
                @if($jabatan === 'guru-tetap' || $jabatan === 'kasir' || $jabatan === 'kepala-sekolah')
                    <div class="col-span-4">
                        <x-label :required="true">Point</x-label>
                        <x-input type="number" wire:model.defer="user.point" />
                        <x-input-error for="user.point" />
                    </div>
                @endif
                @if($jabatan === 'guru-honor')
                    <div class="col-span-6">
                        <x-section-border />
                        <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                            <span class="font-medium">Peringatan!</span> Mengubah jumlah jam mengajar akan menghapus semua jadwal roster {{ $user->name }}.
                        </div>
                        <x-section-border />
                    </div>
                    @foreach($days as $key => $day)
                        <div class="col-span-4">
                            <x-label :required="true">Jumlah Jam Mengajar {{ $day }}</x-label>
                            <x-input type="number" wire:model.defer="jam_mengajar.{{ $key }}" />
                            <x-input-error for="jam_mengajar" />
                        </div>
                    @endforeach
                @endif
                <div class="col-span-4">
                    <x-label>Status</x-label>
                    <label class="relative inline-flex items-center mr-5 cursor-pointer">
                        <input type="checkbox" wire:model.defer="user.is_active" value="" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    </label>
                </div>

            </x-slot>

            <x-slot name="actions">
                <x-button color="primary">Ubah</x-button>
            </x-slot>
        </x-form-section>
    </div>
</div>
