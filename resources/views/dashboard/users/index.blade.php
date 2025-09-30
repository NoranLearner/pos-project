@extends('layouts.dashboard.app')

@section('title', 'Users')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li class="active"><a href="{{ route('dashboard.users.index') }}"><i class="fa fa-users"></i> @lang('site.users')</a></li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.users')</h1>

        </section>

        <section class="content">

            <div class="box box-primary">

                {{-- <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.users') <small>{{ $users->total() }}</small></h3>

                    <form action="{{ route('dashboard.users.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if (auth()->user()->hasPermission('create_users'))
                                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @endif
                            </div>

                        </div>
                    </form>

                </div> --}}

                <div class="box-body">

                    @if ($users->count() > 0)

                        {{-- https://flowbite.com/docs/components/tables/ --}}

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                            <table class="w-full text-xl text-left rtl:text-right text-gray-500">

                                <thead class="text-lg text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all-search" type="checkbox"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.name')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.email')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.role')
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            @lang('site.action')
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                            {{-- For Checkbox --}}
                                            <td class="w-4 p-4">
                                                <div class="flex items-center">
                                                    <input id="checkbox-table-search-1" type="checkbox"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                                </div>
                                            </td>
                                            {{-- For User Name And Image --}}
                                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                <img class="w-12 h-12 rounded-full" src="{{ asset('dashboard_files/img/user2-160x160.jpg') }}" alt="user image">
                                                <div class="ps-3">
                                                    <div class="text-xl font-medium">{{ $user->name }}</div>
                                                </div>
                                            </th>
                                            {{-- For Email --}}
                                            <td class="px-6 py-4">
                                                <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> Online
                                                    {{-- <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div> Offline --}}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn bg-blue-500 hover:bg-blue-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                    <i class="fa fa-edit"></i> @lang('site.edit')
                                                </a>
                                                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post" class="inline-block">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300">
                                                            <i class="fa fa-trash"></i> @lang('site.delete')
                                                        </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section>

    </div>

@endsection
