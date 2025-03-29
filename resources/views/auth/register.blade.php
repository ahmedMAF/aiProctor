@extends('layouts.main')

@section('title' , 'SingUp')

@section('style')
<link rel="stylesheet" href="{{asset('css/login-signup.css')}}">
@endsection

@section('section')
<section>
    <div class="content">
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h2>Create Account</h2>
            <div class="input"><input id="name" type="text" required placeholder="Name" name="name"></div>
            <div class="input"><input id="email" type="email" required placeholder="Email" name="email"></div>
            <div class="input"><input id="password" type="password" required placeholder="Password" name="password"></div>
            <div class="input"><input id="password_confirmation" type="password" required placeholder="Confirm Password" name="password_confirmation"></div>
            <div class="profile">
                <div class="label"><label for="profile">Upload Profile Image</label></div>
                <div class="input"><input id="profile" required type="file" name="profile"></div>
            </div>
            <div class="T-A-S">
                <div>
                    <input id="techer" type="radio" value="1" required name="type">
                    <label for="techer">Techer</label>
                </div>
                <div>
                    <input id="student" type="radio" value="0" required name="type">
                    <label for="student">Student</label>
                </div>
            </div>
            <input class="submit" type="submit" value="Sing Up">
        </form>
        <div>
            <a href="/login">Do you have an account?</a>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{asset('JS/main.js')}}"></script>
@endsection

{{--
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
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
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
--}}