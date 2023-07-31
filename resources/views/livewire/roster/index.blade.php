<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roster Guru Honor') }}
            </h2>
        </div>
    </x-slot>

    <div class="sm:mx-4 bg-white rounded-md">
        <div class="p-4 flex items-center gap-4 justify-between">
            <div class="w-20">
                <x-select wire:model="per_page">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </x-select>
            </div>
            <div class="w-64">
                <x-input-search :wire-model="'search'" />
            </div>
        </div>
        <div class="relative overflow-x-auto ">
            <x-table>
                <x-slot name="th">
                    <x-th>#</x-th>
                    <x-th>NIP</x-th>
                    <x-th>Nama Lengkap</x-th>
                    <x-th>Senin</x-th>
                    <x-th>Selasa</x-th>
                    <x-th>Rabu</x-th>
                    <x-th>Kamis</x-th>
                    <x-th>Jum'at</x-th>
                    @canany(['buat-pegawai', 'ubah-pegawai', 'hapus-pegawai'])
                        <x-th></x-th>
                    @endcanany
                </x-slot>

                @forelse($users  as $i => $user)
                    <tr class="{{ $loop->last ? '' : 'border-b' }}">
                        <x-td class="whitespace-nowrap">
                            <div class="font-medium">{{ $users->firstItem() + $i }}</div>
                        </x-td>
                        <x-td class="whitespace-nowrap">
                            <div class="text-gray-800 font-medium">{{ $user->nip }}</div>
                        </x-td>
                        <x-td class="whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="w-10 h-10 rounded-full" src="{{ $user->profile_photo_url }}" alt="">
                                <div class="pl-3">
                                    <div class="{{ $user->gender ? 'text-blue-800' : 'text-pink-800' }} font-medium">{{ $user->name }}</div>
                                    <div class="text-xs">{{ $user->role_display_name }}</div>
                                </div>
                            </div>
                        </x-td>
                        @foreach((new \App\Models\Roster)->days as $index => $day)
                            <x-td class="whitespace-nowrap">
                                @forelse($user->rosters()->where('day', $index)->get() as $schedule)
                                <div class="{{ $loop->last ? '' : 'mb-2' }}">
                                    <div class="text-gray-800 font-medium">{{ \Carbon\Carbon::parse($schedule->start_hour)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_hour)->format('H:i') }}</div>
                                    <div class="tex-xs">{{ $schedule->subject }}</div>
                                </div>
                                @empty
                                    <div class="text-center">{{ __('-') }}</div>
                                @endforelse
                            </x-td>
                        @endforeach

                        @canany(['buar-pegawai', 'ubah-pegawai', 'hapus-pegawai'])
                            <x-td>
                                <div class="flex items-center justify-end gap-4">
                                    @if(!$user->rosters()->exists())
                                    @can('buat-pegawai')
                                        <x-create-link href="{{ route('rosters.create', $user) }}">Buat</x-create-link>
                                    @endcan
                                    @else
                                    @can('ubah-pegawai')
                                        <x-edit-link href="{{ route('rosters.edit', $user) }}">Ubah</x-edit-link>
                                    @endcan
                                    @endif
                                    @can('hapus-pegawai')
                                        <x-delete-button wire:click="confirmDelete({{ $user }})" :disabled="$user->hasRole('kasir')">Hapus</x-delete-button>
                                    @endcan
                                </div>
                            </x-td>
                        @endcanany
                    </tr>
                @empty
                    <x-empty-row />
                @endforelse
            </x-table>

            @if($users->hasPages())
                <div class="p-4 border-t">
                    {{ $users->links() }}
                </div>
            @endif

        </div>
    </div>
</div>
