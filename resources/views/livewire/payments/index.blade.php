<div class="pb-10">
    <header class="bg-transparent">
        <div class="mx-auto py-6 px-4">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Penggajian') }}</h2>

                @can('hitung-penggajian')
                <div class="flex items-center justify-end gap-4">
                    @if($payments->count())
                        <x-button wire:click="$toggle('show_modal_delete')" type="button" color="danger">Reset</x-button>
                    @endif
                    <x-button type="button" class="{{ ($payments->count() > 0 || !$validation_exists) ? 'bg-gray-400 hover:bg-gray-400' : '' }}" :disabled="($payments->count() > 0 || !$validation_exists)" color="primary" wire:click="$toggle('show_modal_confirmation')">Tutup buku</x-button>
                </div>
                @endcan
            </div>
        </div>
    </header>

    @can('hitung-penggajian')
    <div class="sm:mx-4 mb-6 p-4 rounded-md bg-amber-50 text-amber-600 border">
        <div class="font-bold">Perhatian</div>
        <p>Proses tutup buku & penggajian dilakukan tiap akhir bulan. Jika dilakukan pada pertengahan atau awal bulan, maka absensi di atas tanggal tersebut tidak akan ikut dihitung.</p>
    </div>
    @endcan

    <div class="sm:mx-4 bg-white rounded-md">
        <div class="grid grid-cols-2 lg:grid-cols-12 p-4 gap-4 items-center">

            <div class="col-span-2 lg:col-span-5">
                @if($payments->count() > 0)
                    Tanggal tutup buku: {{ $payments->first()->created_at->format('d/m/Y') }}
                @endif
                @if(!$validation_exists)
                    <span class="text-rose-600">Tidak ada validasi absen di bulan ini.</span>
                @endif
            </div>

            <div class="col-span-2">
                <x-select wire:model="month">
                    @foreach($months as $key => $bulan)
                        <option value="{{ $key }}">{{ $bulan }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="col-span-2">
                <x-input type="number" max="{{ \Carbon\Carbon::today()->year }}" wire:model="year" />
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
                    <x-th>Gaji Pokok</x-th>
                    <x-th>Tambahan</x-th>
                    <x-th>Potongan</x-th>
                    <x-th>Gaji Bersih</x-th>
                    <x-th></x-th>
                </x-slot>

                @forelse($payments as $i => $payment)
                    <tr class="{{ $loop->last ? '' : ' border-b' }}">
                        <x-td>{{ $i + 1 }}</x-td>
                        <x-td>
                            <div class="text-medium text-gray-800">{{ $payment->user->name }}</div>
                            <div class="text-xs">{{ $payment->user->nip }}</div>
                        </x-td>
                        <x-td>{{ $payment->user->role_display_name }}</x-td>
                        <x-td>
                            <div class="flex items-center justify-between">
                                <span>Rp</span>
                                <span>{{ \App\Helpers\Rupiah::format($payment->base) }}</span>
                            </div>
                        </x-td>
                        <x-td>
                            <div class="flex items-center justify-between">
                                <span>Rp</span>
                                <span>{{ \App\Helpers\Rupiah::format($payment->travel + $payment->bonus) }}</span>
                            </div>
                        </x-td>
                        <x-td>
                            <div class="flex items-center justify-between">
                                <span>Rp</span>
                                <span>{{ \App\Helpers\Rupiah::format($payment->withdraw) }}</span>
                            </div>
                        </x-td>
                        <x-td>
                            <div class="flex items-center justify-between">
                                <span>Rp</span>
                                <span>{{ \App\Helpers\Rupiah::format($payment->salary) }}</span>
                            </div>
                        </x-td>
                        <x-td class="text-right">
                            <x-view-link href="{{ route('payments.paycheck', ['user' => $payment->user, 'month' => $month, 'year' => $year]) }}" target="_blank">Lihat</x-view-link>
                        </x-td>
                    </tr>
                @empty
                    <x-empty-row />
                @endforelse
            </x-table>
        </div>
    </div>

    <!-- Confirmation Delete -->
    <x-confirmation-modal wire:model="show_modal_delete">
        <x-slot name="title">Reset Penggajian</x-slot>
        <x-slot name="content">
            <p>Anda yakin ingin melakukan reset semua data penggajian periode <strong>{{ $months[$month] }} {{ $year }}</strong>?</p>
        </x-slot>
        <x-slot name="footer">
            <x-button type="button" color="secondary" wire:click="$toggle('show_modal_delete')" class="mr-3">Batal</x-button>
            <x-button type="button" color="danger" wire:click="destroyAll">Ya, reset!</x-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Confirmation -->
    <x-confirmation-modal wire:model="show_modal_confirmation">
        <x-slot name="icon">
            <svg class="w-6 h-6 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.529 7.988a2.502 2.502 0 0 1 5 .191A2.441 2.441 0 0 1 10 10.582V12m-.01 3.008H10M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </x-slot>
        <x-slot name="title">Tutup Buku</x-slot>
        <x-slot name="content">
            <p>Anda yakin ingin melakukan tutup buku dan proses penggajian periode <strong>{{ $months[$month] }} {{ $year }}</strong>?</p>
        </x-slot>
        <x-slot name="footer">
            <x-button type="button" color="secondary" wire:click="$toggle('show_modal_confirmation')" class="mr-3">Batal</x-button>
            <x-button type="button" color="primary" wire:click="paycheck">Ya, proses!</x-button>
        </x-slot>
    </x-confirmation-modal>
</div>
