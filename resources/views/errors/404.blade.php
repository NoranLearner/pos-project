@extends('layouts.dashboard.app')

@section('title', '404 Not Found')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="text-center">
            <h1 class="text-9xl font-extrabold text-yellow-500">404</h1>
            <h2 class="text-3xl font-bold mt-4 text-gray-800">{{ __('site.404_title') }}</h2>
            <p class="mt-2 text-lg text-gray-600">
                {{ __('site.404_message') }}
            </p>
            <a href="{{ url('/') }}"
                class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                {{ __('site.back_home') }}
            </a>
        </div>
    </div>
@endsection
