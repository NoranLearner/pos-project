@extends('layouts.dashboard.app')

@section('title', '403 Forbidden')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="text-center">
            <h1 class="text-9xl font-extrabold text-red-600">403</h1>
            <h2 class="text-3xl font-bold mt-4 text-gray-800">{{ __('site.403_title') }}</h2>
            <p class="mt-2 text-lg text-gray-600">{{ __('site.403_message') }}</p>
            <a href="{{ url()->previous() }}" class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                {{ __('site.back') }}
            </a>
        </div>
    </div>
@endsection
