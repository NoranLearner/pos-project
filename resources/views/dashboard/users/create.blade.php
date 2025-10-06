@extends('layouts.dashboard.app')

@section('title', 'Add User')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li><a href="{{ route('dashboard.users.index') }}"><i class="fa fa-user-plus"></i> @lang('site.users')</a>
                </li>
                <li class="active">@lang('site.user_add')</li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.user_add')</h1>

        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-body">

                    @include('partials._errors')

                    {{-- https://flowbite.com/docs/components/forms/ --}}

                    <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- Image --}}
                        <div class="mb-5">
                            <label for="image"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.image')</label>
                            <input type="file" id="image" name="image"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg  rounded-lg focus:outline-none cursor-pointer w-auto p-2.5"
                                required value="" onchange="showPreview(event)">
                            @error('image')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-5">
                            <img src="{{ asset('dashboard_files/img/default.jpg') }}" style="width: 100px"
                                class="img-thumbnail image-preview" id="image-prv" alt="user image">
                        </div>

                        {{-- Name --}}
                        <div class="mb-5">
                            <label for="name"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.name')</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="@lang('site.name')" required />
                            @error('name')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="email"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.email')</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="@lang('site.email')" required />
                            @error('email')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-5">
                            <label for="password"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.password')</label>
                            <input type="password" id="password" name="password"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                            @error('password')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-5">
                            <label for="repeat-password"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.confirm_password')</label>
                            <input type="password" id="repeat-password" name="password_confirmation"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                            @error('password_confirmation')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="mb-5">
                            <label for="role" class="block mb-4 text-xl font-medium text-gray-900"> @lang('site.role')
                            </label>
                            <select id="role" name="role"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">@lang('site.select_role')</option>
                                {{-- <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option> --}}
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @selected($role->name == old('role'))>{{$role->display_name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Permission Tabs --}}
                        <div class="mb-5">

                            <label class="block mb-4 text-xl font-medium text-gray-900">@lang('site.permissions')</label>

                            <div class="nav-tabs-custom">

                                @php
                                    $models = ['users', 'categories', 'products', 'clients', 'orders'];
                                    $maps = ['create', 'read', 'update', 'delete'];
                                @endphp

                                <ul class="nav nav-tabs">
                                    @foreach ($models as $index => $model)
                                        <li class="{{ $index == 0 ? 'active' : '' }}">
                                            <a href="#{{ $model }}" data-toggle="tab" class="text-xl font-medium text-gray-900">
                                                @lang('site.' . $model) </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach ($models as $index => $model)
                                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">
                                            @foreach ($maps as $map)
                                                <label class="ms-4 font-medium text-gray-900">
                                                    <input type="checkbox" name="permissions[]" value="{{ $model . '_' . $map }}">
                                                    @lang('site.' . $map)
                                                </label>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            @error('permissions')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror

                        </div>
                        {{-- End Permission Tabs --}}

                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white !font-medium rounded-lg py-2 px-4 focus:ring-2 focus:outline-none focus:ring-green-300">
                            <i class="fa fa-plus ml-2"></i> @lang('site.add')
                        </button>

                    </form>

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section>

    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById("image").value = '';
    </script>
@endpush
