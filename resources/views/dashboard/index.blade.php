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

                <div class="flex flex-row flex-wrap flex-grow mt-2">

                    <div class="w-full xl:w-1/2 p-6">

                        <!--Graph Card - Bar Chart-->

                        <div class="bg-white border-transparent rounded-lg shadow-xl">

                            <div
                                class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-3">
                                <h2 class="font-bold uppercase text-gray-600">@lang('site.today_sales')</h2>
                            </div>

                            <div class="p-5">

                                <div class="chart-container" style="position: relative; height:400px; width:400px; margin: auto;">
                                    <canvas id="barChart"></canvas>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="w-full xl:w-1/2 p-6">

                        <!--Graph Card - Pie Chart-->

                        <div class="bg-white border-transparent rounded-lg shadow-xl">

                            <div
                                class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-3">
                                <h class="font-bold uppercase text-gray-600">@lang('site.completed_orders')</h>
                            </div>

                            <div class="p-5">

                                <div class="chart-container" style="position: relative; height:400px; width:400px; margin: auto;">
                                    <canvas id="pieChart"></canvas>
                                </div>

                                {{-- <canvas id="doughnutChart"></canvas> --}}


                            </div>

                        </div>

                    </div>

                </div>

            {{-- !-------------------------------------------- End Graph Card --------------------------------------------! --}}

        </section>

    </div>

@endsection

@push('scripts')

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

    <script type="module">

        // For Bar Chart

        const ctx = document.getElementById('barChart').getContext('2d');

        fetch("{{ route('dashboard.sales') }}")
            .then(response => response.json())
            .then(json => {
                const barChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: json.labels,
                        datasets: [{
                            label: json.datasets.label,
                            data: json.datasets.data,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.6)",
                                "rgba(255, 159, 64, 0.6)",
                                "rgba(255, 205, 86, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                                "rgba(201, 203, 207, 0.6)"
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(255, 159, 64, 1)",
                                "rgba(255, 205, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(201, 203, 207, 1)"
                            ],
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            })

        // For Bie Chart

        const pieCtx = document.getElementById('pieChart').getContext('2d');

        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: @json($orders_labels),
                datasets: [{
                    data: @json($orders_data),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 205, 86, 0.6)',
                        'rgb(255, 99, 132, 0.6)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // For Doughnut Chart

        // const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');

        // new Chart(doughnutCtx, {
        //     type: 'doughnut',
        //     data: {
        //         labels: labels,
        //         datasets: [{
        //             data: data,
        //             backgroundColor: [
        //                 'rgba(255, 99, 132, 0.6)',
        //                 'rgba(54, 162, 235, 0.6)',
        //                 'rgba(255, 206, 86, 0.6)',
        //                 'rgba(75, 192, 192, 0.6)'
        //             ],
        //             borderColor: [
        //                 'rgba(255, 99, 132, 1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',
        //                 'rgba(75, 192, 192, 1)'
        //             ],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         cutout: '70%', // للتحكم في حجم الفتحة الداخلية
        //         plugins: {
        //             legend: {
        //                 position: 'bottom'
        //             }
        //         }
        //     }
        // });

    </script>
@endpush
