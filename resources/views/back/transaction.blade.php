@extends("back.common.master")
@section("page_name")
    {{__("common.online_payment_receipt")}}
@endsection
@section("content")
    @livewire("transaction")
@endsection
@section('css_loc')
    <style>
        .p_email_wrap {
            width: 85px;
            overflow-wrap: anywhere;
            display: block;
        }

        .p_refund_wrap {
            width: 60px;
        }
    </style>
@endsection
@section("js_loc")
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            flush_before = function ($id) {
                let element = $("#assign_" + $id);
                if (element.length) {
                    window.livewire.emit('data_manager', {"sel_id": element.val()});
                    element.val('');
                }
            };
            start_refund = function ($url, $id) {
                let element = $("#refund_" + $id);
                let payed = $("#payed_amt_" + $id);
                $amount_to_refund = element.val();
                $payed_amount = payed.text();
                if (element.length && payed.length && $amount_to_refund !== "" && $payed_amount !== "") {
                    if ($amount_to_refund < $payed_amount) {
                        $url = $url + "&amount=" + $amount_to_refund;
                        window.location = $url;
                    } else {
                        show_message("info", "Alert", "{{__("common.amnt_to_refnd_cannot_be_greater")}}")
                    }
                } else {
                    window.location = $url;
                }
            };
        });
    </script>
@endsection
