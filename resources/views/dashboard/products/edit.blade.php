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
                <li class="active">@lang('site.product_edit')</li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.product_edit')</h1>

        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-body">

                    @include('partials._errors')

                    {{-- https://flowbite.com/docs/components/forms/ --}}

                    <form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        {{-- Images --}}
                        <div class="mb-5">
                            <label for="multiple_images"
                                class="block mb-4 text-xl font-medium text-gray-900">@lang('site.product_images')</label>
                            <input type="file" multiple id="multiple_images" name="images[]"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg  rounded-lg focus:outline-none cursor-pointer w-auto p-2.5"
                                onchange="showPreviews(event)">
                            @error('images.*')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-5 flex flex-wrap gap-3" id="preview-container">
                            @if (!$product->images)
                                <img src="{{ asset('dashboard_files/img/default-image.png') }}" style="width: 130px"
                                class="img-thumbnail image-preview" id="image-prv" alt="product image">
                            @else
                                @foreach ($product->images as $image)
                                    <img src="{{ asset('dashboard/imgs/products/' . $image->file) }}" style="width: 130px" class="img-thumbnail image-preview"
                                    id="image-prv" alt="product image">
                                @endforeach
                            @endif
                        </div>

                        {{-- For Translation --}}
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                            @php
                                $translations = $product->getTranslationsArray()[$localeCode];
                            @endphp

                            {{-- Name --}}
                            <div class="mb-5">
                                <label for="name_{{ $localeCode }}"
                                    class="block mb-4 text-xl font-medium text-gray-900">{{ __('site.name') }} ({{ __('site.in_' . $localeCode) }})</label>
                                <input type="text" id="name_{{ $localeCode }}" name="{{ $localeCode }}[name]"
                                    value="{{ $translations['name'] }}"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" required/>
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
                                    placeholder="" data-lang="{{ $localeCode }}">{{ $translations['description'] }}</textarea>
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
                                <input type="number" step="0.01" id="purchase_price" name="purchase_price"
                                    value="{{ number_format($product->prices->last()->purchase_price, 2) }}"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder=""/>
                                @error('purchase_price')
                                    <span class="text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- sale_price --}}
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="sale_price"
                                    class="block mb-4 text-xl font-medium text-gray-900">{{ __('site.sale_price') }}</label>
                                <input type="number" step="0.01" id="sale_price" name="sale_price"
                                    value="{{ number_format($product->currentSalePrice?->sale_price, 2) }}"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" />
                                @error('sale_price')
                                    <span class="text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- stock --}}
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="stock"
                                    class="block mb-4 text-xl font-medium text-gray-900">{{ __('site.stock') }}</label>
                                <input type="number" id="stock" name="stock"
                                    value="{{ $product->stock }}"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder=""/>
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
                                <option @selected($product->category_id == null) value="">{{ __('site.select_category') }}</option>
                                @foreach ($categories as $categorySelect)
                                    <option value="{{ $categorySelect->id }}" @selected($product->category_id == $categorySelect->id)>
                                        {{ $categorySelect->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-red-500 text-lg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit --}}
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
