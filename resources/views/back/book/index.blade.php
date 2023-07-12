@extends("back.common.master")
@section("page_name") {{__("common.add_books")}} @endsection
@section("content")
    @if(isset($id))
        @livewire("book",["edit_id"=>$id])
    @else
        @livewire("book")
    @endif
@endsection

@section("css_loc")
    <link rel="stylesheet" href="{{asset('css/book_index.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-toggle.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link href="{{asset('plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
@endsection
@section("js_loc")
    <script src="{{asset('js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{asset('plugins/summernote/summernote-bs4.js')}}"></script>
    <script type="text/javascript" src="{{asset("js/select2.min.js")}}"></script>
    <script src="{{asset('js/book_index.js')}}"></script>
    <script>
        $('.select2-multiple').select2({tags: true, tokenSeparators: [',']});
        $('#author').on('select2:select', function (e) {
            window.livewire.emit('data_manager', {"authors": $('#author').val()});
        });
        $('#publisher').on('select2:select', function (e) {
            window.livewire.emit('data_manager', {"publishers": $('#publisher').val()});
        });
        window.addEventListener('select_2_refresh', event => {
            $('.select2-multiple').select2({tags: true, tokenSeparators: [',']});
            $('#tag').select2({tags: true, tokenSeparators: [',']});
            $('#medtypes').select2({tags: true, tokenSeparators: [',']});
        });
        $('#tag').select2({tags: true, tokenSeparators: [',']});
        $('#tag').on('select2:select', function (e) {
            window.livewire.emit('data_manager', {"tags": $('#tag').val()});
        });
        $('#medtypes').select2({tags: true, tokenSeparators: [',']});
        $('#medtypes').on('select2:select', function (e) {
            window.livewire.emit('data_manager', {"medtypes": $('#medtypes').val()});
        });

        function refesh_desc() {
            $('#desc').summernote({
                height: 300,
                minHeight: null,
                maxHeight: null,
                focus: true,
                callbacks: {
                    onBlur: function (e) {
                        window.livewire.emit('data_manager', {"desc": $('#desc').summernote('code')});
                    }
                }
            });
        }

        $(document).ready(function () {
            refesh_desc();
        });

        window.addEventListener('refresh_desc', event => {
            refesh_desc();
        });
        window.addEventListener('desc_changed', event => {
            debugger;
            $('#desc').summernote('code', event.detail.desc);
        });
    </script>
@endsection
