@extends('layouts.dashboard.app')

@section('title', 'orders')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li class="active">
                    <a href="{{ route('dashboard.orders.index') }}"><i class="fa fa-ticket"></i> @lang('site.orders')</a>
                </li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">
                @lang('site.orders')
            </h1>

        </section>

        <section class="content flex flex-col xl:flex-row gap-4">

            <!-- Column 1 Content - Orders -->

            <div class="box box-primary flex-1 basis-2/3 p-4">

                <div class="box-header">

                    <h2 class="my-5 font-semibold !text-gray-700 text-2xl">@lang('site.orders')</h2>

                    <div class="flex items-center">

                        {{-- Delete All --}}
                        <div class="w-full flex-auto">
                            {{-- Delete All Button --}}
                            @if (auth()->user()->hasPermission('orders_delete'))
                                {{-- Using Modal --}}
                                <button type="button" id="deleteAllButton"
                                    class="btn mx-4 btn-danger hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                    <i class="fa fa-trash"></i> @lang('site.delete_all')
                                </button>
                                {{-- @include('partials.modal.clients.delete_all') --}}
                            @else
                                <button class="btn m-4 btn-danger opacity-50 cursor-not-allowed hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                    <i class="fa fa-trash"></i> @lang('site.delete_all')
                                </button>
                            @endif
                        </div>

                        {{-- Search Input --}}
                        <div class="w-full flex-auto">
                            <form class="max-w-md mx-auto" action="{{ route('dashboard.orders.index') }}" method="get">
                                <label for="default-search" class="mb-2 text-lg font-medium text-gray-900 sr-only">@lang('site.search')</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search" name="search" value="{{ request()->search }}" class="block w-full p-3 ps-10 text-lg text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="@lang('site.search')"/>
                                    <button type="submit"
                                        class="btn absolute end-1.5 bottom-1 bg-blue-700 hover:bg-blue-800 text-white hover:text-white text-md font-medium px-4 py-2 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300">
                                        @lang('site.search')
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="box-body">

                    @if ($orders->count() > 0)

                        {{-- https://flowbite.com/docs/components/tables/ --}}

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                            <table class="my-table w-full text-xl text-left rtl:text-right text-gray-500">

                                <thead class="text-lg text-gray-700 uppercase bg-gray-50">

                                    <tr>

                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="select_all" name="select_all" type="checkbox"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                                <label for="select_all" class="sr-only">checkbox</label>
                                            </div>
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.client_name')
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.created_at')
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.order_status')
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.order_price')
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.action')
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($orders as $order)

                                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                                            {{-- For Checkbox --}}
                                            {{-- Canceled Orders Delete All --}}
                                            <td class="w-4 p-4">
                                                <div class="flex items-center">
                                                    <input id="delete_select-{{ $order->id }}" class="delete_select" name="delete_select" type="checkbox" value="{{ $order->id }}"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                                    <label for="delete_select-{{ $order->id }}" class="sr-only">checkbox</label>
                                                </div>
                                            </td>

                                            {{-- For Client Name And Image --}}
                                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                @if ($order->client->image)
                                                    <img class="w-12 h-12 rounded-full"
                                                        src="{{ asset('dashboard/imgs/clients/' . $order->client->image->file) }}" alt="client image">
                                                @else
                                                    <img class="w-12 h-12 rounded-full"
                                                        src="{{ asset('dashboard_files/img/default.jpg') }}" alt="client image">
                                                @endif
                                                <div class="ps-3">
                                                    <div class="text-gray-500 font-semibold">{{ $order->client->name }}</div>
                                                </div>
                                            </th>

                                            {{-- For Created At --}}
                                            <td class="px-6 py-4">
                                                <div class="font-semibold text-gray-500">{{ $order->created_at->diffForHumans() }}</div>
                                                {{-- <div class="font-semibold text-gray-500">{{ $order->created_at->toFormattedDateString() }}</div> --}}
                                            </td>

                                            {{-- For Status --}}
                                            <td class="px-6 py-4">
                                                <div class="font-semibold text-gray-500">

                                                    @if ($order->status == 'pending')

                                                        <span class="text-yellow-500">@lang('site.pending')</span>

                                                    @elseif ( $order->status == 'canceled' )

                                                        <span class="text-red-500">@lang('site.cancelled')</span>

                                                    @elseif ( $order->status == 'completed' )

                                                        <span class="text-green-500">@lang('site.completed')</span>

                                                    @endif
                                                </div>
                                            </td>

                                            {{-- For Price --}}
                                            <td class="px-6 py-4">
                                                <div class="font-semibold text-gray-500">{{ $order->total_price }} @lang('site.currency')</div>
                                            </td>

                                            {{-- For Action --}}
                                            <td class="px-6 py-4">

                                                {{-- For Show Order Details --}}
                                                @if (auth()->user()->hasPermission('orders_read'))
                                                    <button type="button"
                                                        data-url="{{ route('dashboard.orders.show', $order->id) }}"
                                                        data-method="get"
                                                        class="orderProducts btn bg-sky-500 hover:bg-sky-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-sky-300">
                                                        <i class="fa fa-eye"></i> @lang('site.view')
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        class="btn opacity-50 cursor-not-allowed bg-sky-500 hover:bg-sky-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-sky-300">
                                                        <i class="fa fa-eye"></i> @lang('site.view')
                                                    </button>
                                                @endif

                                                {{-- For Edit --}}
                                                @if (auth()->user()->hasPermission('orders_update'))
                                                    <a href="{{ route('dashboard.clients.orders.edit', ['client' => $order->client, 'order' => $order]) }}"
                                                        class="btn bg-blue-500 hover:bg-blue-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                        <i class="fa fa-edit"></i> @lang('site.edit')
                                                    </a>
                                                @else
                                                    <a href="#" class="btn bg-blue-500 opacity-50 cursor-not-allowed text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                        <i class="fa fa-edit"></i> @lang('site.edit')
                                                    </a>
                                                @endif

                                                {{-- For Delete --}}
                                                @if (auth()->user()->hasPermission('orders_delete'))

                                                    {{-- Using Modal --}}
                                                    <button type="button" class="btn btn-danger hover:bg-red-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300"
                                                        data-toggle="modal" data-target="#deleteModal-{{ $order->id }}">
                                                        <i class="fa fa-trash"></i> @lang('site.delete')
                                                    </button>
                                                    {{-- @include('partials.modal.categories.delete', ['category' => $category]) --}}

                                                @else
                                                    <button class="btn btn-danger opacity-50 cursor-not-allowed hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                                        <i class="fa fa-trash"></i> @lang('site.delete')
                                                    </button>
                                                @endif

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                            <div class="mr-4">
                                {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>

                        </div>

                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

            <!-- Column 2 Content - Order Details -->

            <div class="box box-primary flex-1 basis-1/3 p-4">

                <div class="box-header">
                    <h2 class="my-5 font-semibold !text-gray-700 text-2xl">@lang('site.order_details')</h2>
                </div>

                <div class="box-body">
                    {{-- @include('dashboard.orders.order_details') --}}
                    <div id="myOrderDetails"></div>
                </div>

            </div>

        </section>

    </div>

@endsection
