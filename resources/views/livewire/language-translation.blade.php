<div>
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    @php $loading_target = "refresh_translations";@endphp
    @include("back.common.spinner")
    <div class="card">
        <div class="card-header blue">
            <span class="card-header-title">{{__("common.mng_lng_translations")}}</span>
        </div>
        <div class="card-body yellow">
            <form wire:submit.prevent="createTranslation">
                @csrf

                <div class="mb-2">
                    @php $we_have = \App\Models\LanguageTranslator::select("lang")->groupBy("lang")->pluck("lang")->toArray();@endphp
                    {!! CForm::inputGroupHeader(__("commonv2.modify_lang")) !!}
                    <select wire:model="sel_lang" class="form-control">
                        @foreach($util::giveAllLocale() as $key=>$value)
                            <option
                                value="{{$key}}" @if(in_array($key,$we_have)) class="text-green font-weight-bold"
                                style="font-size: 25px;" @endif>{{$value}}
                                - {{$key}}</option>
                        @endforeach
                    </select>

                    <div class="input-group-append">
                        <button class="btn btn-dark" type="button" wire:click="createNewTranslation()"><i
                                class="fas fa-plus-circle mr-1"></i>{{__("common.create")}}</button>
                        <button class="btn btn-danger" wire:click="clearTrans" type="button"
                                @if($sel_lang=="en") disabled @endif ><i
                                class="far fa-trash-alt"></i></button>
                        <button class="btn btn-dark" wire:click="flushToFile" type="button"
                        ><i
                                class="far fa-paper-plane mr-1"></i>{{__("common.flush_to_file")}}
                        </button>
                    </div>
                    {!! CForm::inputGroupFooter() !!}
                </div>
                <div class="mb-2">
                    <div class="card">
                        <div class="card-body yellow">
                            <div class="row mb-1">
                                <div class="d-inline float-left mr-1 mb-1">
                                    <button class="btn btn-dark" type="button"
                                            wire:click="showNonTrans()">@if($show_no_transalted) {{__("commonv2.shw_non_trans")}} @else
                                            {{__("commonv2.shw_all")}}  @endif
                                    </button>
                                    <button data-toggle="tooltip" data-placement="top"
                                            title="{{__('commonv2.plz_Wait_30_1')}}" class="btn btn-dark" type="button"
                                            wire:click="refresh_translations()">{{__("common.refresh_Trans")}}
                                    </button>
                                </div>
                                <div class="d-inline float-left mb-1">

                                    {!! CForm::inputGroupHeader(__("common.show_in_page").":") !!}
                                    <input type="number" min="10" max="50" maxlength="2" class="form-control"
                                           wire:model.lazy="trans_item_per_page">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" wire:click="savePageListSetting"><i
                                                class="far fa-save"></i></button>
                                        <input type="text" class="form-control" readonly
                                               value="{{__("common.done_so_far")}} :{{\App\Models\LanguageTranslator::with("main_translation")->where("lang",$sel_lang)->where('value', '<>', '')
                                               ->count()}}/{{\App\Models\MainLanguageTranslator::count()}}">
                                    </div>
                                    {!! CForm::inputGroupFooter() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        {!! CForm::inputGroupHeader("Search") !!}
                        <input type="text" class="form-control" wire:model="search_keyword">
                        {!! CForm::inputGroupFooter() !!}
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                            <tr>
                                <td>{{__("common.id")}}</td>
                                <td>{{__("common.old_val")}}</td>
                                <td>{{__("common.lang_val")}}<i class="fas fa-info-circle ml-1" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="{{__('common.pl_trans_convert_msg')}}"></i></td>
                                <td>{{__("common.lang_file")}}</td>
                                <td>{{__("common.action")}}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($items) && count($items))
                                @foreach($items as $item)
                                    <tr>
                                        <input type="hidden" id="item_id_{{$loop->index}}"
                                               value="{{$item->main_language_translator_id}}"/>
                                        @if($loop->first)
                                            <input type="hidden" id="start"
                                                   value="{{$item->main_language_translator_id}}"/>
                                        @endif
                                        @if($loop->last)
                                            <input type="hidden" id="last"
                                                   value="{{$item->main_language_translator_id}}"/>
                                        @endif
                                        <td>{{($loop->index+1)+(($items->currentPage()-1)*$items->perPage())}}</td>

                                        <td><input type="text" id="to_trans_{{$loop->index}}" readonly
                                                   @if(\Illuminate\Support\Str::contains($item->main_translation->value,":")) style="width: 95%"
                                                   @endif
                                                   value="{{$item->main_translation->value}}"
                                                   class="form-control float-left"/>

                                            @if(\Illuminate\Support\Str::contains($item->main_translation->value,":"))
                                                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                                   title="{{__('common.note_for_trans_disabled')}}"></i>  @endif
                                        </td>
                                        <td>
                                            <input id="trans_holder_{{$loop->index}}" type="text" style="width: 93%"
                                                   class="form-control float-left" value="{{$item->value}}"/>

                                        </td>
                                        <td>{{$item->main_translation->file}}</td>
                                        <td>
                                            <button type="button" onclick="saveNewTranslation({{$loop->index}})"
                                                    class="btn btn-dark btn-sm"><i
                                                    class="far fa-hdd mr-1"></i>{{__("common.save")}}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="alert alert-dark">{{__('common.no_lang_trns_created')}}</div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        @if(isset($items) && $items->hasPages())
                            {{$items->links()}}
                        @endif
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
