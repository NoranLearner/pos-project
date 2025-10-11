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

                            {{-- Export Excel --}}
                            @if (auth()->user()->hasPermission('products_read'))
                                <a href="{{ route('dashboard.products.export') }}"
                                    class="btn m-4 bg-sky-500 hover:bg-sky-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-sky-300">
                                    <i class="fa fa-download"></i> @lang('site.export')
                                </a>
                            @else
                                <a href="#"
                                    class="btn m-4 bg-sky-500 opacity-50 cursor-not-allowed text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-sky-300">
                                    <i class="fa fa-download"></i> @lang('site.export')
                                </a>
                            @endif

                        </div>

                        {{-- For Search --}}

                        <div class="w-full flex-auto m-4">

                            {{-- https://flowbite.com/docs/forms/search-input/ --}}

                            <form class="max-w-md mx-auto" action="{{ route('dashboard.products.index') }}" method="get">
                                @csrf

                                <div class="flex">

                                    <label for="search-dropdown" class="mb-2 text-lg font-medium text-gray-900 sr-only">@lang('site.search')</label>

                                    {{-- Hidden input to store selected category_id --}}
                                    <input type="hidden" name="category_id" id="selectedCategory" value="{{ request('category_id') }}">

                                    {{-- Category Dropdown Button --}}
                                    <div class="dropdown relative">

                                        <button
                                            id="dropdownMenuButton"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                            class="btn dropdown-toggle bg-gray-100 hover:bg-gray-200 font-medium py-2.5 px-4 rounded-s-lg focus:ring-4 focus:outline-none focus:ring-gray-100 text-center text-lg text-gray-900 shrink-0 z-10 inline-flex items-center border border-gray-300     "
                                            type="button">
                                            {{-- عرض اسم القسم المختار أو كل الأقسام --}}
                                            {{-- @lang('site.all_categories') --}}
                                            {{ $categories->firstWhere('id', request('category_id'))?->name ?? __('site.all_categories') }}
                                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                            </svg>
                                        </button>

                                        <div class="dropdown-menu z-10 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                            <ul class="py-2 text-lg text-gray-700" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100" onclick="selectCategory('', '@lang('site.all_categories')')">
                                                        @lang('site.all_categories')
                                                    </button>
                                                </li>
                                                @foreach ($categories as $category)
                                                    <li class="dropdown-item">
                                                        <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100"
                                                            onclick="selectCategory('{{ $category->id }}', '{{ $category->name }}')">
                                                            {{ $category->name }}
                                                        </button>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    </div>

                                    {{-- Search input --}}
                                    <div class="relative w-full">

                                        <input type="search" id="search-dropdown" name="search" value="{{ request()->search }}"
                                            class="block w-full p-2.5 z-20 text-md text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="@lang('site.search')" />

                                        <button type="submit"
                                            class="btn absolute top-0 end-0 p-2.5 text-md font-medium h-full text-white hover:text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                            <span class="sr-only">@lang('site.search')</span>
                                        </button>

                                    </div>

                                </div>

                            </form>

                        </div>

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
                                                    {{-- {{ number_format($product->prices->last()->purchase_price) ?? __('site.empty_price') }} --}}
                                                    {{-- {{ number_format($product->currentSalePrice?->sale_price ?? 0, 2) }} --}}
                                                    {{ number_format($product->prices->last()->purchase_price ?? __('site.empty_price'), 2) }}
                                                </div>
                                            </td>

                                            {{-- For Sale Price --}}
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-500">
                                                    @if (auth()->user()->hasPermission('products_update'))
                                                        <button class="btn btn-link hover:no-underline focus:no-underline" data-toggle="modal" data-target="#editSalePriceModal{{ $product->id }}">
                                                            {{-- {{ number_format($product->currentSalePrice?->sale_price) ?? __('site.empty_price') }} --}}
                                                            {{ number_format($product->currentSalePrice?->sale_price ?? __('site.empty_price'), 2) }}
                                                            <i class="fa fa-edit m-3"></i>
                                                        </button>
                                                        @include('partials.modal.products.edit_sale_price', ['product' => $product])
                                                    @else
                                                        {{-- {{ number_format($product->currentSalePrice?->sale_price) ?? __('site.empty_price') }} --}}
                                                        {{ number_format($product->currentSalePrice?->sale_price ?? __('site.empty_price'), 2) }}
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

@push('scripts')
    <script>

        function selectCategory(id, name) {
            document.getElementById('selectedCategory').value = id;
            document.getElementById('dropdownMenuButton').innerText = name;
            // إغلاق القائمة
            // document.querySelector('.dropdown-menu').classList.add('hidden');
        }

        // فتح/إغلاق القائمة
        // document.getElementById('dropdownMenuButton').addEventListener('click', function () {
        //     document.querySelector('.dropdown-menu').classList.toggle('hidden');
        // });

    </script>
@endpush
