$('.toggle_item').change(function () {
    $('input:hidden[id="' + $(this).attr('tmp_name') + '"]').val(Number($(this).prop('checked')));
    if ($(this).attr('tmp_name').endsWith("_hide")) {
        $alt_element = $(this).attr('tmp_name').replace("_hide", "_req");
        if ($(this).prop('checked') === true) {
            $('#' + $alt_element).data("bs.toggle").off(true);
            $('input:hidden[id="' + $alt_element + '"]').val(Number(!Number($(this).prop('checked'))));
        }
    }
});
$(document).ready(function () {
    submitForm = function ($todo) {
        var detail = $('[name*="sub_books"]');
        window.livewire.emit('data_manager', {
            'items': detail.serializeArray(),
            "todo": $todo,
            "desc": $('#desc').summernote('code')
        });
        window.livewire.emit('saveBook');
    };

    window.addEventListener('relink_js', event => {
        $("input.book_id_cls").on("change", function () {
            if ($(this).val().length >= 2) {
                window.livewire.emit('checkIfSubBookIdExist', {
                    'b_id': $("#book_id").val(),
                    "sb_id": $(this).val(),
                    "error_holder": $(this).attr("error_holder")
                });
            }
        });
    });
    window.addEventListener('refresh_selects', event => {
        $('#publisher').val(event.detail.sel_publishers);
        $('#publisher').trigger('change');
        $('#author').val(event.detail.sel_authors);
        $('#author').trigger('change');
    });


});
