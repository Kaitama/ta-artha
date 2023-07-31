<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profil Akun') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ubah informasi profil dan akun anda.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Foto profil') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Pilih foto baru') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Hapus foto') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nama lengkap') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Birthplace -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="birthplace" value="{{ __('Tempat lahir') }}" />
            <x-input id="birthplace" type="text" class="mt-1 block w-full" wire:model.defer="state.birthplace" autocomplete="birthplace" />
            <x-input-error for="birthplace" class="mt-2" />
        </div>

        <!-- Birthdate -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="birthdate" value="{{ __('Tanggal lahir') }}" />
            <x-input id="birthdate" type="date" max="{{ \Carbon\Carbon::now()->addYears(-16)->format('Y-m-d') }}" min="{{ \Carbon\Carbon::now()->addYears(-40)->format('Y-m-d') }}" class="mt-1 block w-full" wire:model.defer="state.birthdate" autocomplete="birthdate" />
            <x-input-error for="birthdate" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Alamat email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" autocomplete="email" />
            <x-input-error for="email" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="username" value="{{ __('Username') }}" />
            <x-input id="username" type="text" class="mt-1 block w-full" wire:model.defer="state.username" autocomplete="username" />
            <x-input-error for="username" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="phone" value="{{ __('Nomor telepon') }}" />
            <x-input id="phone" type="tel" class="mt-1 block w-full" wire:model.defer="state.phone" autocomplete="phone" />
            <x-input-error for="phone" class="mt-2" />
        </div>

        <!-- Education -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="education" value="{{ __('Pendidikan terakhir') }}" />
            <x-select wire:model.defer="state.education">
                <option value="">Pilih salah satu</option>
                @foreach((new \App\Models\User())->educations as $key => $education)
                    <option value="{{ $key }}">{{ $education }}</option>
                @endforeach
            </x-select>
            <x-input-error for="education" class="mt-2" />
        </div>

        <!-- Major -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="major" value="{{ __('Jurusan/Prodi') }}" />
            <x-input id="major" type="text" class="mt-1 block w-full" wire:model.defer="state.major" autocomplete="major" />
            <x-input-error for="major" class="mt-2" />
        </div>

        <!-- University -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="university" value="{{ __('Sekolah/Perguruan Tinggi') }}" />
            <x-input id="university" type="text" class="mt-1 block w-full" wire:model.defer="state.university" autocomplete="university" />
            <x-input-error for="university" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Tersimpan.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo" color="primary">
            {{ __('Simpan') }}
        </x-button>
    </x-slot>
</x-form-section>
