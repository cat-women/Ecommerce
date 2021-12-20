<style>
    .logo {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        top: 30px;
        margin-top: 40px;
        border-radius: 30%;

    }
</style>
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('images\logo1.png') }}" alt="theShoppingSite" class="logo">
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <!-- Phone Number -->
            <div class="mt-4">
                <x-label for="phone_no" :value="__('Phone Number')" />

                <x-input id="phone_no" class="block mt-1 w-full" type="tel" name="phone_no" required placeholder="Follow this pattern: 98-00112233"/>
            </div>

            <!--  Address -->
            <div class="mt-4">
                <x-label for="address" :value="__('Address')" />

                <x-input id="address" class="block mt-1 w-full" type="text" name="address" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4" id="register" type="button" onclick="validate()">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
<script>
    function validate(){
        var phone = document.getElementById('phone_no').value;
        var re = /[4-9]{2}-[0-9]{8}/;
        if(!re.test(phone)){
            alert('phone not valid');
            document.getElementById('phone_no').focus();
            return false;
        }
        else{
            return true;
        }
    }
</script>