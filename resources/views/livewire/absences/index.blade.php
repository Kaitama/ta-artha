<div class="pb-10">
    <header class="bg-transparent">
        <div class="mx-auto py-6 px-4">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Absensi') }}</h2>

                <div class="flex items-center justify-end space-x-4">
                    @if($validasi_exists)
                        @role('bendahara')
                            <x-button wire:click="export" type="button" color="success">Download</x-button>
                        @endrole
                    @endif
                    @can('validasi-absensi')
                        @if($validasi_exists)
                            <x-button type="button" color="danger" wire:click="$toggle('show_modal_reset')">Reset</x-button>
                        @endif
                        <x-button type="button" class="{{ $validasi_exists ? 'bg-gray-400 hover:bg-gray-400' : '' }}" :disabled="$validasi_exists" color="primary" wire:click="$toggle('show_modal_confirm')">Validasi</x-button>
                    @endcan
                </div>
            </div>
        </div>
    </header>

    <div class="sm:mx-4 bg-white rounded-md">
        <div class="grid grid-cols-2 lg:grid-cols-12 p-4 gap-4 items-center">

            <div class="col-span-2 lg:col-span-5">
                @if($validasi_exists)
                Tanggal validasi: {{ $validasi_exists->created_at->format('d/m/Y') }}
                @endif
            </div>

            <div class="col-span-2">
                <x-select wire:model="jabatan">
                    <option value="">Filter jabatan</option>
                    @foreach($roles as $role)
                        <option value="{{ $role }}">{{ ucwords(str_replace('-', ' ', $role)) }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="col-span-2">
                <x-input type="date" max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" wire:model="today" />
            </div>
            <div class="col-span-2 lg:col-span-3">
                <x-input-search :wire-model="'search'" />
            </div>
        </div>
        <div class="relative overflow-x-auto ">
            <x-table>
                <x-slot name="th">
                    <x-th>#</x-th>
                    <x-th>Pegawai</x-th>
                    <x-th>Jabatan</x-th>
                    <x-th>Jam Masuk</x-th>
                    <x-th>Jam Checkin</x-th>
                    <x-th>Status</x-th>
                </x-slot>

                @forelse($users as $i => $user)
                    @php
                        $absence = $user->absences->first();
                    @endphp
                    <tr class="{{ $loop->last ? '' : ' border-b' }}">
                        <x-td>{{ $i + 1 }}</x-td>
                        <x-td class="flex items-center whitespace-nowrap">
                            <img class="w-10 h-10 rounded-full" src="{{ $user->profile_photo_url }}" alt="">
                            <div class="pl-3">
                                <div class="text-gray-800 font-medium">{{ $user->name }}</div>
                                <div class="text-xs">{{ $user->nip }}</div>
                            </div>
                        </x-td>
                        <x-td>{{ $user->role_display_name }}</x-td>
                        <x-td>{{ $user->check_in }}</x-td>
                        <x-td>
                            {{ $absence ? $absence->created_at->format('H:i') : '-' }}
                        </x-td>
                        <x-td>
                            @if($absence)
                            <x-badge-icon :color="$absence->is_late ? 'warning' : 'success'">
                                <x-slot name="icon">
                                    @if($absence->is_late)
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M10 6v4l3.276 3.276M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    @endif
                                </x-slot>
                                {{ $absence->is_late ? 'Terlambat' : 'Ontime' }}
                            </x-badge-icon>
                            @else
                                <x-badge-icon :color="$validasi_exists ? 'danger' : 'secondary'">
                                    <x-slot name="icon">
                                        @if($validasi_exists)
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 4">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M2.49 2h.01m6 0h.01m5.99 0h.01"/>
                                            </svg>
                                        @endif
                                    </x-slot>
                                    {{ $validasi_exists ? 'Absen' : 'Waiting' }}
                                </x-badge-icon>
                            @endif
                        </x-td>
                    </tr>
                @empty
                    <x-empty-row />
                @endforelse

            </x-table>
        </div>
    </div>

    <!-- Confirmation -->
    <x-confirmation-modal wire:model="show_modal_confirm">
        <x-slot name="title">Validasi Absensi</x-slot>
        <x-slot name="content">
            <p>Anda yakin ingin melakukan validasi absen untuk tanggal <strong>{{ \Carbon\Carbon::parse($today)->isoFormat('LL')  }}</strong>?</p>
        </x-slot>
        <x-slot name="footer">
            <x-button type="button" color="secondary" wire:click="$toggle('show_modal_confirm')" class="mr-3">Batal</x-button>
            <x-button type="button" color="danger" wire:click="prosesValidasi">Ya, validasi!</x-button>
        </x-slot>
    </x-confirmation-modal>
    <!-- Reset -->
    <x-confirmation-modal wire:model="show_modal_reset">
        <x-slot name="title">Reset Validasi Absensi</x-slot>
        <x-slot name="content">
            <p>Anda yakin ingin melakukan reset validasi absen untuk tanggal <strong>{{ \Carbon\Carbon::parse($today)->isoFormat('LL')  }}</strong>?</p>
        </x-slot>
        <x-slot name="footer">
            <x-button type="button" color="secondary" wire:click="$toggle('show_modal_reset')" class="mr-3">Batal</x-button>
            <x-button type="button" color="danger" wire:click="resetValidasi">Ya, reset!</x-button>
        </x-slot>
    </x-confirmation-modal>
</div>
