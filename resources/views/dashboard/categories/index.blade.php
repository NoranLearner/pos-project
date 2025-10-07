@extends('layouts.dashboard.app')

@section('title', 'Categories')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li class="active">
                    <a href="{{ route('dashboard.categories.index') }}">
                        <i class="fa fa-tags"></i> @lang('site.categories')
                    </a>
                </li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.categories')</h1>

        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">

                    <div class="flex items-center">

                        <div class="w-full flex-auto">

                            {{-- Delete All Button --}}
                            @if (auth()->user()->hasPermission('categories_delete'))
                            {{-- Using Modal --}}
                            <button type="button" id="deleteAllButton"
                                class="btn m-4 btn-danger hover:bg-red-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                <i class="fa fa-trash"></i> @lang('site.delete_all')
                            </button>
                            @include('partials.modal.categories.delete_all')
                            @else
                            <button
                                class="btn m-4 btn-danger opacity-50 cursor-not-allowed hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                <i class="fa fa-trash"></i> @lang('site.delete_all')
                            </button>
                            @endif

                            {{-- Add Category Button --}}
                            @if (auth()->user()->hasPermission('categories_create'))
                                <a href="{{ route('dashboard.categories.create') }}"
                                    class="btn m-4 bg-green-500 hover:bg-green-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-green-300">
                                    <i class="fa fa-plus"></i> @lang('site.category_add')
                                </a>
                            @else
                                <a href="#"
                                    class="btn m-4 bg-green-500 opacity-50 cursor-not-allowed text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-green-300">
                                    <i class="fa fa-plus"></i> @lang('site.category_add')
                                </a>
                            @endif

                            {{-- Export Excel --}}
                            @if (auth()->user()->hasPermission('categories_read'))
                                <a href="{{ route('dashboard.categories.export') }}"
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

                        {{-- Search input --}}
                        <div class="w-full flex-auto m-4">
                            <form class="max-w-md mx-auto" action="{{ route('dashboard.categories.index') }}" method="get">
                                <label for="default-search"
                                    class="mb-2 text-lg font-medium text-gray-900 sr-only">@lang('site.search')</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search" name="search" value="{{ request()->search }}"
                                        class="block w-full p-3 ps-10 text-lg text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="@lang('site.search')" />
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

                    @if ($categories->count() > 0)

                        {{-- https://flowbite.com/docs/components/tables/ --}}

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                            <table class="my-table w-full text-xl text-left rtl:text-right text-gray-500" id="myTable">

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
                                            @lang('site.parent')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.description')
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

                                    @foreach ($categories as $category)

                                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                                            {{-- For Checkbox --}}
                                            <td class="w-4 p-4">
                                                <div class="flex items-center">
                                                    <input id="delete_select-{{ $category->id }}" class="delete_select" name="delete_select" type="checkbox" value="{{ $category->id }}"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                                    <label for="delete_select-{{ $category->id }}" class="sr-only">checkbox</label>
                                                </div>
                                            </td>

                                            {{-- For Image --}}
                                            <td class="p-4">
                                                @if ($category->image)
                                                    <img class="w-16 md:w-36 max-w-full max-h-full"
                                                        src="{{ asset('dashboard/imgs/categories/' . $category->image->file) }}" alt="category image">
                                                @else
                                                    <img src="{{ asset('dashboard_files/img/default-image.png') }}" class="w-16 md:w-36 max-w-full max-h-full" alt="category image">
                                                @endif
                                            </td>

                                            {{-- For Name --}}
                                            <td class="px-6 py-4">
                                                <div class="font-semibold text-gray-500">{{ $category->name }}</div>
                                            </td>

                                            {{-- For Parent --}}
                                            <td class="px-6 py-4">
                                                <div class="font-normal text-gray-500">
                                                    @if ($category->parentData)
                                                        {{ $category->parentData->name }}
                                                    @else
                                                        @lang('site.no_parent')
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- For Description --}}
                                            <td class="px-6 py-4">
                                                <div class="font-normal text-gray-500">
                                                    {!! $category->description !!}
                                                </div>
                                            </td>

                                            {{-- For Status --}}
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    @if ($category->deleted_at == '')
                                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> {{ __('site.active') }}
                                                    @else
                                                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div> {{ __('site.inactive') }}
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- For Action --}}
                                            <td class="px-6 py-4">
                                                {{-- For Edit --}}
                                                @if (auth()->user()->hasPermission('categories_update'))
                                                    <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                                        class="btn bg-blue-500 hover:bg-blue-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                        <i class="fa fa-edit"></i> @lang('site.edit')
                                                    </a>
                                                @else
                                                    <a href="#" class="btn bg-blue-500 opacity-50 cursor-not-allowed text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                        <i class="fa fa-edit"></i> @lang('site.edit')
                                                    </a>
                                                @endif
                                                {{-- For Delete --}}
                                                @if (auth()->user()->hasPermission('categories_delete'))

                                                    {{-- For Change Status --}}
                                                    @if ($category->deleted_at == '')
                                                        <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn bg-gray-400 hover:bg-gray-500 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-gray-300">
                                                                <i class="fa fa-gear"></i> @lang('site.deactivate')
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('dashboard.categories.restore', $category->id) }}"
                                                            class="btn bg-gray-400 hover:bg-gray-500 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-gray-300">
                                                            <i class="fa fa-gear"></i> @lang('site.activate')
                                                        </a>
                                                    @endif

                                                    {{-- Using Modal --}}
                                                    <button type="button" class="btn btn-danger hover:bg-red-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300"
                                                        data-toggle="modal" data-target="#deleteModal-{{ $category->id }}">
                                                        <i class="fa fa-trash"></i> @lang('site.delete')
                                                    </button>
                                                    @include('partials.modal.categories.delete', ['category' => $category])

                                                @else
                                                    <button class="btn btn-danger opacity-50 cursor-not-allowed hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                                        <i class="fa fa-trash"></i> @lang('site.delete')
                                                    </button>
                                                @endif
                                                {{-- For Show Related Products --}}
                                                @if (auth()->user()->hasPermission('products_read'))
                                                    <a href="{{ route('dashboard.products.index', ['category_id' => $category->id]) }}"
                                                        class="btn bg-white hover:bg-gray-100 text-gray-600 hover:text-gray-600 font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-gray-100 border border-gray-300">
                                                        <i class="fa fa-cart-arrow-down"></i> @lang('site.related_products')
                                                    </a>
                                                @else
                                                    <a href="#" class="btn opacity-50 cursor-not-allowed bg-white hover:bg-gray-100 text-gray-600 hover:text-gray-600 font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-gray-100 border border-gray-300">
                                                        <i class="fa fa-cart-arrow-down"></i> @lang('site.related_products')
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                            <div class="mr-4">
                                {{-- {{ $categories->links('pagination::bootstrap-4') }} --}}
                                {{-- {{ $categories->links('vendor.pagination.tailwind') }} --}}
                                {{-- {{ $categories->links('pagination::tailwind') }} --}}
                                {{ $categories->appends(request()->query())->links('pagination::bootstrap-4') }}
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
    {{-- <script>
        let table = new DataTable('#myTable');
    </script> --}}
@endpush
