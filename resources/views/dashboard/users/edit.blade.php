@extends('layouts.dashboard.app')

@section('title', 'Edit User')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li><a href="{{ route('dashboard.users.index') }}"> <i class="fa fa-user"></i> @lang('site.users')</a>
                </li>
                <li class="active">@lang('site.user_edit')</li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.user_edit')</h1>

        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        {{-- Image --}}
                        <div class="mb-5">
                            <label for="image"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.image')</label>
                            <input type="file" id="image" name="image"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg  rounded-lg focus:outline-none cursor-pointer w-auto p-2.5"
                                value="" onchange="showPreview(event)">
                            @error('image')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-5">
                            @if (!$user->image)
                                <img src="{{ asset('dashboard_files/img/default.jpg') }}" style="width: 100px" class="img-thumbnail image-preview"
                                id="image-prv" alt="user image">
                            @else
                                <img src="{{ asset('dashboard/imgs/users/' . $user->image->file) }}" style="width: 100px" class="img-thumbnail image-preview"
                                id="image-prv" alt="user image">
                            @endif
                        </div>

                        {{-- Name --}}
                        <div class="mb-5">
                            <label for="name"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.name')</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                            @error('name')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="email"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.email')</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                            @error('email')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-5">
                            <label for="password"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.password')</label>
                            <input type="password" id="password" name="password"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @error('password')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password Confirmation --}}
                        {{-- <div class="mb-5">
                            <label for="password_confirmation"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.confirm_password')</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @error('password_confirmation')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div> --}}

                        {{-- Role --}}
                        <div class="mb-5">
                            <label for="role"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.role')</label>
                            <select name="role" id="role"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @foreach ($rolesList as $role)
                                    {{-- {{ $roles->contains($role->name) ? 'selected' : '' }} --}}
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ $role->display_name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Permissions Tabs --}}
                        <div class="mb-5">

                            <label class="block mb-4 text-xl font-medium text-gray-900">@lang('site.permissions')</label>

                            <div class="nav-tabs-custom">

                                @php
                                    // $models = ['users', 'categories', 'products', 'clients', 'orders'];
                                    $models = ['users', 'categories'];
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
                                                    {{--  {{ in_array($model . '_' . $map, $permissions) ? 'checked' : '' }} --}}
                                                    <input type="checkbox" name="permissions[]" value="{{ $model . '_' . $map }}" {{ $user->hasPermission($model . '_' . $map)  ? 'checked' : '' }}>
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
                            class="bg-blue-500 hover:bg-blue-600 text-white !font-medium rounded-lg py-2 px-4 focus:ring-2 focus:outline-none focus:ring-blue-300">
                            <i class="fa fa-edit ml-2"></i> @lang('site.update')
                        </button>

                    </form>

                </div>

            </div>

        </section>

    </div>

@endsection
