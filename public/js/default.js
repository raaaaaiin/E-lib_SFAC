/**
 * Created by Andrew on 6/5/2020.
 */

async function make_ajax(type, curl, cdata = {}) {
    let result = null;
    if ($("input[name='_token']").length > 0) {
        cdata["_token"] = $("input[name='_token']").val();
    }
    try {
        result = await $.ajax({
            type: type,
            url: curl,
            beforeSend: function (request) {
                request.setRequestHeader("Accept", 'application/json');
            },
            dataType: 'JSON',
            data: cdata
        });
    } catch (error) {
        console.log(error);
    }
    //console.log(result);
    return result;
}

async function make_ajax_file(type, curl, form_jObj, file) {

    let result = null;
    let formData = form_jObj.serializeArray();
    if (file.val() !== "") {
        formData = new FormData(form_jObj[0]);
        formData.append('file', file[0].files[0]);
        try {
            result = await $.ajax({
                type: type,
                url: curl,
                dataType: 'JSON',
                data: formData,
                beforeSend: function (request) {
                    request.setRequestHeader("Accept", 'application/json');
                },
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            });
        } catch (error) {
            console.log(error);
        }
    } else {
        result = make_ajax(type, curl, formData);
    }
    //console.log(result);
    return result;
}

function msg_error(title, message) {
    iziToast.error({
        title: title,
        message: message,
        close: true,
        position: 'bottomRight'
    });
}

window.copyToClipboard = function (text) {
    var input = document.createElement('textarea');
    input.innerHTML = text;
    document.body.appendChild(input);
    input.select();
    var result = document.execCommand('copy');
    document.body.removeChild(input);
    msg_success("Info", "Copied to clipboard");
    return result;
}

function msg_warning(title, message) {
    iziToast.warning({
        title: title,
        message: message,
        close: true,
        position: 'bottomRight'
    });
}

function msg_success(title, message) {
    iziToast.success({
        title: title,
        message: message,
        close: true,
        position: 'bottomRight'
    });
}

function msg_info(title, message) {
    iziToast.info({
        title: title,
        message: message,
        close: true,
        position: 'bottomRight'
    });
}

function msg_warning_v2(title, message) {
    $.confirm({
        title: title,
        content: message,
        type: 'orange',
        typeAnimated: false,
        draggable: true,
        dragWindowBorder: false,
        buttons: {
            tryAgain: {
                text: 'OK',
                btnClass: 'btn-warning',
                action: function () {
                }
            },
            close: function () {
            }
        }
    });
}

function msg_success_v2(title, message) {
    $.confirm({
        title: title,
        content: message,
        type: 'green',
        typeAnimated: false,
        draggable: true,
        dragWindowBorder: false,
        autoClose: 'close|5000',
        buttons: {
            tryAgain: {
                text: 'OK',
                btnClass: 'btn-success',
                action: function () {
                }
            },
            close: function () {
            }
        }
    });
}

function msg_info_v2(title, message) {
    $.confirm({
        title: title,
        content: message,
        type: 'dark',
        typeAnimated: false,
        draggable: true,
        dragWindowBorder: false,
        buttons: {
            tryAgain: {
                text: 'OK',
                btnClass: 'btn-dark',
                action: function () {
                }
            },
            close: function () {
            }
        }
    });
}

function msg_error_v2(title, message) {
    $.confirm({
        title: title,
        content: message,
        type: 'red',
        typeAnimated: false,
        draggable: true,
        dragWindowBorder: false,
        buttons: {
            tryAgain: {
                text: 'OK',
                btnClass: 'btn-red',
                action: function () {
                }
            },
            close: function () {
            }
        }
    });
}

var Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: true,
    customClass: {
        confirmButton: 'btn btn-dark',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
});

function msg_warning_v3(title, message) {
    Toast.fire({
        icon: 'warning',
        title: message
    })
}

function msg_success_v3(title, message) {
    Toast.fire({
        icon: 'success',
        title: message
    })
}

function msg_info_v3(title, message) {
    Toast.fire({
        icon: 'info',
        title: message
    })
}

