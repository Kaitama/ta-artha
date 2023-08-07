<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
                <a class="text-blue-600" href="{{ route('rosters.index') }}">Roster</a> / Ubah
            </h2>
        </div>
    </x-slot>

    <div class="sm:mx-4">
        <x-form-section submit="update" cols="8">
            <x-slot name="title">Roster {{ $user->name }}</x-slot>
            <x-slot name="description">Roster mengajar disesuaikan otomatis dengan jumlah jam mengajar {{ $user->name }}.</x-slot>

            <x-slot name="form">
                @php
                    $array_days = (new \App\Models\Roster)->days;
                @endphp
                <div class="col-span-3">
                    <x-label :required="true">Tahun Ajaran</x-label>
                    <x-input type="text" wire:model.defer="tahun_ajaran" readonly />
                    <x-input-error for="tahun_ajaran" />
                </div>
                <div class="col-span-3">
                    <x-label :required="true">Semester</x-label>
                    <x-select wire:model.defer="semester" disabled>
                        <option value="1">Ganjil</option>
                        <option value="2">Genap</option>
                    </x-select>
                    <x-input-error for="semester" />
                </div>
                <div class="col-span-6">
                    <x-section-border />
                </div>
                @for($i = 0; $i < $schedule; $i++)
                    @if($i >= 1)
                        <div class="col-span-5">
                            <x-section-border />
                        </div>
                        <div class="text-right my-auto">
                            <div class="text-rose-600 text-xs font-medium underline cursor-pointer" wire:click="removeSchedule({{ $i }})">Hapus</div>
                        </div>
                    @endif
                    <div class="col-span-2">
                        <x-label :required="true">Hari</x-label>
                        <x-select wire:model.defer="rosters.{{ $i }}.day">
                            <option value="">Pilih salah satu</option>
                            @foreach($array_days as $key => $d)
                                <option value="{{ $key }}">{{ $d }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error for="rosters.{{ $i }}.day" />
                    </div>
                    <div class="col-span-2">
                        <x-label :required="true">Jam Mulai</x-label>
                        <x-input type="time" wire:model.defer="rosters.{{ $i }}.start_hour" />
                        <x-input-error for="rosters.{{ $i }}.start_hour" />
                    </div>
                    <div class="col-span-2">
                        <x-label :required="true">Jam Selesai</x-label>
                        <x-input type="time" wire:model.defer="rosters.{{ $i }}.end_hour" />
                        <x-input-error for="rosters.{{ $i }}.end_hour" />
                    </div>
                    <div class="col-span-6">
                        <x-label :required="true">Mata Pelajaran</x-label>
                        <x-input type="text" wire:model.defer="rosters.{{ $i }}.subject" />
                        <x-input-error for="rosters.{{ $i }}.subject" />
                    </div>
                @endfor

                <x-secondary-button wire:click="addSchedule" class="w-36 justify-center">
                    Tambah jam
                </x-secondary-button>
            </x-slot>

            <x-slot name="actions">
                <x-input-error for="rosters" class="mr-3" />
                <x-button color="primary">Ubah</x-button>
            </x-slot>

        </x-form-section>
    </div>
</div>
