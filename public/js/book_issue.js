$(document).ready(function () {
    if ($("#user_autocomplete").length) {
        $("#user_autocomplete").autocomplete({
            minLength: 2,
            source: function (request, response) {
                $(".cust_overlay").fadeIn(300);
                $.ajax({
                    url: url_json_user,
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        $(".cust_overlay").fadeOut(300);
                        response(data);
                    }
                });

            },
            focus: function (event, ui) {
                $("#user_autocomplete").val(ui.item.name);
                return false;
            },
            select: function (event, ui) {
                $("#user_autocomplete").val(ui.item.name);
                $("#user_id").val(ui.item.id);
                $("#spn_user_id").text(ui.item.id);
                $("#user_address").text(ui.item.address);
                $("#user_image").attr("src", ui.item.image);
                $("#user_course").text(ui.item.course_name);
                $("#user_year").text(ui.item.year_name);
                $("#user_course_id").val(ui.item.course);
                $("#user_year_id").val(ui.item.year);
                $("#user_email").text(ui.item.email);
                $("#user_borrowed_cnt").text(ui.item.borrowed_cnt);
                $("#user_limit").text(ui.item.limit);

                window.livewire.emit('data_manager', { "user_id": ui.item.id })
                return false;
            }
        })
            .autocomplete("instance")._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<div class='text-sm'> Name : " + item.name + " | Id: " + item.id)
                    .appendTo(ul);
            };
    }

    if ($("#book_autocomplete").length) {
        $("#book_autocomplete").autocomplete({
            minLength: 2,
            source: function (request, response) {
                $(".cust_overlay").fadeIn(300);
                $.ajax({
                    url: url_book_user,
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        $(".cust_overlay").fadeOut(300);
                        response(data);
                    }
                });

            },
            focus: function (event, ui) {
                $("#book_autocomplete").val(ui.item.name);
                return false;
            },
            select: function (event, ui) {
                $("#book_autocomplete").val(ui.item.title);
                $("#book_id").val(ui.item.id);
                $("#spn_book_id").text(ui.item.id);
                $("#book_m_id").val(ui.item.book_m_id);
                $("#book_span_code").text(ui.item.bid);
                $("#book_title").text(ui.item.title);
                $("#book_condition").text(ui.item.condition);
                $("#book_price").text(ui.item.price);
                $("#book_category").text(ui.item.category);
                $("#book_image").attr("src", ui.item.image);
                window.livewire.emit('data_manager', {
                    "main_book_id": ui.item.book_m_id,
                    "sub_book_id": ui.item.id
                });
                return false;
            }
        })
            .autocomplete("instance")._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<div class='text-sm " + item.borrowed_class + "'> Title : " + item.title + " | BCode : " + item.bid)
                    .appendTo(ul);
            };
    };

    $("#issue_date_tmp").datepicker({
        dateFormat: 'mm-dd-yy',
        altField: "#issue_date",
        altFormat: 'yy-mm-dd',
        onSelect: function () {
            window.livewire.emit('data_manager', { "issue_date": $('#issue_date').val() });
        },
    }).datepicker("setDate", new Date());

    $("#return_date_tmp").datepicker({
        dateFormat: 'mm-dd-yy',
        altField: "#return_date",
        altFormat: 'yy-mm-dd',
        onSelect: function () {
            window.livewire.emit('data_manager', { "return_date": $('#return_date').val() });
        },
    }).datepicker("setDate", new Date());
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('search')) {
        $("#book_autocomplete").autocomplete("search", urlParams.get('search'));
    }
    $(".user_history_holder").hide();

    $(".book_history_holder").hide();


    add_dyn_return_dt = function () {
        $(".return_dt").datepicker({
            dateFormat: 'mm-dd-yy',
            altField: "#return_dt",
            altFormat: 'yy-mm-dd',
            onSelect: function () {
                window.livewire.emit('data_manager', { "return_date": $('#return_dt').val() });
            },
        }).datepicker();
    }
    add_dyn_return_dt();
    window.addEventListener('refresh_return_dt', event => { add_dyn_return_dt() });

});
