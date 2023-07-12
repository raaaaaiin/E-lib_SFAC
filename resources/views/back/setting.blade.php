@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name") {{__("common.site_setting")}} @endsection
@section("content")
    @include("back.common.spinner")
    @php CForm::star_status('on'); @endphp
    <div class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body yellow">
                    @if(session()->has('form_setting') && session()->get('form_setting'))
                        <div class="row">
                            <div class="col-12">
                                @include("common.messages")
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            @if(\Illuminate\Support\Facades\Session::has("working_frm"))
                                @php
                                    $working_frm = \Illuminate\Support\Facades\Session::get("working_frm") ;
                                @endphp
                            @endif

                            <div class="tab">
                                <button class="tablinks" onclick="openCity(event, 'content_setting')"
                                        @if($working_frm=="content_setting") id="defaultOpen" @endif>
                                    <span class="hidden-xs">
                                        {{__("common.text_setting")}}
                                    </span>
                                    <i class="d-block d-sm-none fas fa-text-height"></i>
                                </button>
                                <button class="tablinks" onclick="openCity(event, 'org_setting')"
                                        @if($working_frm=="org_setting") id="defaultOpen" @endif>
                                    <span class="hidden-xs">
                                        {{__("common.org_setting")}}
                                    </span>
                                    <i class="d-block d-sm-none fas fa-school"></i>
                                </button>
                                <button class="tablinks" @if($working_frm=="seo_setting") id="defaultOpen" @endif
                                onclick="openCity(event, 'seo_setting')">
                                    <span class="hidden-xs">{{__("common.seo_setting")}}</span>
                                    <i class="d-block d-sm-none fab fa-google"></i>
                                </button>

                                <button class="tablinks" @if($working_frm=="site_setting") id="defaultOpen" @endif
                                onclick="openCity(event, 'site_setting')">
                                    <span class="hidden-xs">{{__("common.site_setting")}}</span>
                                    <i class="d-block d-sm-none fas fa-cogs"></i>
                                </button>


                                <button class="tablinks" @if($working_frm=="payment_setting") id="defaultOpen" @endif
                                onclick="openCity(event, 'payment_setting')">
                                    <span class="hidden-xs">{{__("common.payment_setting")}} <span
                                            class="badge badge-dark">{{__("common.fine")}}</span></span>
                                    <i class="d-block d-sm-none fab fa-paypal"></i>
                                </button>


                                <button class="tablinks" @if($working_frm=="backup") id="defaultOpen"
                                        @endif onclick="openCity(event, 'backup')">
                                    <span class="hidden-xs">{{__("common.bckup_restore")}}</span>
                                    <i class="d-block d-sm-none fas fa-upload"></i>
                                </button>

                                <button class="tablinks" @if($working_frm=="purchase") id="defaultOpen"
                                        @endif onclick="openCity(event, 'purchase_setting')">
                                    <span class="hidden-xs">{{__("purchased.activate_set")}}</span>
                                    <i class="d-block d-sm-none fas fa-box-open"></i>
                                </button>

                                <button class="tablinks" @if($working_frm=="amazon_aff") id="defaultOpen"
                                        @endif onclick="openCity(event, 'amazon_aff')">
                                    <span class="hidden-xs">{{__("commonv2.amazon_aff")}}</span>
                                    <i class="d-block d-sm-none fas fa-box-open"></i>
                                </button>

                            </div>

                            <div id="amazon_aff" class="tabcontent">
                                <h3 style="padding-top: 15px;">{{__("commonv2.amazon_aff")}}</h3>
                                <p>{{__("commonv2.pl_amazon_aff")}}</p>
                                <form method="post" action="{{route("setting.store")}}">
                                    @csrf
                                    <input name="frm_name" type="hidden" value="amazon_aff"/>
                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("commonv2.enable_amazon_fetching"),'w-185',
                                            "enable_amazon_fetching",$settings,'',null,null,true) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("commonv2.enable_only_amazon_fetching"),'w-185',
                                            "enable_only_amazon_fetching",$settings,'',null,null,true) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("commonv2.amz_access_key"),
                                        "amz_access_key",["amz_access_key"=>
                                        !empty($common::getSiteSettings("amz_access_key"))?
                                        $common::getSiteSettings("amz_access_key"):""],'',null,null,false,null) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("commonv2.amz_secret_key"),
                                        "amz_secret_key",["amz_secret_key"=>
                                        !empty($common::getSiteSettings("amz_secret_key"))?
                                        $common::getSiteSettings("amz_secret_key"):""],'',null,null,false,null) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("commonv2.amz_tag"),
                                        "amz_tag",["amz_tag"=>
                                        !empty($common::getSiteSettings("amz_tag"))?
                                        $common::getSiteSettings("amz_tag"):""],'',null,null,false,null) !!}
                                    </div>
                                    <div class="mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text w-185">{{__("commonv2.amz_host")}}</span>
                                            </div>
                                            {{--                                                @php dd($util::getAmazonHosts()); @endphp--}}
                                            <select name="amz_host" class="form-control">
                                                <option value="">{{__('common.select')}}</option>
                                                @foreach($util::getAmazonHosts() as $k=>$v)
                                                    <option value="{{$v}}"
                                                            @if($common::getSiteSettings("amz_host")==$v) selected @endif>{{$k}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text w-185">{{__("commonv2.amz_region")}}</span>
                                            </div>
                                            <select name="amz_region" class="form-control">
                                                <option value="">{{__('common.select')}}</option>
                                                @foreach($util::getAmazonRegions() as $v)
                                                    <option value="{{$v}}"
                                                            @if($common::getSiteSettings("amz_region")==$v) selected @endif>{{$v}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <button type="submit"
                                                class="btn btn-dark btn-sm mb-10"><i
                                                class="fas fa-save mr-1"></i>{{__("common.save_setting")}}</button>
                                    </div>
                                </form>
                            </div>


                            <div id="purchase_setting" class="tabcontent">
                                <h3 style="padding-top: 15px;">{{__("purchased.activate_set")}}</h3>
                                <p>{{__("purchased.pl_activate_set")}}</p>
                                <form method="post" action="{{route("setting.store")}}">
                                    @csrf
                                    <input name="frm_name" type="hidden" value="purchase_setting"/>
                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("purchased.purchase_code"),
                                        "purchase_code",["purchase_code"=>
                                        !empty($common::getSiteSettings("purchase_code"))?
                                        $common::getSiteSettings("purchase_code"):config("app.PURCHASE_CODE")],'',null,null,true,null) !!}
                                    </div>
                                    <div class="mb-2">
                                        <button type="submit"
                                                class="btn btn-dark btn-sm mb-10"><i
                                                class="fas fa-save mr-1"></i>{{__("common.save_setting")}}</button>
                                        @if((empty($common::getSiteSettings("expired_on")) && empty($common::getSiteSettings("bought_on"))) || !empty($common::getSiteSettings("expired_on")))
                                            <a href="{{config('app.PARENT_WEBSITE').'/login'}}" target="_blank"
                                               class="btn btn-sm btn-warning mb-10">Renew
                                                Now</a>
                                        @endif
                                    </div>
                                </form>
                            </div>


                            <div id="content_setting" class="tabcontent">
                                <h3 style="padding-top: 15px;">{{__("common.text_setting")}}</h3>
                                <p>{{__("common.pl_text_setting")}}</p>
                                <form method="post" action="{{route("setting.store")}}">
                                    @csrf
                                    <input name="frm_name" type="hidden" value="content_setting"/>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.curr_symbol"),
                                        "currency_symbol",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.tel_code"),
                                        "telephone_code",$settings,'',null,null,true,null) !!}
                                    </div>


                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.google_map"),
                                        "google_map",$settings,'',null,null,true,null) !!}
                                    </div>


                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.no_of_testimonials").CForm::generateInfoToolTipByFieldName("pl_testimonial"),
                                        "no_of_testimonials",$settings,'',null,null,true,null) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.no_of_faq").CForm::generateInfoToolTipByFieldName("pl_alumni_teacher"),
                                        "no_of_faqs",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div id="accordion">
                                        <div class="card card-dark">
                                            <div class="card-header blue">
                                                <h4 class="card-title w-100">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseThree" class="collapsed" aria-expanded="false">
                                                        <span class="float-left"
                                                              style="line-height: 39px;">{{__("common.testimonials")}}</span>
                                                        <button class="btn float-right text-white"><i
                                                                class="fas fa-chevron-circle-down"></i></button>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseThree" class="panel-collapse collapse" style="">
                                                <div class="card-body yellow">
                                                    @if(isset($settings["no_of_testimonials"]) && $settings["no_of_testimonials"]>0)
                                                        <div class="mb-2">
                                                            {!! CForm::inputGroupHeader(__("common.testimonial_heading"),"w-100","w-100") !!}
                                                            @php $item_name = "testimonial_heading" ;@endphp
                                                            <textarea type="text"
                                                                      class="form-control summernote_small"
                                                                      name="testimonials[{{$item_name}}]">{{old($item_name,isset($settings[$item_name]) ? $settings[$item_name]:"")}}</textarea>
                                                            {!! CForm::inputGroupFooter() !!}
                                                        </div>
                                                        <div class="mb-2">

                                                            {!! CForm::inputGroupHeader(__("common.testimonial_sub_heading"),"w-100","w-100") !!}
                                                            @php $item_name_desc = "testimonial_sub_heading" ;@endphp
                                                            <textarea name="testimonials[{{$item_name_desc}}]"
                                                                      class="form-control summernote_big">{{old($item_name_desc,isset($settings[$item_name_desc]) ? $settings[$item_name_desc]:"")}}
                                                            </textarea>
                                                            {!! CForm::inputGroupFooter() !!}

                                                        </div>

                                                        <hr/>
                                                        @foreach(range(1,$settings["no_of_testimonials"]) as $i)
                                                            <div class="mb-2">
                                                                {!! CForm::inputGroupHeader(__("common.testimonial_name",["number"=>$i])) !!}
                                                                @php $item_name = "testimonial_name_$i" ;@endphp
                                                                <input type="text"
                                                                       value="{{old($item_name,isset($settings[$item_name]) ? $settings[$item_name]:"")}}"
                                                                       class="form-control"
                                                                       name="testimonials[{{$item_name}}]">
                                                                {!! CForm::inputGroupFooter() !!}
                                                            </div>
                                                            <div class="mb-2">
                                                                {!! CForm::inputGroupHeader(__("common.testimonial_img_icon",["number"=>$i])) !!}
                                                                @php $item_name = "testimonial_pic_$i" ;@endphp
                                                                <input type="text"
                                                                       value="{{old($item_name,isset($settings[$item_name]) ? $settings[$item_name]:"")}}"
                                                                       class="form-control"
                                                                       placeholder="{{__("common.pl_testimonial_icon_helper")}}"
                                                                       name="testimonials[{{$item_name}}]">
                                                                {!! CForm::inputGroupFooter() !!}
                                                            </div>
                                                            <div class="mb-2">
                                                                {!! CForm::inputGroupHeader(__("common.testimonial_desc",["number"=>$i]),"w-100","w-100") !!}
                                                                @php $item_name_desc = "testimonial_desc_$i" ;@endphp
                                                                <textarea name="testimonials[{{$item_name_desc}}]"
                                                                          class="form-control summernote_big">{{old($item_name_desc,isset($settings[$item_name_desc]) ? $settings[$item_name_desc]:"")}}
                                                    </textarea>
                                                                {!! CForm::inputGroupFooter() !!}
                                                            </div>
                                                            <hr/>
                                                        @endforeach
                                                    @else
                                                        <div
                                                            class="alert alert-dark">{{__("common.no_testimonial_exist")}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="accordion">
                                        <div class="card card-dark">
                                            <div class="card-header blue">
                                                <h4 class="card-title w-100">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseFour" class="collapsed" aria-expanded="false">
                                                        <span class="float-left"
                                                              style="line-height: 39px;">{{__("common.books_holder")}}</span>
                                                        <button class="btn float-right text-white"><i
                                                                class="fas fa-chevron-circle-down"></i></button>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFour" class="panel-collapse collapse" style="">
                                                <div class="card-body yellow">
                                                    <div class="mb-2">
                                                        {!! CForm::inputGroupHeader(__("common.book_heading"),"w-100","w-100") !!}
                                                        @php $item_name = "book_heading" ;@endphp
                                                        <textarea
                                                            class="form-control summernote_small"
                                                            name="books[{{$item_name}}]">{{old($item_name,isset($settings[$item_name]) ? $settings[$item_name]:"")}}</textarea>
                                                        {!! CForm::inputGroupFooter() !!}
                                                    </div>
                                                    <div class="mb-2">
                                                        {!! CForm::inputGroupHeader(__("common.book_sub_heading"),"w-100","w-100") !!}
                                                        @php $item_name_desc = "book_sub_heading" ;@endphp
                                                        <textarea name="books[{{$item_name_desc}}]"
                                                                  class="form-control summernote_big">{{old($item_name_desc,isset($settings[$item_name_desc]) ? $settings[$item_name_desc]:"")}}
                                                            </textarea>
                                                        {!! CForm::inputGroupFooter() !!}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="accordion">
                                        <div class="card card-dark">
                                            <div class="card-header blue">
                                                <h4 class="card-title w-100">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseSix" class="collapsed" aria-expanded="false">
                                                        <span class="float-left"
                                                              style="line-height: 39px;">{{__("common.contact_holder")}}</span>
                                                        <button class="btn float-right text-white"><i
                                                                class="fas fa-chevron-circle-down"></i></button>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseSix" class="panel-collapse collapse" style="">
                                                <div class="card-body yellow">
                                                    <div class="mb-2">
                                                        {!! CForm::inputGroupHeader(__("common.contact_heading"),"w-100","w-100") !!}
                                                        @php $item_name = "contact_heading" ;@endphp
                                                        <textarea
                                                            class="form-control summernote_small"
                                                            name="contacts[{{$item_name}}]">{{old($item_name,isset($settings[$item_name]) ? $settings[$item_name]:"")}}</textarea>
                                                        {!! CForm::inputGroupFooter() !!}
                                                    </div>
                                                    <div class="mb-2">
                                                        {!! CForm::inputGroupHeader(__("common.cnt_sub_heading"),"w-100","w-100") !!}
                                                        @php $item_name_desc = "contact_sub_heading" ;@endphp
                                                        <textarea name="contacts[{{$item_name_desc}}]"
                                                                  class="form-control summernote_big">{{old($item_name_desc,isset($settings[$item_name_desc]) ? $settings[$item_name_desc]:"")}}
                                                            </textarea>
                                                        {!! CForm::inputGroupFooter() !!}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="accordion">
                                        <div class="card card-dark">
                                            <div class="card-header blue">
                                                <h4 class="card-title w-100">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseFive" class="collapsed" aria-expanded="false">
                                                        <span class="float-left"
                                                              style="line-height: 39px;">{{__("common.faq")}}</span>
                                                        <button class="btn float-right text-white"><i
                                                                class="fas fa-chevron-circle-down"></i></button>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFive" class="panel-collapse collapse" style="">
                                                <div class="card-body yellow">
                                                    @if(isset($settings["no_of_faqs"]) && $settings["no_of_faqs"]>0)
                                                        <div class="mb-2">
                                                            {!! CForm::inputGroupHeader(__("common.faq_heading"),"w-100","w-100") !!}
                                                            @php $item_name = "faq_heading" ;@endphp
                                                            <textarea
                                                                class="form-control summernote_small"
                                                                name="faqs[{{$item_name}}]">{{old($item_name,isset($settings[$item_name]) ? $settings[$item_name]:"")}}</textarea>
                                                            {!! CForm::inputGroupFooter() !!}
                                                        </div>

                                                        <hr/>
                                                        @foreach(range(1,$settings["no_of_faqs"]) as $i)
                                                            <div class="mb-2">
                                                                {!! CForm::inputGroupHeader(__("common.faq_question",["number"=>$i]),"w-100","w-100") !!}
                                                                @php $item_name = "faq_que_$i" ;@endphp
                                                                <textarea
                                                                    class="form-control summernote_small"
                                                                    name="faqs[{{$item_name}}]">{{old($item_name,isset($settings[$item_name]) ? $settings[$item_name]:"")}}</textarea>
                                                                {!! CForm::inputGroupFooter() !!}
                                                            </div>
                                                            <div class="mb-2">
                                                                {!! CForm::inputGroupHeader(__("common.faq_answer",["number"=>$i]),"w-100","w-100") !!}
                                                                @php $item_name = "faq_ans_$i" ;@endphp
                                                                <textarea
                                                                    class="form-control summernote_big"
                                                                    name="faqs[{{$item_name}}]">{{old($item_name,isset($settings[$item_name]) ? $settings[$item_name]:"")}}</textarea>
                                                                {!! CForm::inputGroupFooter() !!}
                                                            </div>
                                                            <hr/>
                                                        @endforeach
                                                    @else
                                                        <div class="alert alert-dark">{{__("common.np_faq_exist")}}!
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="accordion">
                                        <div class="card card-dark">
                                            <div class="card-header blue">
                                                <h4 class="card-title w-100">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseSeven" class="collapsed" aria-expanded="false">
                                                        <span class="float-left"
                                                              style="line-height: 39px;">{{__("common.toi")}}</span>
                                                        <button class="btn float-right text-white"><i
                                                                class="fas fa-chevron-circle-down"></i></button>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseSeven" class="panel-collapse collapse" style="">
                                                <div class="card-body yellow">
                                                    <div class="mb-2">
                                                        {!! CForm::inputGroupHeader(__("common.toi_heading"),"w-100","w-100") !!}
                                                        @php $item_name = "toi_heading" ;@endphp
                                                        <textarea
                                                            class="form-control summernote_small"
                                                            name="toi[{{$item_name}}]">{{old($item_name,isset($settings[$item_name]) ? $settings[$item_name]:"")}}</textarea>
                                                        {!! CForm::inputGroupFooter() !!}
                                                    </div>
                                                    <div class="mb-2">
                                                        {!! CForm::inputGroupHeader(__("common.toi_desc"),"w-100","w-100") !!}
                                                        @php $item_name_desc = "toi_desc" ;@endphp
                                                        <textarea name="toi[{{$item_name_desc}}]"
                                                                  class="form-control summernote_big">{{old($item_name_desc,isset($settings[$item_name_desc]) ? $settings[$item_name_desc]:"")}}
                                                            </textarea>
                                                        {!! CForm::inputGroupFooter() !!}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="accordion">
                                        <div class="card card-dark">
                                            <div class="card-header blue">
                                                <h4 class="card-title w-100">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseEight" class="collapsed" aria-expanded="false">
                                                        <span class="float-left"
                                                              style="line-height: 39px;">{{__("common.pp")}}</span>
                                                        <button class="btn float-right text-white"><i
                                                                class="fas fa-chevron-circle-down"></i></button>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseEight" class="panel-collapse collapse" style="">
                                                <div class="card-body yellow">
                                                    <div class="mb-2">
                                                        {!! CForm::inputGroupHeader(__("common.pp_heading"),"w-100","w-100") !!}
                                                        @php $item_name = "pp_heading" ;@endphp
                                                        <textarea
                                                            class="form-control summernote_small"
                                                            name="pp[{{$item_name}}]">{{old($item_name,isset($settings[$item_name]) ? $settings[$item_name]:"")}}</textarea>
                                                        {!! CForm::inputGroupFooter() !!}
                                                    </div>
                                                    <div class="mb-2">
                                                        {!! CForm::inputGroupHeader(__("common.pp_desc"),"w-100","w-100") !!}
                                                        @php $item_name_desc = "pp_desc" ;@endphp
                                                        <textarea name="pp[{{$item_name_desc}}]"
                                                                  class="form-control summernote_big">{{old($item_name_desc,isset($settings[$item_name_desc]) ? $settings[$item_name_desc]:"")}}
                                                            </textarea>
                                                        {!! CForm::inputGroupFooter() !!}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.org_foot_note"),
                                        "footer_note",$settings,'',null,null,false,null) !!}
                                    </div>


                                    <div class="mb-2">
                                        {!! CForm::completeSelectBox2(__("common.id_card_inst"),"",
                                           "id_card_instructions_list",$settings,'',null,null,true,null,true) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeSelectBox2(__("common.working_hour"),"",
                                           "working_hours_list",$settings,'',null,null,true,null,true) !!}
                                    </div>


                                    <button type="submit"
                                            class="btn btn-dark btn-sm mb-10"><i
                                            class="fas fa-save mr-1"></i>{{__("common.save_setting")}}</button>
                                </form>
                            </div>
                            <div id="org_setting" class="tabcontent">
                                <h3 style="padding-top: 15px;">{{__("common.org_details_setting")}}</h3>
                                <p>{{__("common.pl_org_details_setting")}}</p>
                                <form method="post" action="{{route("setting.store")}}" enctype="multipart/form-data">
                                    @csrf
                                    <input name="frm_name" type="hidden" value="org_setting"/>

                                    <div class="input-group mb-10">
                                        <div class="input-group-prepend"><span
                                                class="input-group-text">{{__('common.web_ico')}}
                                                {!! CForm::generateInfoToolTip(__('common.pl_web_ico'),'mt-1 text-sm ml-2') !!}
                                       </span>
                                        </div>
                                        <input name="web_ico_file" accept=".ico" type="file"
                                               class="form-control text-sm">
                                    </div>

                                    <div class="input-group mb-10">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text">{{__('common.org_logo')}}
                                    </span></div>
                                        <input name="org_logo_tmp" accept=".jpg,jpeg,.png" type="file"
                                               class="form-control text-sm">
                                        <div class="input-group-append">
                                            {!! CForm::completeTextBox(__("common.set_style"),
                                       "org_logo_css",$settings,'',null,null,false,null) !!}
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.org_name"),
                                        "org_name",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.org_email"),
                                        "org_email",$settings,'',null,null,true,null,"email") !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.org_phone"),
                                        "org_phone",$settings,'',null,null,true,null) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.org_fax"),
                                        "org_fax",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div class="mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span
                                                    class="input-group-text">{{__('common.org_address')}}</span></div>
                                            <textarea class="form-control" name="org_address" required
                                            >{{old("org_address",isset($settings["org_address"])?$settings["org_address"]:"")}}</textarea>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span
                                                    class="input-group-text">{{__('common.org_desc')}}</span></div>
                                            <textarea class="form-control" name="org_desc" required
                                            >{{old("org_desc",isset($settings["org_desc"])?$settings["org_desc"]:"")}}</textarea>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.org_link_tw"),
                                        "tw_link",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.org_link_lk"),
                                        "ln_link",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.org_link_gp"),
                                        "gp_link",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.org_link_fb"),
                                        "fb_link",$settings,'',null,null,true,null) !!}
                                    </div>


                                    <button type="submit"
                                            class="btn btn-dark btn-sm mb-10"><i
                                            class="fas fa-save mr-1"></i>{{__("common.save_setting")}}</button>
                                </form>
                            </div>
                            <div id="seo_setting" class="tabcontent">
                                <h3 style="padding-top: 15px;">{{__("common.seo_setting")}}</h3>
                                <p>{{__("common.pl_seo_setting")}}</p>

                                <form method="post" action="{{route("setting.store")}}">
                                    @csrf
                                    <input name="frm_name" type="hidden" value="seo_setting"/>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.seo_meta_title"),
                                        "index_meta_title",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div class="input-group mb-10">
                                        <div class="input-group-prepend"><span
                                                class="input-group-text">{{__('common.seo_meta_desc')}}</span></div>
                                        <textarea rows="10" class="form-control" name="index_meta_desc" required
                                        >{{old("index_meta_desc",isset($settings["index_meta_desc"])?$settings["index_meta_desc"]:"")}}</textarea>
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("commonv2.google_site_v_code"),
                                        "google_site_verification",$settings,'',null,null,false,null) !!}
                                    </div>

                                    <div class="input-group mb-10">
                                        <div class="input-group-prepend"><span
                                                class="input-group-text">{{__('commonv2.google_analytics')}}</span></div>
                                        <textarea rows="10" class="form-control" name="google_analytics"
                                        >{{old("google_analytics",isset($settings["google_analytics"])?$settings["google_analytics"]:"")}}</textarea>
                                    </div>


                                    <button type="submit"
                                            class="btn btn-dark btn-sm mb-10"><i
                                            class="fas fa-save mr-1"></i>{{__("common.save_setting")}}</button>
                                </form>


                            </div>
                            <div id="site_setting" class="tabcontent">
                                <h3 style="padding-top: 15px;">{{__("common.site_setting")}}</h3>
                                <p>{{__("common.pl_site_setting")}}</p>

                                <form method="post" class="mb-2" action="{{route('clear_cache')}}">
                                    @csrf
                                    <input name="frm_name" type="hidden" value="site_setting"/>
                                    <button type="submit" href="{{route('clear_cache')}}"
                                            class="btn btn-dark btn-sm mb-10"><i
                                            class="fas fa-shoe-prints mr-1"></i>{{__("common.clear_cache")}}
                                    </button>
                                </form>

                                <form method="post" action="{{route("setting.store")}}" enctype="multipart/form-data">
                                    @csrf
                                    <input name="frm_name" type="hidden" value="site_setting"/>


                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.enable_frontend"),'w-185',
                                            "enable_frontend",$settings,'',null,null,true) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.enable_autoupdate"),'w-185',
                                            "enable_auto_update",$settings,'',null,null,true) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("commonv2.enable_book_id_auto"),'w-185',
                                            "enable_book_id_auto",$settings,'',null,null,true) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("commonv2.enable_book_id_length"),
                                        "enable_book_id_length",$settings,'',null,null,false,null,"number") !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("commonv2.barcode_read"),'w-185',
                                            "enable_bardcode_reading_mode",$settings,'',null,null,true) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("commonv2.enable_simple_search"),'w-185',
                                            "enable_simple_search",$settings,'',null,null,true) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("commonv2.enable_image_classificaiton"),'w-185',
                                            "enable_image_classificaiton",$settings,'',null,null,true) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("commonv2.enable_user_borrow"),'w-185',
                                            "enable_user_borrow",$settings,'',null,null,true) !!}
                                    </div>


                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.enable_documentation"),'w-185',
                                            "enable_documentation",$settings,'',null,null,true) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.enable_frontend_registration")
                                ."<a target='_blank' data-toggle='tooltip' data-placement='left' title='If you are logged in, this would not work.
                                 You can open this link in incognito mode to view the register page.' class='btn btn-link btn-sm' href='".url('/register')."'>Register <i class='fas fa-external-link-alt'></i></a>",'w-185',
                                            "enable_register",$settings,'',null,null,true) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.restrict_course")."<span class='ml-2 badge badge-dark'>Register Page</span>",'w-185',
                                            "enable_reg_pg_course_rest",$settings,'',null,null,true) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.show_course")."<span class='ml-2 badge badge-dark'>Register Page</span>",'w-185',
                                            "enable_reg_pg_shw_course_rest",$settings,'',null,null,true) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.restrict_photo")."<span class='ml-2 badge badge-dark'>Register Page</span>",'w-185',
                                            "enable_reg_pg_photo_rest",$settings,'',null,null,true) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.show_photo")."<span class='ml-2 badge badge-dark'>Register Page</span>",'w-185',
                                            "enable_reg_pg_shw_photo_rest",$settings,'',null,null,true) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.restrict_proof")."<span class='ml-2 badge badge-dark'>Register Page</span>",'w-185',
                                            "enable_reg_pg_proof_rest",$settings,'',null,null,true) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.show_proof")."<span class='ml-2 badge badge-dark'>Register Page</span>",'w-185',
                                            "enable_reg_pg_shw_proof_rest",$settings,'',null,null,true) !!}
                                    </div>


                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.redirect_home_to"),
                                        "redirect_home_page",$settings,'',null,null,false,null) !!}
                                    </div>


                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.admin_pg_name"),
                                        "admin_page_name",$settings,'',null,null,true,null) !!}
                                    </div>


                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.admin_email_id"),
                                        "admin_email",$settings,'',null,null,true,null,"email") !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.system_email_id"),
                                        "system_email",$settings,'',null,null,true,null,"email") !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.late_fine").' in '.$common::getSiteSettings("currency_symbol"),
                                        "fine_per_day",$settings,'',null,null,false,null,"number") !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.limit_qty_book_stud"),
                                        "student_book_limit",$settings,'',null,null,false,null,"number") !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.limit_qty_book_teacher"),
                                        "teacher_book_limit",$settings,'',null,null,false,null,"number") !!}
                                    </div>

                                    <div class="mb-2">

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text w-185">{{__("common.set_def_lang")}}</span>
                                            </div>
                                            <select required name="default_lang" class="form-control">
                                                @foreach($util::getAllAvailableTrans() as $kv)
                                                    <option value="{{$kv}}"
                                                            @if($common::getDefaultLang()==$kv) selected @endif>{{$kv}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeSelectBox(__("common.wrking_year"),"w-185",
                                           "working_year",$util::toArrayFromEloquentCollection($common::getAllYears(),"id","year_from"),$common::getWorkingYear(),null,null,true,null) !!}
                                    </div>


                                    <div class="mb-2">
                                        {!! CForm::completeSelectBox(__("common.default_role"),"w-185",
                                           "default_role",$util::toArrayFromEloquentCollection($common::getAllRoles(),"id","name"),
                                           isset($settings["default_role"])?$settings["default_role"]:"",null,null,true,null) !!}
                                    </div>


                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.front_primary"),
                                        "front_primary",$settings,'',null,null,true,null,"color") !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.front_secondary"),
                                        "front_secondary",$settings,'',null,null,true,null,"color") !!}
                                    </div>

                                    <button type="submit"
                                            class="btn btn-dark btn-sm mb-10"><i
                                            class="fas fa-save mr-1"></i>{{__("common.save_setting")}}</button>
                                </form>

                            </div>
                            <div id="payment_setting" class="tabcontent">
                                <h3 style="padding-top: 15px;">{{__("common.payment_setting")}}</h3>
                                <p>{{__("common.pl_payment_setting")}}</p>
                                <form method="post" action="{{route("setting.store")}}">
                                    @csrf
                                    <input name="frm_name" type="hidden" value="payment_setting"/>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.curr_code"),
                                        "currency_code",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.paypal_clientId"),
                                        "PAYPAL_CLIENT_ID",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeTextBox(__("common.paypal_clientSecret"),
                                        "PAYPAL_CLIENT_SECRET",$settings,'',null,null,true,null) !!}
                                    </div>

                                    <div class="mb-2">
                                        {!! CForm::completeToggleBox(__("common.paypal_live"),'w-185',
                                            "enable_PAYPAL_SANDBOX",$settings,'',null,null,true) !!}
                                    </div>

                                    <button type="submit"
                                            class="btn btn-dark btn-sm mb-10"><i
                                            class="fas fa-save mr-1"></i>{{__("common.save_setting")}}</button>
                                </form>
                            </div>
                            <div id="backup" class="tabcontent">
                                <h3 style="padding-top: 15px;">{{__("common.bck_res_db")}}</h3>
                                <p>{{__("common.pl_bck_db")}}</p>
                                <form method="post" action="{{route('file.db_mng')}}">
                                    @csrf
                                    <input name="do" type="hidden" value="backup">
                                    <input name="frm_name" type="hidden" value="backup">
                                    <button type="submit"
                                            class="btn btn-dark btn-sm mb-10"><i
                                            class="fas fa-cloud-upload-alt mr-1"></i>{{__("common.create_db_bck")}}
                                    </button>
                                </form>
                                <table class="table table-striped table-hover table-sm mt-2">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{__("common.db_file_name")}}</th>
                                        <th scope="col">{{__("common.file_size")}}</th>
                                        <th scope="col">{{__("common.created_on")}}</th>
                                        <th scope="col">{{__("common.action")}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $items = $util::getDbBackupFiles();
                                    @endphp
                                    @if(count($items))
                                        @php $count = 1; @endphp
                                        @foreach($items as $key=>$value)
                                            <tr>
                                                <td>{{$count}}</td>
                                                <td>{{$key}}</td>
                                                <td>{{$value[0]}}</td>
                                                <td>{{$value[1]}}</td>
                                                <td>
                                                    <form class="d-inline" method="post"
                                                          action="{{route('file.db_mng')}}">
                                                        @csrf
                                                        <input type="hidden" name="filename" value="{{$key}}">
                                                        <input type="hidden" name="do" value="restore">
                                                        <input name="frm_name" type="hidden" value="backup"/>
                                                        <button class="btn p-2" type="submit" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="{{__("common.restore_db")}}"><i
                                                                class="fas fa-sync"></i></button>
                                                    </form>
                                                    <form class="d-inline" method="post" id="delete_{{$count}}"
                                                          action="{{route('file.db_mng')}}">
                                                        @csrf
                                                        <input type="hidden" name="filename" value="{{$key}}">
                                                        <input type="hidden" name="do" value="delete">
                                                        <input name="frm_name" type="hidden" value="backup"/>
                                                        <button
                                                            onclick="confirm_then_submit('{{__("common.cnf_del")}}','delete_{{$count}}')"
                                                            class="btn p-2"
                                                            type="button" data-toggle="tooltip" data-placement="top"
                                                            title="{{__("common.del_this_bck")}}"><i
                                                                class="far fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                                @php $count = $count+1; @endphp
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100">
                                                <div
                                                    class="alert alert-dark col-12">{{__("common.no_bck_exist")}}</div>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("css_loc")
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/setting.css')}}">
    <link href="{{asset('css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
@endsection
@section("js_loc")
    <script type="text/javascript" src="{{asset("js/select2.min.js")}}"></script>
    <script src="{{asset('js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{asset('plugins/summernote/summernote-bs4.js')}}"></script>
    <script src="{{asset('js/setting.js')}}"></script>
@endsection
