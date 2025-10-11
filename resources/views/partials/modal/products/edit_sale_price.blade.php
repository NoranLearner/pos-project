<!-- Change Sale Price Modal -->
{{-- https://flowbite.com/docs/components/modal/ --}}

<div class="modal fade" id="editSalePriceModal{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            {{-- Modal header --}}
            <div class="modal-header">
                <h5 class="modal-title">@lang('site.change_sale_price')</h5>
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-lg w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-dismiss="modal" aria-label="Close">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            {{-- Modal body --}}
            <div class="modal-body">
                <form action="{{ route('dashboard.products.salePrice', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="product_id" name="product_id" value='{{ $product->id }}'>

                    <div class="mb-5">
                        <label for="name" class="block mb-4 text-lg font-medium text-gray-900">@lang('site.product_name')</label>
                        <input type="text" id="name" aria-label="disabled input" class="form-control bg-gray-100 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 cursor-not-allowed" value="{{ $product->name }}" disabled readonly>
                    </div>

                    <div class="mb-5">
                        <label for="purchase_price" class="block mb-4 text-lg font-medium text-gray-900">@lang('site.purchase_price')</label>
                        <input type="text" id="purchase_price" aria-label="disabled input" class="form-control bg-gray-100 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 cursor-not-allowed" value="{{ number_format($product->prices->last()->purchase_price ?? '', 2) }}" disabled readonly>
                        <input type="hidden" id="purchase_price" name="purchase_price" value='{{ number_format($product->prices->last()->purchase_price ?? '', 2) }}'>
                    </div>

                    <div class="mb-5">
                        <label for="sale_price" class="form-label block mb-4 text-lg font-medium text-gray-900">@lang('site.sale_price')</label>
                        <input type="number" class="form-control bg-gray-100 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5" id="sale_price" name="sale_price" value="{{ old('sale_price' ?? '') }}" required>
                    </div>

                    <div class="mb-5">
                        <label for="start_date" class="form-label block mb-4 text-lg font-medium text-gray-900">@lang('site.start_date')</label>
                        <input type="date" class="form-control bg-gray-100 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5" id="start_date" name="start_date" value="{{ old('start_date' ?? '') }}" required>
                    </div>

                    <button type="submit"
                        class="btn px-5 py-2.5 ms-3 text-lg !text-white font-medium focus:outline-none bg-blue-500 hover:bg-blue-600 rounded-lg focus:ring-4 focus:ring-blue-100">
                        @lang('site.update')
                    </button>

                    <button type="button" data-dismiss="modal"
                        class="px-5 py-2.5 ms-3 text-lg font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100">
                        @lang('site.cancel')
                    </button>

                </form>
            </div>

        </div>

    </div>

</div>
