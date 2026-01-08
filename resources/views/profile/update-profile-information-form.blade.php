<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>


    <x-slot name="form">
        <!-- Profile Photo -->

        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4 flex flex-col items-center">
            <!-- Profile Photo File Input -->
            <input type="file" id="photo" class="hidden"
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

            <x-label for="photo" value="{{ __('Photo') }}" class="text-center" />

            <!-- Current Profile Photo -->
            <div class="mt-4 relative" x-show="! photoPreview">
                <img src="{{ $this->user->profile_photo_url }}"
                    alt="{{ $this->user->name }}"
                    class="rounded-full w-24 h-24 object-cover shadow-lg transition-transform duration-300 hover:scale-105 cursor-pointer"
                    x-on:click="$refs.photo.click()">
                <div class="absolute bottom-0 right-0 bg-white rounded-full p-1 shadow-md cursor-pointer"
                    x-on:click="$refs.photo.click()">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 5a2 2 0 012-2h2a2 2 0 012 2v1h4a2 2 0 012 2v2a2 2 0 01-2 2h-4v1a2 2 0 01-2 2H6a2 2 0 01-2-2v-1H2a2 2 0 01-2-2V7a2 2 0 012-2h2V5z" />
                    </svg>
                </div>
            </div>

            <!-- New Profile Photo Preview -->
            <div class="mt-4 relative" x-show="photoPreview" style="display: none;">
                <span class="block rounded-full w-24 h-24 bg-cover bg-no-repeat bg-center shadow-lg transition-transform duration-300 hover:scale-105 cursor-pointer"
                    x-bind:style="'background-image: url(\'' + photoPreview + '\');'"
                    x-on:click="$refs.photo.click()">
                </span>
                <div class="absolute bottom-0 right-0 bg-white rounded-full p-1 shadow-md cursor-pointer"
                    x-on:click="$refs.photo.click()">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 5a2 2 0 012-2h2a2 2 0 012 2v1h4a2 2 0 012 2v2a2 2 0 01-2 2h-4v1a2 2 0 01-2 2H6a2 2 0 01-2-2v-1H2a2 2 0 01-2-2V7a2 2 0 012-2h2V5z" />
                    </svg>
                </div>
            </div>

            <!-- Remove Photo Button -->
            @if ($this->user->profile_photo_path)
            <x-secondary-button type="button" class="mt-4" wire:click="deleteProfilePhoto">
                {{ __('Remove Photo') }}
            </x-secondary-button>
            @endif

            <!-- Error Message -->
            <x-input-error for="photo" class="mt-2" />
        </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4 mt-6">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4 mt-6">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
            <p class="text-sm mt-2 text-gray-600">
                {{ __('Your email address is unverified.') }}
                <button type="button" class="underline text-indigo-600 hover:text-indigo-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    wire:click.prevent="sendEmailVerification">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
            </p>

            @if ($this->verificationLinkSent)
            <p class="mt-2 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to your email address.') }}
            </p>
            @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions" class="mt-6">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>