function msg_error_v3(title, message) {
    Toast.fire({
        icon: 'error',
        title: message
    })
}


function randomNumber() {
    return Math.floor(Math.random() * (10 - 1 + 1)) + 1;
}

/*Wrapper for server calls*/
window.addEventListener('show_message', event => {
    show_message(event.detail.type, event.detail.title, event.detail.message);
});

function show_message(type, title, message) {
    // This code basically is used to redirect current window
    if (type === "redirect") {
        window.location = message;
        return;
    }
    if ($.isPlainObject(message)) {
        $.each(message, function (key, value_message) {
            switch (type) {
                case "error":
                    msg_error_v3(title, value_message[0]);
                    break;
                case "warning":
                    msg_warning_v3(title, value_message[0]);
                    break;
                case "success":
                    msg_success_v3(title, value_message[0]);
                    break;
                default:
                    msg_info_v3(title, value_message[0]);
                    break;
            }
        });
    } else {
        switch (type) {
            case "error":
                msg_error_v3(title, message);
                break;
            case "warning":
                msg_warning_v3(title, message);
                break;
            case "success":
                msg_success_v3(title, message);
                break;
            default:
                msg_info_v3(title, message);
                break;
        }
    }
}

function getQueryString($query) {
    url = new URL(window.location.href);
    if (url.searchParams.get($query)) {
        return url.searchParams.get($query);
    } else {
        return "";
    }
}
window.addEventListener('scroll_up', event => {
document.documentElement.scrollTop=0;});
window.addEventListener('scroll_bottom', event => {
    document.documentElement.scrollHeight=100000;});
window.addEventListener('tooltip_refresh', event => {
    $('[data-toggle="tooltip"]').tooltip('dispose');
    $('[data-toggle="tooltip"]').tooltip('enable')
});
window.addEventListener('toogle_refresh', event => {
    $('[data-toggle="toggle"]').bootstrapToggle('destroy')
    $('[data-toggle="toggle"]').bootstrapToggle();
});

$('body').on('click', 'button.closeCallout', function () {
    $(this).parent().parent().remove();
});

$('body').on('click', 'button.closeCurrentCallout', function () {
    $(this).parent().remove();
});


function dialog(content, title = "") {
    if (title === "") {
        title = "Alert";
    }
    $.dialog({
        title: title,
        content: content,
    })
}

window.addEventListener('show_loading', event => {
    if ($(".cust_overlay").length) {
        $(".cust_overlay").fadeIn(event.detail.time);
    }
});
window.addEventListener('close_loading', event => {
    if ($(".cust_overlay").length) {
        $(".cust_overlay").fadeOut(event.detail.time);
    }
});

window.addEventListener('refresh_page', event => {
    window.location.reload();
});
window.addEventListener('confirm_for_be', event => {
    $.confirm({
        title: 'Confirm!',
        content: event.detail.message,
        theme: 'material',
        buttons: {
            ok: {
                text: "Ok",
                btnClass: 'btn-dark',
                action: function () {
                    $("#cust_overlay").fadeIn(300);
                    window.livewire.emit(event.detail.fn_call);
                    $("#cust_overlay").fadeOut(300);
                }
            },
            cancel: {
                text: "Cancel",
                btnClass: 'btn-danger',
                action: function () {
                }
            }
        }
    });
});

function lv_confirm_then_submit(event, contents, fn_name, fn_paramater) {

    $.confirm({
        title: 'Confirm!',
        content: contents,
        theme: 'material',
        buttons: {
            ok: {
                text: "Ok",
                btnClass: 'btn-dark',
                action: function () {
                    $("#cust_overlay").fadeIn(300);
                    window.livewire.emit(fn_name, fn_paramater);
                    $("#cust_overlay").fadeOut(300);
                }
            },
            cancel: {
                text: "Cancel",
                btnClass: 'btn-danger',
                action: function () {
                }
            }
        }
    });
}

