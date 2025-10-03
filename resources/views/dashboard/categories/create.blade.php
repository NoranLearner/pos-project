@extends('layouts.dashboard.app')

@section('title', 'Categories')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li><a href="{{ route('dashboard.categories.index') }}"><i class="fa fa-tag"></i>
                        @lang('site.categories')</a>
                </li>
                <li class="active">@lang('site.category_add')</li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.category_add')</h1>

        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-body">

                    @include('partials._errors')

                    {{-- https://flowbite.com/docs/components/forms/ --}}

                    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
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
                            <img src="{{ asset('dashboard_files/img/default-image.png') }}" style="width: 130px"
                                class="img-thumbnail image-preview" id="image-prv" alt="category image">
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

                        {{-- Choose Parent category --}}
                        <div class="mb-5">
                            <label for="parent" class="block mb-4 text-xl font-medium text-gray-900">@lang('site.parent')</label>
                            <select id="parent" name="parent"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option @selected(old('parent') == null) value="">@lang('site.select_parent')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('parent') == $category->id))>
                                        {{ $category->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
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
    <script>
        document.getElementById("image").value = '';
    </script>
@endpush
