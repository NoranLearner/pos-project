@extends('layouts.dashboard.app')

@section('title', 'Products')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li>
                    <a href="{{ route('dashboard.products.index') }}">
                        <i class="fa fa-cart-plus"></i>
                        @lang('site.products')
                    </a>
                </li>
                <li class="active">@lang('site.product_add')</li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.product_add')</h1>

        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-body">

                    @include('partials._errors')

                    {{-- https://flowbite.com/docs/components/forms/ --}}

                    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- Images --}}
                        <div class="mb-5">
                            <label for="multiple_images"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.product_images')</label>
                            <input type="file" multiple id="multiple_images" name="images[]"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg  rounded-lg focus:outline-none cursor-pointer w-auto p-2.5"
                                required onchange="showPreviews(event)">
                            @error('images.*')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-5 flex flex-wrap gap-3" id="preview-container">
                            <img src="{{ asset('dashboard_files/img/default-image.png') }}" style="width: 130px"
                                class="img-thumbnail image-preview" alt="category image">
                        </div>

                        {{-- For Translation --}}
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                            {{-- Name --}}
                            <div class="mb-5">
                                <label for="name_{{ $localeCode }}"
                                    class="block mb-4 text-xl font-medium text-gray-900">{{ __('site.name') }} ({{ __('site.in_' . $localeCode) }})</label>
                                <input type="text" id="name_{{ $localeCode }}" name="{{ $localeCode }}[name]"
                                    value="{{ old($localeCode . '.name' ?? '') }}"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" required />
                                @error($localeCode . '.name')
                                    <span class="text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="mb-5">
                                <label for="description_{{ $localeCode }}"
                                    class="block mb-4 text-xl font-medium text-gray-900">{{ __('site.description') }} ({{ __('site.in_' . $localeCode) }})</label>
                                <textarea rows="3" id="description_{{ $localeCode }}" name="{{ $localeCode }}[description]"
                                    class="editor shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" data-lang="{{ $localeCode }}">{{ old($localeCode . '.description' ?? '') }}</textarea>
                                @error($localeCode . '.description')
                                    <span class="text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </div>

                        @endforeach

                        {{-- For purchase_price - sale_price - stock --}}
                        <div class="grid md:grid-cols-3 md:gap-6">

                            {{-- purchase_price --}}
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="purchase_price"
                                    class="block mb-4 text-xl font-medium text-gray-900">{{ __('site.purchase_price') }}</label>
                                <input type="number" id="purchase_price" name="purchase_price"
                                    value="{{ old('purchase_price' ?? '') }}"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" required />
                                @error('purchase_price')
                                    <span class="text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- sale_price --}}
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="sale_price"
                                    class="block mb-4 text-xl font-medium text-gray-900">{{ __('site.sale_price') }}</label>
                                <input type="number" id="sale_price" name="sale_price"
                                    value="{{ old('sale_price' ?? '') }}"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" required />
                                @error('sale_price')
                                    <span class="text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- stock --}}
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="stock"
                                    class="block mb-4 text-xl font-medium text-gray-900">{{ __('site.stock') }}</label>
                                <input type="number" id="stock" name="stock"
                                    value="{{ old('stock' ?? '') }}"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" required />
                                @error('stock')
                                    <span class="text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        {{-- For Category --}}
                        <div class="mb-5">
                            <label for="category_id"
                                class="block mb-4 text-xl font-medium text-gray-900">{{ __('site.product_category') }}</label>
                            <select name="category_id" id="category_id"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option @selected(old('category_id') == null) value="">{{ __('site.select_category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit --}}
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
    {{-- <script>
        document.getElementById("multiple_images").value = '';
    </script> --}}
@endpush