window.addEventListener('clear_class', event => {
    let fcls = "." + event.detail.class_name;
    if ($(fcls).length) {
        $(fcls).each(function () {
            if ($(this).prop('type') !== "text") {
                $(this).text("N/A");
            } else {
                $(this).val('');
            }
        });
    }
});
window.addEventListener('clear_id', event => {
    let fcls = "#" + event.detail.id_name;
    if ($(fcls).length) {
        if ($(fcls).prop('type') !== "text") {
            $(fcls).text("N/A");
        } else {
            $(fcls).val('');
        }
    }
});
window.addEventListener('clear_query_string', event => {
window.history.replaceState(null, null, window.location.pathname);});
window.addEventListener('add_hash', event => {
    window.location.hash = event.detail.item;});
window.addEventListener('clear_form', event => {
    let fid = "#" + event.detail.form_id;
    if ($(fid).length) {
        $(fid).trigger('reset');
    }
});

function confirm_then_submit(contents, form_name) {
    $.confirm({
        title: 'Confirm!',
        content: contents,
        theme: 'material',
        buttons: {
            ok: {
                text: "Ok",
                btnClass: 'btn-dark',
                action: function () {
                    $("#cust_overlay").fadeIn(300);
                    $("#" + form_name).submit();
                    $("#cust_overlay").fadeOut(300);
                }
            },
            cancel: {
                text: "Cancel",
                btnClass: 'btn-danger',
            }
        }
    });
}

function make_sense($stat) {
    return $stat;
}

function sure(contents, callback) {
    $.confirm({
        title: 'Confirm!',
        content: contents,
        theme: 'material',
        buttons: {
            ok: {
                text: "Ok",
                btnClass: 'btn-dark',
                action: function () {
                    callback(true);
                }
            },
            cancel: {
                text: "Cancel",
                btnClass: 'btn-danger',
                action: function () {
                    callback(false);
                }
            }
        }
    });
}

function cdialog(title, content, color, callback) {
    $.confirm({
        title: title,
        content: content,
        type: color,
        typeAnimated: true,
        buttons: {
            okbtn: {
                text: "OK",
                btnClass: 'btn-' + color,
                action: function () {
                    callback(true);
                }
            },
            close: function () {
                callback(false);
            }
        }
    });
}

$(document).ready(function () {
    $(".sidebar .image .img-circle").removeClass("img-circle-sm");
    $(".sidebar .image .img-circle").addClass("img-circle-lg");
    $('[data-toggle="tooltip"]').tooltip();
});
$(document).on('expanded.pushMenu', function ($event) {
    $(".sidebar .image .img-circle").removeClass("img-circle-sm");
    $(".sidebar .image .img-circle").addClass("img-circle-lg");
});
$(document).on('collapsed.pushMenu', function ($event) {
    $(".sidebar .image .img-circle").addClass("img-circle-sm");
    $(".sidebar .image .img-circle").removeClass("img-circle-lg");
});

/* Add Vue filters */
Vue.filter('title_case', function (str) {
    return str.replace(
        /\w\S*/g,
        function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        }
    );
});
Vue.filter('time_passed', function (givenDate) {
    if (moment().subtract(7, 'days').valueOf() > moment(givenDate).valueOf()) {
        return moment(givenDate).format('llll');
    } else if (moment().subtract(1, 'days').valueOf() > moment(givenDate).valueOf()) {
        return moment(givenDate).calendar();
    } else {
        return moment(givenDate).fromNow();
    }
});

Vue.filter('trim', function (string) {
    return string.trim()
});

function toTitleCase(str) {
    return str.replace(
        /\w\S*/g,
        function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        }
    );
}


// $(document).ready(function () {
//     $big_inp_grp_text = 0;
//     $inp_grp_arr = [];
//     debugger;
//     $(".input-group-prepend").each(function () {
//         $inp_grp_arr.push($(this).width());
//     });
//     $max_width = Math.max.apply(Math, $inp_grp_arr);
//     if ($max_width != 0 && $max_width !== null) {
//         $(".input-group-text").each(function () {
//             if(!$(this).attr("done")) {
//                 $(this).css("width", $max_width);
//                 $(this).attr("done", "done");
//             }
//         });
//     }
// });

