<div class="sm:rounded-md bg-white border shadow">
    <div class="p-4 flex justify-between">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Riwayat Potongan</h5>
        <div class="flex items-center gap-4">
            <div class="w-64">
                <x-select wire:model="month">
                    @foreach($months as $key => $bulan)
                        <option value="{{ $key }}">{{ $bulan }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="w-24">
                <x-input type="number" min="2000" wire:model="year" />
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto ">
        <x-table>
            <x-slot name="th">
                <x-th>#</x-th>
                <x-th>Tanggal</x-th>
                <x-th>Potongan</x-th>
                <x-th>Nominal</x-th>
            </x-slot>

            @forelse($cashflows as $key => $history)
                <tr class="{{ $loop->last ? '' : ' border-b' }}">
                    <x-td>{{ $key + 1 }}</x-td>
                    <x-td>{{ $history->saved_at->format('d/m/Y') }}</x-td>
                    <x-td>
                        <div class="font-medium text-gray-800">{{ $history->type_list[$history->type] }}</div>
                        <div class="text-xs">{{ $history->description }}</div>
                    </x-td>
                    <x-td class="flex items-center justify-between">
                        <span>Rp</span>
                        <span>{{ \App\Helpers\Rupiah::format($history->nominal) }}</span>
                    </x-td>
                </tr>

            @empty
                <x-empty-row />
            @endforelse
        </x-table>
    </div>
</div>
