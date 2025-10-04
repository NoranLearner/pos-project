$(function () {
    $('#select_all').click(function () {
        if (this.checked) {
            $('.delete_select').each(function () {
                this.checked = true;
            })
        } else {
            $('.delete_select').each(function () {
                this.checked = false;
            })
        }
    })
});

$(function () {
    $("#deleteAllButton").click(function () {

        var selected = [];

        $(".my-table input[name=delete_select]:checked").each(function () {
            selected.push(this.value);
        });

        if (selected.length > 0) {
            $('#deleteAllModal').modal('show')
            $('input[id="delete_select_id"]').val(selected);
        }
    });
});