window.getAge = function (dateString) {
    var now = new Date();
    var today = new Date(now.getYear(), now.getMonth(), now.getDate());

    var yearNow = now.getYear();
    var monthNow = now.getMonth();
    var dateNow = now.getDate();

    var dob = new Date(dateString.substring(6, 10),
        dateString.substring(0, 2) - 1,
        dateString.substring(3, 5)
    );

    var yearDob = dob.getYear();
    var monthDob = dob.getMonth();
    var dateDob = dob.getDate();
    var age = {};
    var ageString = "";
    var yearString = "";
    var monthString = "";
    var dayString = "";


    yearAge = yearNow - yearDob;

    if (monthNow >= monthDob)
        var monthAge = monthNow - monthDob;
    else {
        yearAge--;
        var monthAge = 12 + monthNow - monthDob;
    }

    if (dateNow >= dateDob)
        var dateAge = dateNow - dateDob;
    else {
        monthAge--;
        var dateAge = 31 + dateNow - dateDob;

        if (monthAge < 0) {
            monthAge = 11;
            yearAge--;
        }
    }

    age = {
        years: yearAge,
        months: monthAge,
        days: dateAge
    };

    if (age.years > 1) yearString = " yrs";
    else yearString = " year";
    if (age.months > 1) monthString = " mnts";
    else monthString = " month";
    if (age.days > 1) dayString = " dys";
    else dayString = " d";


    if ((age.years > 0) && (age.months > 0) && (age.days > 0))
        ageString = age.years + yearString + ", " + age.months + monthString + ", and " + age.days + dayString + " old.";
    else if ((age.years == 0) && (age.months == 0) && (age.days > 0))
        ageString = "Only " + age.days + dayString + " old!";
    else if ((age.years > 0) && (age.months == 0) && (age.days == 0))
        ageString = age.years + yearString + " old. Happy Birthday!!";
    else if ((age.years > 0) && (age.months > 0) && (age.days == 0))
        ageString = age.years + yearString + " and " + age.months + monthString + " old.";
    else if ((age.years == 0) && (age.months > 0) && (age.days > 0))
        ageString = age.months + monthString + " and " + age.days + dayString + " old.";
    else if ((age.years > 0) && (age.months == 0) && (age.days > 0))
        ageString = age.years + yearString + " and " + age.days + dayString + " old.";
    else if ((age.years == 0) && (age.months > 0) && (age.days == 0))
        ageString = age.months + monthString + " old.";
    else ageString = "Oops! Could not calculate age!";

    return ageString;
}

function copyURI(evt) {
    evt.preventDefault();
    // navigator clipboard api needs a secure context (https)
    if (navigator.clipboard && window.isSecureContext) {
        // navigator clipboard api method'
        return navigator.clipboard.writeText(evt.target.getAttribute('href'));
    } else {
        // text area method
        let textArea = document.createElement("textarea");
        textArea.value = evt.target.getAttribute('href');
        // make the textarea out of viewport
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        return new Promise((res, rej) => {
            // here the magic happens
            document.execCommand('copy') ? res() : rej();
            textArea.remove();
        });
    }
}

var _scroll = true, _timer = false, _floatbox = $("#contact_form"), _floatbox_opener = $(".contact-opener");
if (_floatbox.length && _floatbox_opener.length) {
    _floatbox.css("right", "-270px"); //initial contact form position
    //Bug form Opener button
    _floatbox_opener.click(function () {
        if (_floatbox.hasClass('visiable')) {
            _floatbox.animate({"right": "-270px"}, {duration: 300}).removeClass('visiable');
        } else {
            _floatbox.animate({"right": "0px"}, {duration: 300}).addClass('visiable');
        }
    });
    //Effect on Scroll
    $(window).scroll(function () {
        if (_scroll) {
            _floatbox.animate({"top": "30px"}, {duration: 300});
            _scroll = false;
        }
        if (_timer !== false) {
            clearTimeout(_timer);
        }
        _timer = setTimeout(function () {
            _scroll = true;
            _floatbox.animate({"top": "10px"}, {easing: "linear"}, {duration: 500});
        }, 400);
    });
}
clearQueryString = function () {
    window.history.replaceState(null, null, window.location.pathname);
}

