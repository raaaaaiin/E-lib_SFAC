$(document).ready(function () {
    var init_elements = function () {
        $('.email_status').change(function () {
            window.livewire.emit('data_manager', {"email_status": Number($(this).prop('checked'))});
        });
        $('.email_status').bootstrapToggle();
        $('.list_chk').bootstrapToggle('disable');
        $('div.toggle').each(function () {
            if ($(this).attr("disabled")) {
                $(this).addClass("disabled");
            }
        });
    };
    init_elements();
    window.addEventListener('init_toggle_btns', event => {
        init_elements();
    });
});
