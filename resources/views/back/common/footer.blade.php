@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp

<footer class="main-footer">
    @can("mng-setting")
        @if($common::getSiteSettings("enable_documentation") && $common::isAnyAdmin())
            @php $docs = \App\Models\Docs::where("keywords",request()->path())->get(); @endphp
            @if(is_countable($docs) && count($docs)>0)
                <div class="accordion" id="accordionDocumentation">
                    @foreach($docs as $doc)
                        <div class="card card-dark">
                            <div class="card-header blue" id="heading{{$loop->index}}">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-white" type="button" data-toggle="collapse"
                                            data-target="#collapse{{$loop->index}}"
                                            aria-expanded="true" aria-controls="collapse{{$loop->index}}">
                                        <i class="far fa-life-ring mr-1"></i>{{__("common.documentation")}} @if(count($docs)>1){{intval($loop->index)+1}}@endif
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse{{$loop->index}}" class="collapse"
                                 aria-labelledby="heading{{$loop->index}}"
                                 data-parent="#accordionDocumentation">
                                <div class="card-body yellow">
                                    <strong>Note: You can turn off the documentation from the setting page. </strong>
                                    {!! $doc->docs !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    @endcan
    <div class="float-right d-none d-sm-block">
        <a href="//https://raaaaaiin.github.io/"><b style="color: green;font-family: monospace">Naerlex</b></a> |
        
    </div>
    <strong></strong> 
</footer>
@if($common::getSiteSettings("enable_error_reporting") && $common::isAnyAdmin())
    @livewire("bug-tracking")
@endif
