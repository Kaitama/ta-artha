<x-card class="">
    <x-slot name="title">Absensi</x-slot>
    <div class="flex-col mt-4 space-y-1 md:mt-6">
        <div class="text-center text-lg font-medium text-gray-500">{{ \Carbon\Carbon::now()->isoFormat('LL') }}</div>
        @if(!$checked_in)
            <div class="text-center text-4xl bg-clip-text text-transparent bg-gradient-to-r from-green-500 to-blue-500 via-purple-500 font-mono whitespace-nowrap" x-data x-timeout:1000="$el.innerText=$moment().format('H:mm:ss')"></div>
        @else
            <div class="text-center text-4xl bg-clip-text text-transparent bg-gradient-to-r from-green-500 to-blue-500 via-purple-500 font-mono whitespace-nowrap">{{ $absence->created_at->format('H:i:s') }}</div>
        @endif

    </div>
    <div class="flex mt-4 justify-center space-x-3 md:mt-6">
        @if(!$checked_in)
            @if($is_validated)
                <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-800 bg-gray-200 rounded-lg">Absensi sudah ditutup</div>
            @else
                <a href="{{ route('absence.chekin') }}" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Check in sekarang</a>
            @endif
        @else
            <x-badge-icon :color="$is_late ? 'danger' : 'success'">
                <x-slot name="icon">
                @if($is_late)
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M10 6v4l3.276 3.276M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                @else
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                @endif
                </x-slot>
                {{ $is_late ? 'Terlambat' : 'Ontime' }}
            </x-badge-icon>
        @endif
    </div>
</x-card>
