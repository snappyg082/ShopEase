<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>

        {{-- Profile Photo --}}
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div
            x-data="{ photoName: null, photoPreview: null }"
            class="mt-6 col-span-6 sm:col-span-4 flex flex-col items-center">
            {{-- File Input --}}
            <input
                type="file"
                id="photo"
                class="hidden"
                wire:model="photo"
                x-ref="photo"
                x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => photoPreview = e.target.result;
                        reader.readAsDataURL($refs.photo.files[0]);
                    " />

            <x-label for="photo" value="{{ __('Photo') }}" class="text-center" />

            {{-- Current Photo --}}
            <div class="mt-4 relative" x-show="!photoPreview">
                <img
                    src="{{ asset('userImage/' . $user->image) }}"
                    alt="{{ $user->name }}"
                    class="w-24 h-24 rounded-full object-cover shadow-lg cursor-pointer"
                    x-on:click="$refs.photo.click()" />

                <div
                    class="absolute bottom-0 right-0 bg-white rounded-full p-1 shadow-md cursor-pointer"
                    x-on:click="$refs.photo.click()">
                    <svg class="w-5 h-5 text-gray-100" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 5a2 2 0 012-2h2a2 2 0 012 2v1h4a2 2 0 012 2v2a2 2 0 01-2 2h-4v1a2 2 0 01-2 2H6a2 2 0 01-2-2v-1H2a2 2 0 01-2-2V7a2 2 0 012-2h2V5z" />
                    </svg>
                </div>
            </div>

            {{-- Preview Photo --}}
            <div class="mt-4 relative" x-show="photoPreview" style="display: none;">
                <span
                    class="block w-24 h-24 rounded-full bg-cover bg-center shadow-lg cursor-pointer transition-transform duration-300 hover:scale-105"
                    x-bind:style="'background-image: url(' + photoPreview + ')'"
                    x-on:click="$refs.photo.click()"></span>

                <div
                    class="absolute bottom-0 right-0 bg-white rounded-full p-1 shadow-md cursor-pointer"
                    x-on:click="$refs.photo.click()">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 5a2 2 0 012-2h2a2 2 0 012 2v1h4a2 2 0 012 2v2a2 2 0 01-2 2h-4v1a2 2 0 01-2 2H6a2 2 0 01-2-2v-1H2a2 2 0 01-2-2V7a2 2 0 012-2h2V5z" />
                    </svg>
                </div>
            </div>

            {{-- Remove Photo --}}
            @if ($user->profile_photo_path)
            <x-secondary-button
                type="button"
                class="mt-4"
                wire:click="deleteProfilePhoto">
                {{ __('Remove Photo') }}
            </x-secondary-button>
            @endif

            <x-input-error for="photo" class="mt-2" />
        </div>
        @endif
    </header>

    {{-- Email Verification --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Profile Update Form --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <p class="mt-2 text-sm text-gray-800">
                {{ __('Your email address is unverified.') }}

                <button
                    form="send-verification"
                    class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
            <p class="mt-2 text-sm font-medium text-green-600">
                {{ __('A new verification link has been sent to your email address.') }}
            </p>
            @endif
            @endif
        </div>

        {{-- Save --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">
                {{ __('Saved.') }}
            </p>
            @endif
        </div>
    </form>
</section>