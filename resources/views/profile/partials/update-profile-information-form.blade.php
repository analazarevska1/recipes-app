<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>

        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <div class="mt-4">

            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                        focus:border-green-500 focus:ring focus:ring-green-200 
                        focus:ring-opacity-50"> {{ old('bio', $user->bio) }}</textarea>

            <x-input-error class="mt-2" :messages="$errors->get('bio')" />


        </div>
        <div class="mt-4 flex flex-col items-center">
            <x-input-label for="profile_image" :value="__('Profile Image')" />
        
            <input id="profile_image" name="profile_image" type="file" class="hidden" onchange="previewImage(event)" />
        
            <label for="profile_image"
                   class="block text-sm text-green-700 bg-green-100 hover:bg-green-200
                          rounded-md px-4 py-2 text-center mt-2 cursor-pointer">
                Choose Profile Image
            </label>
        
            <!-- Single image container -->
            <div id="image-preview" class="mt-2">
                @php
                    $imagePath = $user->profile_image ? asset('storage/profile_image/' . $user->profile_image) : "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png";
                @endphp
                <img id="profile-image-display" 
                     src="{{ $imagePath ?? 'https://via.placeholder.com/96' }}" 
                     alt="Profile Image" 
                     class="w-24 h-24 rounded-full object-cover border border-gray-300" />
            </div>
        </div>
        
        <script>
        function previewImage(event) {
            const display = document.getElementById('profile-image-display');
            display.src = URL.createObjectURL(event.target.files[0]);
        }
        </script>
        




        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
