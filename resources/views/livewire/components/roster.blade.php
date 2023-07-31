<div>
    <x-card>
        <x-slot name="title">Roster Mengajar</x-slot>

        <div>
            @forelse($rosters as $k => $roster)
                <div>
                    <div class="font-medium text-gray-800">{{ $days[$roster->day] }}</div>
                    <div class="text-xs">{{ \Carbon\Carbon::parse($roster->start_hour)->format('H:i') }} - {{ $roster->subject }}</div>
                </div>
            @if(!$loop->last)
                <div class="py-2">
                    <div class="border-t border-gray-200"></div>
                </div>
            @endif
            @empty
                <div class="text-center">
                    <x-empty-row />
                </div>
            @endforelse
        </div>
    </x-card>
</div>
