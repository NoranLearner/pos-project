@extends('layouts.dashboard.app')

@section('title', 'Clients')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

                <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                    <li class="active">
                        <a href="{{ route('dashboard.clients.index') }}">
                            <i class="fa fa-users"></i> @lang('site.clients')
                        </a>
                    </li>
                </ol>

                <div class="clearfix"></div>

                <h1 class="!my-5">@lang('site.clients')</h1>

            </section>

            <section class="content">

                <div class="box box-primary">

                    <div class="box-header">

                        <div class="flex items-center">

                            <div class="w-full flex-auto">

                                {{-- Delete All Button --}}
                                @if (auth()->user()->hasPermission('clients_delete'))
                                    {{-- Using Modal --}}
                                    <button type="button" id="deleteAllButton"
                                        class="btn m-4 btn-danger hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                        <i class="fa fa-trash"></i> @lang('site.delete_all')
                                    </button>
                                    @include('partials.modal.clients.delete_all')
                                @else
                                    <button class="btn m-4 btn-danger opacity-50 cursor-not-allowed hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                        <i class="fa fa-trash"></i> @lang('site.delete_all')
                                    </button>
                                @endif

                                {{-- Add User Button --}}
                                @if (auth()->user()->hasPermission('clients_create'))
                                    <a href="{{ route('dashboard.clients.create') }}"
                                        class="btn m-4 bg-green-500 hover:bg-green-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-green-300">
                                        <i class="fa fa-plus"></i> @lang('site.client_add')
                                    </a>
                                @else
                                    <a href="#"
                                        class="btn m-4 bg-green-500 opacity-50 cursor-not-allowed text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-green-300">
                                        <i class="fa fa-plus"></i> @lang('site.client_add')
                                    </a>
                                @endif

                            </div>

                            {{-- Search input --}}
                            <div class="w-full flex-auto m-4">
                                <form class="max-w-md mx-auto" action="{{ route('dashboard.clients.index') }}" method="get">
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

                        @if ($clients->count() > 0)

                            {{-- https://flowbite.com/docs/components/tables/ --}}

                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                                <table class="my-table w-full text-xl text-left rtl:text-right text-gray-500" id="">

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
                                                @lang('site.name')
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                @lang('site.phone')
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                @lang('site.current_address')
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

                                        @foreach ($clients as $client)

                                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                                                {{-- For Checkbox --}}
                                                <td class="w-4 p-4">
                                                    <div class="flex items-center">
                                                        <input id="delete_select-{{ $client->id }}" class="delete_select" name="delete_select" type="checkbox" value="{{ $client->id }}"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                                        <label for="delete_select-{{ $client->id }}" class="sr-only">checkbox</label>
                                                    </div>
                                                </td>

                                                {{-- For User Name And Image --}}
                                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    @if ($client->image)
                                                        <img class="w-12 h-12 rounded-full"
                                                            src="{{ asset('dashboard/imgs/clients/' . $client->image->file) }}" alt="user image">
                                                    @else
                                                        <img class="w-12 h-12 rounded-full"
                                                            src="{{ asset('dashboard_files/img/default.jpg') }}" alt="user image">
                                                    @endif
                                                    <div class="ps-3">
                                                        <div class="text-gray-500 font-semibold">{{ $client->name }}</div>
                                                    </div>
                                                </th>

                                                {{-- For Phones --}}
                                                <td class="px-6 py-4">
                                                    <div class="font-normal text-gray-500">
                                                        {{ implode(' - ', $client->phones) }}
                                                    </div>
                                                </td>

                                                {{-- For Address --}}
                                                <td class="px-6 py-4">
                                                    <div class="font-normal text-gray-500">
                                                        {{ $client->address }}
                                                    </div>
                                                </td>

                                                {{-- For Status --}}
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center">
                                                        @if ($client->deleted_at == '')
                                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> {{ __('site.active') }}
                                                        @else
                                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div> {{ __('site.inactive') }}
                                                        @endif
                                                    </div>
                                                </td>

                                                {{-- For Action --}}
                                                <td class="px-6 py-4">

                                                    {{-- For Edit --}}
                                                    @if (auth()->user()->hasPermission('clients_update'))
                                                        <a href="{{ route('dashboard.clients.edit', $client->id) }}"
                                                            class="btn bg-blue-500 hover:bg-blue-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                            <i class="fa fa-edit"></i> @lang('site.edit')
                                                        </a>
                                                    @else
                                                        <a href="#" class="btn bg-blue-500 opacity-50 cursor-not-allowed text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                            <i class="fa fa-edit"></i> @lang('site.edit')
                                                        </a>
                                                    @endif

                                                    {{-- For Delete --}}
                                                    @if (auth()->user()->hasPermission('clients_delete'))

                                                        {{-- For Change Status --}}
                                                        @if ($client->deleted_at == '')
                                                            <form action="{{ route('dashboard.clients.destroy', $client->id) }}" method="post" class="inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn bg-gray-400 hover:bg-gray-500 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-gray-300">
                                                                    <i class="fa fa-gear"></i> @lang('site.deactivate')
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('dashboard.clients.restore', $client->id) }}"
                                                                class="btn bg-gray-400 hover:bg-gray-500 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-gray-300">
                                                                <i class="fa fa-gear"></i> @lang('site.activate')
                                                            </a>
                                                        @endif

                                                        {{-- Using Modal --}}
                                                        <button type="button" class="btn btn-danger hover:bg-red-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300"
                                                            data-toggle="modal" data-target="#deleteModal-{{ $client->id }}">
                                                            <i class="fa fa-trash"></i> @lang('site.delete')
                                                        </button>
                                                        @include('partials.modal.clients.delete', ['client' => $client])

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
                                    {{-- {{ $clients->links('pagination::bootstrap-4') }} --}}
                                    {{-- {{ $clients->links('vendor.pagination.tailwind') }} --}}
                                    {{-- {{ $clients->links('pagination::tailwind') }} --}}
                                    {{ $clients->appends(request()->query())->links('pagination::bootstrap-4') }}
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
