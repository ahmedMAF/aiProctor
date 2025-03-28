@extends('layouts.main')

@section('title' , 'Login')

@section('style')
<link rel="stylesheet" href="{{asset('css/login-signup.css')}}">
@endsection

@section('section')
<section>
    <div class="content">
        <form action="" method="">
            <h2>Login</h2>
            <div class="input"><input type="email" required placeholder="Email"></div>
            <div class="input"><input type="password" required placeholder="Password"></div>
            <div class="r-a-f">
                <div>
                    <input type="checkbox" id="Remember">
                    <label for="Remember">Remember me</label>
                </div>
                <div>
                    <a href="">Forgot Password?</a>
                </div>
            </div>
            <input class="submit" type="submit" value="Login">
        </form>
        <div>
            <a href="">Do you not have an account?</a>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{asset('JS/main.js')}}"></script>
@endsection
{{--
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
--}}