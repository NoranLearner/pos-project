@extends('layouts.dashboard.app')

@section('title', 'Dashboard')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li class="active"><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>
                        @lang('site.dashboard')</a></li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.dashboard')</h1>

        </section>

        <section class="content">

            {{-- !-------------------------------------------- Start Metric Card --------------------------------------------! --}}

                <div class="flex flex-wrap">

                    {{-- https://github.com/tailwindtoolbox/Admin-Template --}}

                    <!--Users (Admin - Super Admin) Card-->
                    <div class="w-full md:w-1/2 xl:w-1/4 p-6">
                        <div class="bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-xl">
                            <div class="flex flex-row items-center p-5">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-green-600"><i class="fa fa-users fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right sm:text-center">
                                    <h2 class="font-bold uppercase text-gray-600 mb-3">@lang('site.total_admins')</h2>
                                    <p class="font-bold text-3xl text-green-500">
                                        {{ $users_count }}
                                    </p>
                                </div>
                            </div>
                            <div class="bg-gradient-to-b from-green-100 to-gray-100 p-3">
                                <div class="text-gray-500 text-2xl flex justify-center">
                                    <a href="{{ route('dashboard.users.index') }}">
                                        {{ __('site.view') }}
                                        @if (app()->getLocale() == 'ar')
                                            <i class="fa fa-arrow-circle-o-left ms-3"></i>
                                        @else
                                            <i class="fa fa-arrow-circle-o-right ms-3"></i>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Products Card --}}
                    <div class="w-full md:w-1/2 xl:w-1/4 p-6">
                        <div class="bg-gradient-to-b from-pink-200 to-pink-100 border-b-4 border-pink-500 rounded-lg shadow-xl">
                            <div class="flex flex-row items-center p-5">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-pink-600"><i class="fa fa-cart-arrow-down fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right sm:text-center">
                                    <h2 class="font-bold uppercase text-gray-600 mb-3">@lang('site.total_products')</h2>
                                    <p class="font-bold text-3xl text-pink-500"">
                                        {{ $products_count }}
                                    </p>
                                </div>
                            </div>
                            <div class="bg-gradient-to-b from-pink-100 to-gray-100 p-3">
                                <div class="text-gray-500 text-2xl flex justify-center">
                                    <a href="{{ route('dashboard.products.index') }}">
                                        {{ __('site.view') }}
                                        @if (app()->getLocale() == 'ar')
                                            <i class="fa fa-arrow-circle-o-left ms-3"></i>
                                        @else
                                            <i class="fa fa-arrow-circle-o-right ms-3"></i>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Clients Card --}}
                    <div class="w-full md:w-1/2 xl:w-1/4 p-6">
                        <div class="bg-gradient-to-b from-yellow-200 to-yellow-100 border-b-4 border-yellow-500 rounded-lg shadow-xl">
                            <div class="flex flex-row items-center p-5">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-yellow-600"><i class="fa fa-users fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right sm:text-center">
                                    <h2 class="font-bold uppercase text-gray-600 mb-3">@lang('site.total_clients')</h2>
                                    <p class="font-bold text-3xl text-yellow-500"">
                                        {{ $clients_count }}
                                    </p>
                                </div>
                            </div>
                            <div class="bg-gradient-to-b from-yellow-100 to-gray-100 p-3">
                                <div class="text-gray-500 text-2xl flex justify-center">
                                    <a href="{{ route('dashboard.clients.index') }}">
                                        {{ __('site.view') }}
                                        @if (app()->getLocale() == 'ar')
                                            <i class="fa fa-arrow-circle-o-left ms-3"></i>
                                        @else
                                            <i class="fa fa-arrow-circle-o-right ms-3"></i>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Orders Card --}}
                    <div class="w-full md:w-1/2 xl:w-1/4 p-6">
                        <div class="bg-gradient-to-b from-blue-200 to-blue-100 border-b-4 border-blue-500 rounded-lg shadow-xl">
                            <div class="flex flex-row items-center p-5">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-blue-600"><i class="fa fa-ticket fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right sm:text-center">
                                    <h2 class="font-bold uppercase text-gray-600 mb-3">@lang('site.total_orders')</h2>
                                    <p class="font-bold text-3xl text-blue-500"">
                                        {{ $orders_count }}
                                    </p>
                                </div>
                            </div>
                            <div class="bg-gradient-to-b from-blue-100 to-gray-100 p-3">
                                <div class="text-gray-500 text-2xl flex justify-center">
                                    <a href="{{ route('dashboard.orders.index') }}">
                                        {{ __('site.view') }}
                                        @if (app()->getLocale() == 'ar')
                                            <i class="fa fa-arrow-circle-o-left ms-3"></i>
                                        @else
                                            <i class="fa fa-arrow-circle-o-right ms-3"></i>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            {{-- !-------------------------------------------- End Metric Card --------------------------------------------! --}}

            {{-- !-------------------------------------------- Start Graph Card --------------------------------------------! --}}
            {{-- !-------------------------------------------- End Graph Card --------------------------------------------! --}}

        </section>

    </div>

@endsection
