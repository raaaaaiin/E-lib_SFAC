<div>
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    @include("back.common.spinner")
    <div class="card">
    @include("back.common.spinner")
        <div class="card-body yellow">
            @if(session()->has("form_publisher") && session()->has("form_publisher"))
                <div class="row">
                    <div class="col-12">
                        @include("common.messages")
                    </div>
                </div>
            @endif

            <form class="col-12" role="form" wire:submit.prevent="savePublisher">
                <div class="form-row">

                    <div class="col-12 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">{{__("commonv2.publisher_name")}}</span></div>
                            <div class="form-control border-0 p-0">
                                <input type="text" class="form-control" required
                                       wire:model.defer="publisher_name">
                            </div>
                            <div class="input-group-append">
                                
                            </div>
                        </div>
                        <div
                            class="w-100">@error('publisher_name') @include('back.common.validation', ['message' =>  $message ]) @enderror</div>
                    </div>
                </div>
            </form>
            <div class="col-12 mt-2">
                <div class="d-block mb-2">
                    {!! CForm::inputGroupHeader(__("common.filter")) !!}
                    <input type="text" class="form-control" wire:model.debounce.800ms="search_keyword">
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="button" wire:click="clearSearch()">
                            <i class="far fa-trash-alt"></i>
                        </button> <button type="submit"
                                        class="btn btn-sm btn-dark">
                                    @if($mode=="create")
                                        <i class="fas fa-plus-circle"></i>
                                        {{__("common.create")}}
                                    @else
                                        <i class="fas fa-save"></i>
                                        {{__("common.update")}}
                                    @endif
                                    {{__("common.publisher")}}
                                </button>
                    </div>
                    {!! CForm::inputGroupFooter() !!}
                </div>
                <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col">{{__("common.id")}}</th>
                        <th scope="col">{{__("commonv2.publisher_name")}}</th>
                        <th scope="col">{{__("commonv2.books_published")}}</th>
                        <th scope="col">{{__("common.action")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($items->total())

                        @foreach($items as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    @php $books_titles = $item->books()->pluck("books.title")->toArray(); @endphp
                                    @if(count($books_titles))
                                        @foreach($books_titles as $book)
                                            <a target="_blank"
                                               href="{{url('/')."/details/".$common::utf8Slug($book)}}"
                                               class="btn-link text-sm">{{Str::title($book)}}</a>
                                            @if(!$loop->last),@endif
                                        @endforeach
                                    @else
                                        <span class="text-sm">--</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" wire:click="editPublisher({{$item->id}})"
                                            class="btn float-left btn-sm btn-dark action_btn">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button
                                        onclick="lv_confirm_then_submit(this,'{{__("common.cnf_del")}}','deletePublisher','{\'id\':{{$item->id}}}')"
                                        type="button"
                                        class="btn float-left btn-sm btn-danger action_btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">
                                <div class="alert alert-dark">{{__("commonv2.no_publisher_exist")}}</div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                </div>
                {{$items->links()}}
            </div>
        </div>
    </div>
</div>


