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

                {{-- <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div> --}}

                <div class="box-body">

                    {{-- @include('partials._errors') --}}

                    {{-- https://flowbite.com/docs/components/forms/ --}}

                    <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- Image --}}
                        <div class="mb-5">
                            <label for="image" class="block mb-4 text-xl font-medium text-gray-900">@lang('site.image')</label>
                            <input type="file" id="image" name="image"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg  rounded-lg focus:outline-none cursor-pointer w-auto p-2.5"
                                required>
                        </div>
                        <div class="form-group mb-5">
                            <img src="{{ asset('dashboard_files/img/user2-160x160.jpg') }}" style="width: 100px" class="img-thumbnail image-preview" alt="">
                        </div>

                        {{-- Name --}}
                        <div class="mb-5">
                            <label for="name" class="block mb-4 text-xl font-medium text-gray-900">@lang('site.name')</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="@lang('site.name')" required />
                        </div>

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="email" class="block mb-4 text-xl font-medium text-gray-900">@lang('site.email')</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="@lang('site.email')" required />
                        </div>

                        {{-- Password --}}
                        <div class="mb-5">
                            <label for="password" class="block mb-4 text-xl font-medium text-gray-900">@lang('site.password')</label>
                            <input type="password" id="password" name="password"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-5">
                            <label for="repeat-password" class="block mb-4 text-xl font-medium text-gray-900">@lang('site.confirm_password')</label>
                            <input type="password" id="repeat-password" name="password_confirmation"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        {{-- Role --}}
                        <div class="mb-5">
                            <label for="role" class="block mb-4 text-xl font-medium text-gray-900"> @lang('site.role') </label>
                            <select id="role" name="role"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">@lang('site.select_role')</option>
                                <option value="option1">Super Admin</option>
                                <option value="option2">Admin</option>
                                <option value="option3">User</option>
                            </select>
                        </div>

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
