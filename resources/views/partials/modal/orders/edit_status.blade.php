<!-- Change Sale Price Modal -->
{{-- https://flowbite.com/docs/components/modal/ --}}

<div class="modal fade justify-center items-center" id="editStatusModal{{ $order->id }}" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            {{-- Modal header --}}
            <div class="modal-header">
                <h5 class="modal-title">@lang('site.change_status')</h5>
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
            {{--  --}}
            <div class="modal-body !min-h-[250px]">
                <form action="{{ route('dashboard.orders.status', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="order_id" name="order_id" value='{{ $order->id }}'>

                    <div class="mb-5">
                        @lang('site.client_name') : <span class="text-gray-900">{{ $order->client->name }}</span>
                    </div>

                    <div class="mb-5">
                        @lang('site.order_price') : <span class="text-gray-900">{{ $order->total_price }} @lang('site.currency')</span>
                    </div>

                    <div class="mb-5">
                        <label for="status" class="block mb-4 text-lg font-medium text-gray-900">@lang('site.status')</label>
                        <select name="status" id="status"
                            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option @selected(old('status') == null) value="">{{ __('site.select_status') }}</option>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>@lang('site.pending')</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>@lang('site.completed')</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>@lang('site.cancelled')</option>
                        </select>
                    </div>

                    <div class="absolute end-8 bottom-8">
                        <button type="submit"
                            class="btn px-5 py-2.5 ms-3 text-lg !text-white font-medium focus:outline-none bg-blue-500 hover:bg-blue-600 rounded-lg focus:ring-4 focus:ring-blue-100">
                            @lang('site.update')
                        </button>
                        <button type="button" data-dismiss="modal"
                            class="px-5 py-2.5 ms-3 text-lg font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100">
                            @lang('site.cancel')
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>

</div>
