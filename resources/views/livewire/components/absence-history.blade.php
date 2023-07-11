<div class="sm:rounded-md bg-white border shadow">
    <div class="p-4 flex justify-between">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Riwayat Absensi</h5>
        <div class="flex items-center gap-4">
            <div class="w-64">
                <x-select wire:model="bulan">
                    @foreach($months as $key => $month)
                        <option value="{{ $key }}">{{ $month }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="w-24">
                <x-input type="number" min="2000" wire:model="tahun" />
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto ">
        <x-table>
            <x-slot name="th">
                <x-th>#</x-th>
                <x-th>Tanggal</x-th>
                <x-th>Checkin</x-th>
                <x-th>Status</x-th>
            </x-slot>

            @forelse($validations as $key => $history)
                <tr class="{{ $loop->last ? '' : ' border-b' }}">
                    <x-td>{{ $key + 1 }}</x-td>
                    <x-td>{{ $history->for_date->format('d/m/Y') }}</x-td>
                    <x-td>{{ $history->absence ? $history->absence->created_at->format('H:i') : '-' }}</x-td>
                    <x-td>
                        @if($history->absence)
                            <x-badge-icon :color="$history->absence->is_late ? 'warning' : 'success'">
                                <x-slot name="icon">
                                    @if($history->absence->is_late)
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M10 6v4l3.276 3.276M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    @endif
                                </x-slot>
                                {{ $history->absence->is_late ? 'Terlambat' : 'Ontime' }}
                            </x-badge-icon>
                        @else
                            <x-badge-icon color="danger">
                                <x-slot name="icon">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                    </svg>
                                </x-slot>
                                Absen
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
