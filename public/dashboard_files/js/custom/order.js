$(document).ready(function () {

    $(document).on('click', '.addProductButton', function (e) {

        e.preventDefault();

        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = parseFloat($(this).data('price')).toFixed(2);
        var translation = $(this).data('translation');

        $(this).removeClass('bg-green-500 hover:bg-green-600 focus:ring-green-300').addClass('disabled bg-gray-500 !opacity-40');

        var html =
            `<tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                <td class="px-6 py-4"><div class="font-normal text-gray-500">${name}</div></td>
                <td class="px-6 py-4"><input type="number" name="products[${id}][quantity]" data-price="${price}" class="productQuantity w-28 bg-gray-50 border border-gray-300 text-gray-500 rounded-lg focus:ring-blue-500 focus:border-blue-500 block py-2 px-4" min="1" value="1"/></td>
                <td class="px-6 py-4"><div class="font-normal text-gray-500 productPrice">${price}</div></td>
                <td class="px-6 py-4"><button type="button" data-id="${id}" class="removeProductButton btn m-4 btn-danger hover:bg-red-600 text-white hover:text-white font-medium py-2 px-4 rounded-lg focus:ring-2 focus:outline-none focus:ring-red-300"><i class="fa fa-trash"></i> ${translation}</button></td>
            </tr>`;

        $('.orderList').append(html);

        calculateTotal();

    });

    $(document).on('click', '.removeProductButton', function (e) {

        // alert('remove button clicked');

        e.preventDefault();

        var id = $(this).data('id');

        $(this).closest('tr').remove();

        $('#product-' + id).removeClass('disabled bg-gray-500 !opacity-40').addClass('bg-green-500 hover:bg-green-600 focus:ring-green-300');

        calculateTotal();

    });

    $(document).on('keyup change', '.productQuantity', function () {

        var quantity = parseFloat($(this).val());

        var price = parseFloat($(this).data('price'));

        $(this).closest('tr').find('.productPrice').html(parseFloat(quantity * price).toFixed(2));

        calculateTotal();

    });

});

function calculateTotal() {

    var price = 0;

    $('.orderList .productPrice').each(function (index) {

        price += parseFloat($(this).html());

    });

    $('.orderTotalPrice').html(parseFloat(price).toFixed(2));

    // console.log(price);

    //check if price > 0
    if (price > 0) {

        $('#addOrder').removeClass('disabled');
        // console.log('price is greater than 0');

    } else {

        $('#addOrder').addClass('disabled');
        // console.log('price is 0');
    }

}
