$(document).ready(function () {
    setCookie = function (name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }
    window.addEventListener('store', event => {
        //document.cookie = "sel_lang="+event.detail.sel_lang;
        setCookie("sel_lang", event.detail.sel_lang, 1)
    });
    startBulkTrans = function () {
        $(".cust_overlay").fadeIn(300);
        let elementFirst = $("#start");
        let elementLast = $("#last");
        if (elementFirst.length && elementLast.length) {
            window.livewire.emit('data_manager', {'first': elementFirst.val(), "last": elementLast.val()});
            window.livewire.emit('translateBelow');
        }
    };
    window.addEventListener('bulk_trans_catcher', event => {
        $(".cust_overlay").fadeOut(300);
        $max = event.detail.translated_vals.length;
        for ($i = 0; $i < $max; $i++) {
            let element = $("#trans_holder_" + $i);
            if (element.length) {
                if (event.detail.translated_vals[$i] !== "") {
                    element.val(event.detail.translated_vals[$i]);
                }
            }
        }
    });
    saveNewTranslation = function ($id) {
        let element = $("#item_id_" + $id);
        let elementTranslated = $("#trans_holder_" + $id);
        if (element.length && elementTranslated.length) {
            window.livewire.emit('data_manager', {
                'sv_upd_val': elementTranslated.val(),
                "sv_sel_id": element.val()
            });
            window.livewire.emit('saveNewTranslation');
        }
    }
    createTranslation = function ($id) {
        $(".cust_overlay").fadeIn(300);
        let element = $("#to_trans_" + $id);
        if (element.length) {
            window.livewire.emit('data_manager', {'text_to_trans': element.val(), "id": $id});
            window.livewire.emit('createTranslation');
        }
    }
    window.addEventListener('trans_text', event => {
        $(".cust_overlay").fadeOut(300);
        let element = $("#trans_holder_" + event.detail.id);
        if (element.length) {
            element.val(event.detail.trans_text);
        }
    });
});
