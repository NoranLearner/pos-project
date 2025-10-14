@extends('layouts.dashboard.app')

@section('title', 'Edit Order')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li><a href="{{ route('dashboard.clients.index') }}"><i class="fa fa-ticket"></i> @lang('site.clients')</a>
                </li>
                <li class="active">@lang('site.order_edit')</li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">
                @lang('site.order_edit')
                <span class="text-gray-500 text-2xl">( @lang('site.client_name') : {{ $client->name }} )</span>
            </h1>

        </section>

        <section class="content flex flex-col xl:flex-row gap-4">

            <!-- Column 1 Content - Categories -->
            <div class="box box-primary flex-1 p-4">

                <div class="box-header">
                    <h2 class="my-5 font-semibold !text-gray-700 text-2xl">@lang('site.categories')</h2>
                </div>

                <div class="box-body">

                    @if ($categories->count() > 0)

                        @foreach ($categories as $category)

                            {{-- https://flowbite.com/docs/components/accordion/ --}}

                            @php
                                // نشوف هل الكاتيجوري فيها منتج متضاف في الطلب
                                $hasOrderedProduct =
                                    $category->products->pluck('id')
                                    ->intersect($order->products->pluck('id'))
                                    ->isNotEmpty();
                            @endphp

                            <!-- قسم -->
                            <div class="border border-[#bce8f1] rounded-t-lg shadow bg-white mb-4">
                                <button
                                    class="w-full rtl:text-right px-5 py-3 flex justify-between items-center text-gray-600 font-semibold bg-[#d9edf7] transition"
                                    onclick="toggleProducts(this)">
                                    <span>{{ $category->name }}</span>
                                    <svg class="w-5 h-5 transform transition-transform duration-300 ease-in-out" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="px-6 py-4 border-t space-y-2 {{ $hasOrderedProduct ? '' : 'hidden' }}">
                                    <div class="text-gray-500">
                                        @if ($category->products->count() > 0)
                                            {{-- Products Table --}}
                                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                                <table class="my-table w-full text-xl text-left rtl:text-right text-gray-500" id="">
                                                    <thead class="text-lg text-gray-700 uppercase bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3">
                                                                @lang('site.product_name')
                                                            </th>
                                                            <th scope="col" class="px-6 py-3">
                                                                @lang('site.stock')
                                                            </th>
                                                            <th scope="col" class="px-6 py-3">
                                                                @lang('site.price')
                                                            </th>
                                                            <th scope="col" class="px-6 py-3">
                                                                @lang('site.action')
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($category->products as $product)
                                                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                                                {{-- For Name --}}
                                                                <td class="px-6 py-4">
                                                                    <div class="font-normal text-gray-500">
                                                                        {{ $product->name }}
                                                                    </div>
                                                                </td>
                                                                {{-- For Stock --}}
                                                                <td class="px-6 py-4">
                                                                    <div class="font-normal text-gray-500">
                                                                        {{ $product->stock }}
                                                                    </div>
                                                                </td>
                                                                {{-- For Price --}}
                                                                <td class="px-6 py-4">
                                                                    <div class="font-normal text-gray-500">
                                                                        {{ $product->currentSalePrice->sale_price }}
                                                                    </div>
                                                                </td>
                                                                {{-- For Action --}}
                                                                <td class="px-6 py-4">
                                                                    <div class="font-normal text-gray-500">
                                                                        <a href="#"
                                                                            id="product-{{ $product->id }}"
                                                                            data-id="{{ $product->id }}"
                                                                            data-name="{{ $product->name }}"
                                                                            data-price="{{ $product->currentSalePrice->sale_price }}"
                                                                            data-translation="{{ __('site.delete') }}"
                                                                            class="addProductButton btn m-4 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none
                                                                                    {{ in_array($product->id, $order->products->pluck('id')->toArray()) ? 'disabled bg-gray-500 !opacity-40' : 'bg-green-500 hover:bg-green-600 focus:ring-green-300' }}">
                                                                            <i class="fa fa-plus"></i> @lang('site.add')
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <h3>@lang('site.no_data_found')</h3>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

            <!-- Column 2 Content - Orders -->

            <div class="box box-primary flex-1 p-4">

                <div class="box-header">
                    <h2 class="my-5 font-semibold !text-gray-700 text-2xl">@lang('site.orders')</h2>
                </div>

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.clients.orders.update', ['client' => $client->id, 'order' => $order->id]) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                            <table class="my-table w-full text-xl text-left rtl:text-right text-gray-500" id="">

                                <thead class="text-lg text-gray-700 uppercase bg-gray-50">

                                    <tr>

                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.product_name')
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.quantity')
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.price')
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.action')
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="orderList">

                                    @foreach ($order->products as $product_order)

                                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                                            {{-- Product Order Name --}}
                                            <td class="px-6 py-4">
                                                <div class="font-normal text-gray-500">
                                                    {{ $product_order->name }}
                                                </div>
                                            </td>

                                            {{-- Product Order Quantity --}}
                                            <td class="px-6 py-4">
                                                <input type="number" name="products[{{ $product_order->id }}][quantity]" data-price="{{ $product_order->currentSalePrice->sale_price }}" class="productQuantity w-28 bg-gray-50 border border-gray-300 text-gray-500 rounded-lg focus:ring-blue-500 focus:border-blue-500 block py-2 px-4" min="1" value="{{ $product_order->pivot->quantity }}" />
                                            </td>

                                            {{-- Product Order Price --}}
                                            <td class="px-6 py-4">
                                                <div class="font-normal text-gray-500 productPrice">
                                                    {{ number_format($product_order->currentSalePrice->sale_price * $product_order->pivot->quantity, 2) }}
                                                </div>
                                            </td>

                                            {{-- For Action --}}
                                            <td class="px-6 py-4">
                                                <button type="button" data-id="{{ $product_order->id }}" class="removeProductButton btn m-4 btn-danger hover:bg-red-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                                    <i class="fa fa-trash"></i> @lang('site.delete')
                                                </button>
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        <div class="flex justify-evenly text-gray-500 text-2xl font-semibold my-8">
                            <span>@lang('site.order_total')</span>
                            <span class="orderTotalPrice">{{ number_format($order->total_price, 2) }}</span>
                        </div>

                        <div class="flex justify-center">
                            <button
                                id="editOrder"
                                class="w-full btn m-4 bg-blue-500 hover:bg-blue-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300" >
                                <i class="fa fa-edit"></i> @lang('site.order_edit')
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </section>

    </div>

@endsection

@push('scripts')
    <script>
        function toggleProducts(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>
@endpush
