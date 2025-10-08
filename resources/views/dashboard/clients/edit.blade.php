@extends('layouts.dashboard.app')

@section('title', 'Edit Client')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li><a href="{{ route('dashboard.clients.index') }}"><i class="fa fa-user"></i> @lang('site.clients')</a>
                </li>
                <li class="active">@lang('site.client_edit')</li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.client_edit')</h1>

        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.clients.update', $client->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                            @if (!$client->image)
                                <img src="{{ asset('dashboard_files/img/default.jpg') }}" style="width: 100px" class="img-thumbnail image-preview"
                                id="image-prv" alt="user image">
                            @else
                                <img src="{{ asset('dashboard/imgs/clients/' . $client->image->file) }}" style="width: 100px" class="img-thumbnail image-preview"
                                id="image-prv" alt="client image">
                            @endif
                        </div>

                        {{-- Name --}}
                        <div class="mb-5">
                            <label for="name"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.name')</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $client->name) }}"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                            @error('name')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="mb-5">

                            <label for="phones" class="block mb-4 text-xl font-medium text-gray-900">@lang('site.phone')</label>

                            @foreach ($client->phones as $key => $value)

                                <div class="flex mb-5 phone-row" id="phone-{{ $key }}">

                                    <input type="text" id="phone" name="phones[]" value="{{ $value }}"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg !rounded-s-lg !rounded-e-none focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder=""/>

                                    <button type="button" class="btn removePhone bg-red-500 hover:bg-red-600 text-white hover:text-white focus:text-white !rounded-s-none !rounded-e-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-red-300 w-full sm:w-auto text-center">
                                        <i class="fa fa-times"></i>
                                    </button>

                                </div>

                            @endforeach

                            <div class="flex" id="phonesContainer">

                                <input type="text" id="phones" name="phones[]" value=""
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg !rounded-s-lg !rounded-e-none focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="@lang('site.phone')"/>

                                <button type="button" id="addPhone" class="btn bg-blue-500 hover:bg-blue-600 text-white hover:text-white focus:text-white !rounded-s-none !rounded-e-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-blue-300 w-full sm:w-auto text-center">
                                    <i class="fa fa-plus"></i>
                                </button>

                            </div>

                            @error('phones.*')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror

                        </div>

                        {{-- Address --}}
                        {{-- Address --}}
                        <div class="mb-5">
                            <label for="address"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.current_address')</label>
                            <input type="text" id="address" name="address" value="{{ old('address', $client->address) }}"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="@lang('site.current_address')" />
                            @error('address')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

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

@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const myContainer = document.getElementById('phonesContainer');
            const myInput = document.getElementById('phones');
            const addButton = document.getElementById('addPhone');

            // addButton.addEventListener('click', function () {
            //     const newInput = document.createElement('input');
            //     newInput.type = 'text';
            //     newInput.placeholder = '@lang('site.phone')';
            //     newInput.classList.add('shadow-xs', 'bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-lg', 'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-2.5', 'mt-5');
            //     newInput.name = 'phones[]';
            //     // Insert the new input after the existing input
            //     myContainer.after(newInput);
            // });

            // إضافة رقم جديد
            addButton.addEventListener('click', function () {
                const newDiv = document.createElement('div');
                newDiv.classList.add('flex', 'mb-5', 'phone-row');
                newDiv.innerHTML = `
                    <input type="text" name="phones[]" value=""
                        class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg !rounded-s-lg !rounded-e-none focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="@lang('site.phone')" />

                    <button type="button" class="btn removePhone bg-red-500 hover:bg-red-600 text-white hover:text-white focus:text-white !rounded-s-none !rounded-e-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-red-300 w-full sm:w-auto text-center">
                        <i class="fa fa-times"></i>
                    </button>
                `;
                myContainer.before(newDiv);
            });

            // حذف رقم عند الضغط على زر الحذف
            document.addEventListener('click', function (e) {
                if (e.target.closest('.removePhone')) {
                    const row = e.target.closest('.phone-row');
                    if (row) row.remove();
                }
            });

        });

    </script>

@endpush
