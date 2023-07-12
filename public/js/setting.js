$(window).on('load', function () {
    setTimeout(removeLoader, 2000); //wait for page load PLUS two seconds.
});

function removeLoader() {
    $(".cust_overlay").fadeOut(500, function () {
        // fadeOut complete. Remove the loading div
        $(".cust_overlay").remove(); //makes page more lightweight
    });
}

function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}


document.getElementById("defaultOpen").click();

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
    $(".tag_select2").select2({
        tags: true,
        tokenSeparators: ['|']
    });


    $('.summernote_small').summernote({
        height: 100,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true                  // set focus to editable area after initializing summernote
    });
    $('.summernote_big').summernote({
        height: 200,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true                  // set focus to editable area after initializing summernote
    });


});
