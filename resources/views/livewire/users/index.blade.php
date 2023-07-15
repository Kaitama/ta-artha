<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pegawai') }}
            </h2>
            @can('buat-pegawai')
            <x-button-link href="{{ route('users.create') }}" color="primary">Buat baru</x-button-link>
            @endcan
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
                    <x-th>NIP/Jabatan</x-th>
                    <x-th>Nama Lengkap</x-th>
                    <x-th>Kontak</x-th>
                    <x-th>Status</x-th>
                    @canany(['ubah-pegawai', 'hapus-pegawai'])
                    <x-th></x-th>
                    @endcanany
                </x-slot>

                @forelse($users as $i => $user)
                    <tr class="{{ $loop->last ? '' : 'border-b' }}">
                        <x-td>
                            <div class="font-medium">{{ $users->firstItem() + $i }}</div>
                        </x-td>
                        <x-td>
                            <div class="text-gray-800 font-medium">{{ $user->nip }}</div>
                            <div class="text-xs">{{ $user->role_display_name }}</div>
                        </x-td>
                        <x-td class="flex items-center whitespace-nowrap">
                            <img class="w-10 h-10 rounded-full" src="{{ $user->profile_photo_url }}" alt="">
                            <div class="pl-3">
                                <div class="{{ $user->gender ? 'text-blue-800' : 'text-pink-800' }} font-medium">{{ $user->name }}</div>
                                <div class="text-xs">{{ $user->username }}</div>
                            </div>
                        </x-td>
                        <x-td>
                            <div class="text-gray-800 font-medium">{{ $user->phone }}</div>
                            <div class="text-xs">{{ $user->email }}</div>
                        </x-td>
                        <x-td>
                            <x-badge-icon :color="$user->is_active ? 'success' : 'danger'">
                                <x-slot name="icon">
                                    @if($user->is_active)
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    @endif
                                </x-slot>
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </x-badge-icon>
                        </x-td>
                        @canany(['ubah-pegawai', 'hapus-pegawai'])
                        <x-td>
                            <div class="flex items-center justify-end gap-4">
                                @can('ubah-pegawai')
                                <x-edit-link href="{{ route('users.edit', $user) }}">Ubah</x-edit-link>
                                @endcan
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

    <!-- Delete Confirmation -->
    <x-confirmation-modal wire:model="show_delete_modal">
        <x-slot name="title">Hapus Data</x-slot>
        <x-slot name="content">
            <p>Anda yakin ingin menghapus <strong>{{ $record_to_delete->name ?? '' }}</strong>?</p>
        </x-slot>
        <x-slot name="footer">
            <x-button type="button" color="secondary" wire:click="$toggle('show_delete_modal')" class="mr-3">Batal</x-button>
            <x-button type="button" color="danger" wire:click="destroy">Ya, hapus!</x-button>
        </x-slot>
    </x-confirmation-modal>

</div>
