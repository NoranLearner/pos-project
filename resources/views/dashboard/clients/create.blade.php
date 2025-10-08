@extends('layouts.dashboard.app')

@section('title', 'Add Client')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li><a href="{{ route('dashboard.clients.index') }}"><i class="fa fa-user-plus"></i> @lang('site.clients')</a>
                </li>
                <li class="active">@lang('site.client_add')</li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.client_add')</h1>

        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-body">

                    @include('partials._errors')

                    {{-- https://flowbite.com/docs/components/forms/ --}}

                    <form action="{{ route('dashboard.clients.store') }}" method="post" enctype="multipart/form-data">
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
                                class="img-thumbnail image-preview" id="image-prv" alt="client image">
                        </div>

                        {{-- Name --}}
                        <div class="mb-5">
                            <label for="name"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.client_name')</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="@lang('site.name')" required />
                            @error('name')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="mb-5">

                            <label for="phones" class="block mb-4 text-xl font-medium text-gray-900">@lang('site.phone')</label>

                            <div class="flex" id="phonesContainer">

                                <input type="text" id="phones" name="phones[]" value=""
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg !rounded-s-lg !rounded-e-none focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="@lang('site.phone')" required />

                                <button type="button" id="addPhone" class="btn bg-blue-500 hover:bg-blue-600 text-white hover:text-white focus:text-white !rounded-s-none !rounded-e-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-blue-300 w-full sm:w-auto text-center">
                                    <i class="fa fa-plus"></i>
                                </button>

                            </div>

                            @error('phones.*')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror

                        </div>

                        {{-- Address --}}
                        <div class="mb-5">
                            <label for="address"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.current_address')</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="@lang('site.current_address')" required />
                            @error('address')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white !font-medium rounded-lg py-2 px-4 focus:ring-2 focus:outline-none focus:ring-green-300">
                            <i class="fa fa-plus ml-2"></i> @lang('site.add')
                        </button>

                    </form>

                </div>

            </div>

        </section>

    </div>

@endsection

@push('scripts')

    <script>
        document.getElementById("image").value = '';
    </script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const myContainer = document.getElementById('phonesContainer');
            const myInput = document.getElementById('phones');
            const addButton = document.getElementById('addPhone');

            addButton.addEventListener('click', function () {

                const newInput = document.createElement('input');
                newInput.type = 'text';
                newInput.placeholder = '@lang('site.phone')';
                newInput.classList.add('shadow-xs', 'bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-lg', 'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-2.5', 'mt-5');
                newInput.name = 'phones[]';

                // Insert the new input after the existing input
                myContainer.after(newInput);
            });
        });

    </script>

@endpush
