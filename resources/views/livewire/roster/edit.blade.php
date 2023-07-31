<div class="pb-10">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
                <a class="text-blue-600" href="{{ route('rosters.index') }}">Roster</a> / Ubah
            </h2>
        </div>
    </x-slot>

    <div class="sm:mx-4">
        <x-form-section submit="update" cols="8">
            <x-slot name="title">Roster {{ $user->name }}</x-slot>
            <x-slot name="description">Roster mengajar disesuaikan otomatis dengan jumlah jam mengajar {{ $user->name }}.</x-slot>

            <x-slot name="form">
                @php
                    $array_days = (new \App\Models\Roster)->days;
                @endphp
                @foreach($teaching_hours as $key => $teach)
                    <div class="col-span-8">
                        <h4 class="text-lg font-medium">Hari {{ $array_days[$teach['day']] }} - {{ $teach['hours'] }} Jam</h4>
                    </div>
                    @for($t = 0; $t < $teach['hours']; $t++)
                        <div class="col-span-2">
                            <x-label :required="true">Jam Mulai</x-label>
                            <x-input type="time" wire:model.defer="rosters.{{ $teach['day'] }}.{{ $t }}.start_hour" />
                            <x-input-error for="rosters.{{ $teach['day'] }}.{{ $t }}.start_hour" />
                        </div>
                        <div class="col-span-2">
                            <x-label :required="true">Jam Selesai</x-label>
                            <x-input type="time" wire:model.defer="rosters.{{ $teach['day'] }}.{{ $t }}.end_hour" />
                            <x-input-error for="rosters.{{ $teach['day'] }}.{{ $t }}.end_hour" />
                        </div>
                        <div class="col-span-4">
                            <x-label :required="true">Mata Pelajaran</x-label>
                            <x-input type="text" wire:model.defer="rosters.{{ $teach['day'] }}.{{ $t }}.subject" />
                            <x-input-error for="rosters.{{ $teach['day'] }}.{{ $t }}.subject" />
                        </div>
                    @endfor
                    <div class="col-span-8">
                        <x-section-border />
                    </div>
                @endforeach

            </x-slot>

            <x-slot name="actions">
                <x-input-error for="rosters" class="mr-3" />
                <x-button color="primary">Ubah</x-button>
            </x-slot>

        </x-form-section>
    </div>
</div>
