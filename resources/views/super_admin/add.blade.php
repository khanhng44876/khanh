<x-app-layout>
    <x-slot name="header">
        <nav class="border-b border-gray-200 dark:border-gray-700 mb-4">
            <ul class="flex space-x-8">
                <li>
                    <a href="{{ route('user.manager') }}"
                       class="pb-2 {{ request()->routeIs('user.manager') ? 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600' }}">
                        User
                    </a>
                </li>
                <li>
                    <a href="{{ route('product.manager') }}"
                       class="pb-2 {{ request()->routeIs('product.manager') ? 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600' }}">
                        Product
                    </a>
                </li>
            </ul>
        </nav>
    </x-slot>
    <x-guest-layout>
        <form method="POST" action="{{ route('add.user') }}">
            @csrf
    
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <div class="mt-4">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
    
            <div class="mt-4">
                <x-input-label for="user_name" :value="__('UserName')" />
                <x-text-input id="user_name" class="block mt-1 w-full" type="text" name="user_name" :value="old('user_name')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
            </div>
    
            <div class="mt-4">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" required
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" disabled selected>-- Chọn vai trò --</option>
                    <option value="admin" >Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
    
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
    
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
    
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
    
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
    
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
    
</x-app-layout>