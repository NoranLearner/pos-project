<p><strong>@lang('site.client_name') : </strong> {{ $order->client->name }}</p>
<p><strong>@lang('site.created_at') : </strong> {{ $order->created_at->toFormattedDateString() }}</p>
<p><strong>@lang('site.order_status') : </strong> {{ __('site.' . $order->status) }}</p>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8">

    <table class="my-table w-full text-xl text-left rtl:text-right text-gray-500" id="">

        <thead class="text-lg text-gray-700 uppercase bg-gray-50">

            <tr>

                <th scope="col" class="px-6 py-3">
                    @lang('site.product_name')
                </th>

                <th scope="col" class="px-6 py-3">
                    @lang('site.quantity')
                </th>

                <th scope="col" class="px-6 py-3">
                    @lang('site.price')
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach($order->products as $product)

                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                    <td class="px-6 py-4">
                        {{ $product->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $product->pivot->quantity }}
                    </td>

                    <td class="px-6 py-4">
                        {{ number_format($product->pivot->quantity * $product->currentSalePrice->sale_price, 2) }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>

<div class="flex justify-evenly text-gray-500 text-2xl font-semibold my-8">
    <span>@lang('site.order_total')</span>
    <span class="orderTotalPrice">{{ number_format($order->total_price, 2) }}</span>
</div>

<div class="flex justify-center">
    <button
        class="printButton w-full btn m-4 bg-sky-500 hover:bg-sky-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-sky-300">
        <i class="fa fa-print"></i> @lang('site.print')
    </button>
</div>
