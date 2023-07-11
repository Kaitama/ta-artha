<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pengeluaran') }}
            </h2>
            @can('buat-pengeluaran')
            <x-button-link href="{{ route('cashflows.create') }}" color="primary">Buat baru</x-button-link>
            @endcan
        </div>
    </x-slot>

    <div class="sm:mx-4 bg-white rounded-md">
        <div class="grid grid-cols-2 lg:grid-cols-12 p-4 gap-4">
            <x-select wire:model="per_page">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </x-select>

            <div class="hidden lg:block lg:col-span-2"></div>

            <div class="lg:col-span-2">
                <x-select wire:model="this_month">
                    @foreach($months as $key => $month)
                        <option value="{{ $key }}">{{ $month }}</option>
                    @endforeach
                </x-select>
            </div>
            <div>
                <x-input type="number" min="2000" wire:model="this_year" max="{{ \Carbon\Carbon::today()->year }}" />
            </div>
            <div class="lg:col-span-2">
                <x-select wire:model="type">
                    <option value="">Pilih jenis</option>
                    @foreach($type_list as $key => $list)
                        <option value="{{ $key }}">{{ $list }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="col-span-2 lg:col-span-4">
                <x-input-search :wire-model="'search'" />
            </div>
        </div>
        <div class="relative overflow-x-auto ">
            <x-table>
                <x-slot name="th">
                    <x-th>#</x-th>
                    <x-th>Tanggal</x-th>
                    <x-th>Pegawai</x-th>
                    <x-th>Jabatan</x-th>
                    <x-th>Nominal</x-th>
                    @canany(['ubah-pengeluaran', 'hapus-pengeluaran'])
                    <x-th></x-th>
                    @endcanany
                </x-slot>

                @forelse($flows as $i => $flow)
                    <tr class="{{ $loop->last ? '' : ' border-b' }}">
                        <x-td>{{ $flows->firstItem() + $i }}</x-td>
                        <x-td>
                            <div class="text-gray-800 font-medium">{{ $flow->saved_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $flow->type_list[$flow->type] }}</div>
                        </x-td>
                        <x-td>
                            <div class="text-gray-800 font-medium">{{ $flow->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $flow->user->nip }}</div>
                        </x-td>
                        <x-td>
                            {{ $flow->user->role_display_name }}
                        </x-td>
                        <x-td>
                            <div class="text-gray-800 font-medium">
                                <div class="flex items-center justify-between">
                                    <span>Rp</span>
                                    <span>{{ \App\Helpers\Rupiah::format($flow->nominal) }}</span>
                                </div>
                            </div>
                            <div class="text-xs text-gray-500">{{ $flow->description ?? '-' }}</div>
                        </x-td>
                        @canany(['ubah-pengeluaran', 'hapus-pengeluaran'])
                        <x-td>
                            <div class="flex items-center justify-end gap-4">
                                @can('ubah-pengeluaran')
                                <x-edit-link href="{{ route('cashflows.edit', $flow) }}" :disabled="$flow->is_validated">Ubah</x-edit-link>
                                @endcan
                                @can('hapus-pengeluaran')
                                <x-delete-button wire:click="confirmDelete({{ $flow }})" :disabled="$flow->is_validated">Hapus</x-delete-button>
                                @endcan
                            </div>
                        </x-td>
                        @endcanany
                    </tr>
                @empty
                    <x-empty-row />
                @endforelse
            </x-table>

            @if($flows->hasPages())
                <div class="p-4 border-t">
                    {{ $flows->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation -->
    <x-confirmation-modal wire:model="show_modal_delete">
        <x-slot name="title">Hapus Data</x-slot>
        <x-slot name="content">
            <p>Anda yakin ingin menghapus {{ $record_to_delete->type_list[$record_to_delete->type ?? ''] ?? '' }} <strong>{{ $record_to_delete->user->name ?? '' }}</strong>?</p>
        </x-slot>
        <x-slot name="footer">
            <x-button type="button" color="secondary" wire:click="$toggle('show_modal_delete')" class="mr-3">Batal</x-button>
            <x-button type="button" color="danger" wire:click="destroy">Ya, hapus!</x-button>
        </x-slot>
    </x-confirmation-modal>
</div>
