@extends('layouts.dashboard.app')

@section('title', 'Products')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li class="active">
                    <a href="{{ route('dashboard.products.index') }}">
                        <i class="fa fa-cart-arrow-down"></i>
                        @lang('site.products')
                    </a>
                </li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.products')</h1>

        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">

                    <div class="flex items-center">

                        <div class="w-full flex-auto">

                            {{-- Delete All Button --}}
                            @if (auth()->user()->hasPermission('products_delete'))
                            {{-- Using Modal --}}
                            <button type="button" id="deleteAllButton"
                                class="btn m-4 btn-danger hover:bg-red-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                <i class="fa fa-trash"></i> @lang('site.delete_all')
                            </button>
                            @include('partials.modal.products.delete_all')
                            @else
                            <button
                                class="btn m-4 btn-danger opacity-50 cursor-not-allowed hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                <i class="fa fa-trash"></i> @lang('site.delete_all')
                            </button>
                            @endif

                            {{-- Add Product Button --}}
                            @if (auth()->user()->hasPermission('products_create'))
                                <a href="{{ route('dashboard.products.create') }}"
                                    class="btn m-4 bg-green-500 hover:bg-green-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-green-300">
                                    <i class="fa fa-plus"></i> @lang('site.product_add')
                                </a>
                            @else
                                <a href="#"
                                    class="btn m-4 bg-green-500 opacity-50 cursor-not-allowed text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-green-300">
                                    <i class="fa fa-plus"></i> @lang('site.product_add')
                                </a>
                            @endif

                        </div>

                        {{-- Search input --}}
                        <div class="w-full flex-auto m-4"></div>

                    </div>

                </div>

                <div class="box-body">

                    @if ($products->count() > 0)

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
                                            @lang('site.image')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.name')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.product_category')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.description')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.purchase_price')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.sale_price')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.stock')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.status')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.action')
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($products as $product)

                                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                                            {{-- For Checkbox --}}
                                            <td class="w-4 p-4">
                                                <div class="flex items-center">
                                                    <input id="delete_select-{{ $product->id }}" class="delete_select" name="delete_select" type="checkbox" value="{{ $product->id }}"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                                    <label for="delete_select-{{ $product->id }}" class="sr-only">checkbox</label>
                                                </div>
                                            </td>

                                            {{-- For Image --}}
                                            <td class="p-4">
                                                @if ($product->newestImage)
                                                    <img class="w-16 md:w-36 max-w-full max-h-full"
                                                        src="{{ asset('dashboard/imgs/products/' . $product->newestImage->file) }}" alt="product image">
                                                @else
                                                    <img src="{{ asset('dashboard_files/img/default-image.png') }}" class="w-16 md:w-36 max-w-full max-h-full"
                                                        alt="product image">
                                                @endif
                                            </td>

                                            {{-- For Name --}}
                                            <td class="px-6 py-4">
                                                <div class="font-semibold text-gray-500">{{ $product->name }}</div>
                                            </td>

                                            {{-- For Category --}}
                                            <td class="px-6 py-4">
                                                <div class="font-normal text-gray-500">
                                                    @if ($product->category)
                                                        {{ $product->category->name }}
                                                    @else
                                                        @lang('site.no_category')
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- For Description --}}
                                            <td class="px-6 py-4">
                                                <div class="font-normal text-gray-500">
                                                    {!! Str::limit($product->description, 20, ' ....') !!}
                                                </div>
                                            </td>

                                            {{-- For Purchase Price --}}
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-500">
                                                    {{ number_format($product->prices->last()->purchase_price) ?? __('site.empty_price') }}
                                                </div>
                                            </td>

                                            {{-- For Sale Price --}}
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-500">
                                                    @if (auth()->user()->hasPermission('products_update'))
                                                        <button class="btn btn-link hover:no-underline focus:no-underline" data-toggle="modal" data-target="#editSalePriceModal{{ $product->id }}">
                                                            {{ number_format($product->currentSalePrice?->sale_price) ?? __('site.empty_price') }}
                                                            <i class="fa fa-edit m-3"></i>
                                                        </button>
                                                        @include('partials.modal.products.edit_sale_price', ['product' => $product])
                                                    @else
                                                        {{ number_format($product->currentSalePrice?->sale_price) ?? __('site.empty_price') }}
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- For Stock --}}
                                            <td class="px-6 py-4">
                                                <div class="font-normal text-gray-500">
                                                    {{ $product->stock }}
                                                </div>
                                            </td>

                                            {{-- For Status --}}
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    @if ($product->deleted_at == '')
                                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> {{ __('site.active') }}
                                                    @else
                                                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div> {{ __('site.inactive') }}
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- For Action --}}
                                            <td class="px-6 py-4">

                                                {{-- For Edit --}}
                                                @if (auth()->user()->hasPermission('products_update'))
                                                    <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                                        class="btn bg-blue-500 hover:bg-blue-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                        <i class="fa fa-edit"></i> @lang('site.edit')
                                                    </a>
                                                @else
                                                    <a href="#" class="btn bg-blue-500 opacity-50 cursor-not-allowed text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                        <i class="fa fa-edit"></i> @lang('site.edit')
                                                    </a>
                                                @endif

                                                {{-- For Delete --}}
                                                @if (auth()->user()->hasPermission('products_delete'))

                                                    {{-- For Change Status --}}
                                                    @if ($product->deleted_at == '')
                                                        <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn bg-gray-400 hover:bg-gray-500 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-gray-300">
                                                                <i class="fa fa-gear"></i> @lang('site.deactivate')
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('dashboard.products.restore', $product->id) }}"
                                                            class="btn bg-gray-400 hover:bg-gray-500 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-gray-300">
                                                            <i class="fa fa-gear"></i> @lang('site.activate')
                                                        </a>
                                                    @endif

                                                    {{-- Using Modal --}}
                                                    <button type="button" class="btn btn-danger hover:bg-red-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300"
                                                        data-toggle="modal" data-target="#deleteModal-{{ $product->id }}">
                                                        <i class="fa fa-trash"></i> @lang('site.delete')
                                                    </button>
                                                    @include('partials.modal.products.delete', ['product' => $product])

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
                                {{-- {{ $products->links('pagination::bootstrap-4') }} --}}
                                {{-- {{ $products->links('vendor.pagination.tailwind') }} --}}
                                {{-- {{ $products->links('pagination::tailwind') }} --}}
                                {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>

                        </div>

                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section>

    </div>

@endsection
