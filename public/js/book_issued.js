$(document).ready(function () {
    let refresh_elements = function (event) {
        let ndate = new Date();
        if (event && 'return_date' in event.detail) {
            ndate = new Date(event.detail.return_date);
        }
        $(".date_picker").datepicker({
            dateFormat: 'mm-dd-yy',
            altField: "#return_date",
            altFormat: 'yy-mm-dd',
            onSelect: function () {
                window.livewire.emit('data_manager', {"return_date": $('#return_date').val()});
                $('#return_date').val('');
            },
        }).datepicker("setDate", ndate);
        $(".fine_obj").on("change", function () {
            $("#fine").val($(this).val());
        });
        $(".remark_obj").on("change", function () {
            $("#remark").val($(this).val());
        });
    };
    refresh_elements(null);
    flush_data = function ($id) {
        $fine_obj = $("#fine_" + $id);
        $remark_obj = $("#remark_" + $id);
        if ($fine_obj.length) {
            $("#fine").val($fine_obj.val());
        }
        if ($remark_obj.length) {
            $("#remark").val($remark_obj.text());
        }
        window.livewire.emit('data_manager', {"fine": $("#fine").val()});
        window.livewire.emit('data_manager', {"remark": $("#remark").val()});
    }
    window.addEventListener('refresh_elements', event => {
        refresh_elements(event);
    });

});
