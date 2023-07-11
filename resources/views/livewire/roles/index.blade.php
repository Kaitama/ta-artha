<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jabatan') }}
            </h2>
            @can('buat-jabatan')
            <x-button-link href="{{ route('roles.create') }}" color="primary">Buat baru</x-button-link>
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
                    <x-th>Jabatan</x-th>
                    <x-th>Gaji Pokok</x-th>
                    <x-th>Rate</x-th>
                    <x-th>Travel</x-th>
                    <x-th>Tunjangan</x-th>
                    <x-th>Pot. Absen</x-th>
                    @canany(['ubah-jabatan', 'hapus-jabatan'])
                    <x-th></x-th>
                    @endcanany
                </x-slot>

                @forelse($roles as $i => $role)
                    <tr class="{{ $loop->last ? '' : ' border-b' }}">
                        <x-td>{{ $roles->firstItem() + $i }}</x-td>
                        <x-td>
                            <div class="text-base text-gray-800 font-medium">
                                {{ $role->display_name }}
                            </div>
                        </x-td>
                        <x-td class="w-36">
                            <div class="flex items-center justify-between">
                                <span>Rp</span>
                                <span>{{ \App\Helpers\Rupiah::format($role->base) }}</span>
                            </div>
                        </x-td>
                        <x-td class="w-36">
                            <div class="flex items-center justify-between">
                                <span>Rp</span>
                                <span>{{ \App\Helpers\Rupiah::format($role->rate) }}</span>
                            </div>
                        </x-td>
                        <x-td class="w-36">
                            <div class="flex items-center justify-between">
                                <span>Rp</span>
                                <span>{{ \App\Helpers\Rupiah::format($role->travel) }}</span>
                            </div>
                        </x-td>
                        <x-td class="w-36">
                            <div class="flex items-center justify-between">
                                <span>Rp</span>
                                <span>{{ \App\Helpers\Rupiah::format($role->bonus) }}</span>
                            </div>
                        </x-td>
                        <x-td class="w-36">
                            <div class="flex items-center justify-between">
                                <span>Rp</span>
                                <span>{{ \App\Helpers\Rupiah::format($role->absence_cut) }}</span>
                            </div>
                        </x-td>
                        @canany(['ubah-jabatan', 'hapus-jabatan'])
                        <x-td>
                            <div class="flex items-center justify-end gap-4">
                                @can('ubah-jabatan')
                                <x-edit-link href="{{ route('roles.edit', $role) }}">Ubah</x-edit-link>
                                @endcan
                                @can('hapus-jabatan')
                                <x-delete-button wire:click="confirmDelete({{ $role }})" :disabled="$role->priority">Hapus</x-delete-button>
                                @endcan
                            </div>
                        </x-td>
                        @endcanany
                    </tr>
                @empty
                    <x-empty-row />
                @endforelse

            </x-table>

            @if($roles->hasPages())
                <div class="p-4 border-t">
                    {{ $roles->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation -->
    <x-confirmation-modal wire:model="show_delete_modal">
        <x-slot name="title">Hapus Data</x-slot>
        <x-slot name="content">
            <p>Anda yakin ingin menghapus <strong>{{ $record_to_delete->display_name ?? '' }}</strong>?</p>
        </x-slot>
        <x-slot name="footer">
            <x-button type="button" color="secondary" wire:click="$toggle('show_delete_modal')" class="mr-3">Batal</x-button>
            <x-button type="button" color="danger" wire:click="destroy">Ya, hapus!</x-button>
        </x-slot>
    </x-confirmation-modal>
</div>
