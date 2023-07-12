@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("common.master")
@section("css_loc")
    <style>
        * {
            color: black;
        }

        td {
            padding: 10px;
        }

        h3 p {
            margin: 0px;
        }

        @media print {
            table {
                /* tables don't split across pages if possible. */
                page-break-inside: avoid;
            }

            .dashbtn {
                display: none !important;
            }
        }
    </style>
@endsection
@section("title") {{__("commonv2.print_report")}} @endsection
@section("content")
    <div class="container-fluid">
        <div class="row dashbtn">
            <div class="col"><a href="{{route('reports.index')}}"
                                class="btn btn-dark">{{__("commonv2.go_back_to_report")}}</a>
            </div>
        </div>
        <div class="row">
            <div>
                
                <h2 style="text-align: center;padding: 0;margin: 0;">{{$common::getSiteSettings("org_name")}}</h2>
                <h3 style="text-align: center;margin: 0;">
                    {!!$util::goodFormatAddress($common::getSiteSettings("org_address"))!!}</h3>
                <h4 style="    text-align: center;
    text-decoration: underline;
    font-size: 28px;
    font-weight: bold;
    font-family: inherit;
    font-variant: all-small-caps;
    margin: 10px;">{{$title}}</h4>
            </div>
            <table id="tbl_exporttable_to_xls" border="1" style="margin: auto;font-size: 13px;font-family: monospace;">
                @if($book_details && $todo=="damage_books")
                    <thead>
                    <tr>
                        <td>{{__("common.book_id")}}</td>
                        <td>{{__("common.book_name")}}</td>
                        <td>{{__("common.user_id")}}</td>
                        <td>{{__("commonv2.user_name")}}</td>
                        <td>{{__("commonv2.date_updated")}}</td>
                        <td>{{__("common.remark")}}</td>
                    </tr>
                    </thead>
                    @foreach($book_details as $item)
                        <tr>
                            <td>{{$item->sub_book_id}}</td>
                            <td>{{$item->book->title}}</td>
                            <td>{{$item->user_damaged->id}}</td>
                            <td>{{$item->user_damaged->name}}</td>
                            <td>{{Util::goodDate($item->updated_at)}}</td>
                            <td>{{$item->remark}}</td>
                        </tr>
                    @endforeach
                @elseif($book_details && $todo=="most_issued_books")

                    <thead>
                    <tr>
                        <td>{{__("common.book_id")}}</td>
                        <td>{{__("common.book_name")}}</td>
                        <td>{{__("common.count")}}</td>
                    </tr>
                    </thead>
                    @foreach($book_details as $item)
                        <tr>
                            <td>{{$item->book_id}}</td>
                            <td>{{$item->book->title}}</td>
                            <td>{{$item->count}}</td>
                        </tr>
                    @endforeach
                @elseif($book_details && $todo=="losted_books")
                    <thead>
                    <tr>
                        <td>{{__("common.book_id")}}</td>
                        <td>{{__("common.book_name")}}</td>
                        <td>{{__("common.user_id")}}</td>
                        <td>{{__("common.lost_by")}}</td>
                        <td>{{__("common.date_returned")}}</td>
                    </tr>
                    </thead>
                    @foreach($book_details as $item)
                        <tr>
                            <td>{{$item->sub_book_id}}</td>
                            <td>{{$item->book->title}}</td>
                            <td>{{$item->user_lost->id}}</td>
                            <td>{{$item->user_lost->name}}</td>
                            <td>{{Util::goodDate($item->updated_at)}}</td>
                        </tr>
                    @endforeach
                @elseif($book_details && $todo=="late_returned")
                    <thead>
                    <tr>
                        <td>{{__("common.book_id")}}</td>
                        <td>{{__("common.book_name")}}</td>
                        <td>{{__("common.user_id")}}</td>
                        <td>{{__("common.full_name")}}</td>
                        <td>{{__("common.issued_by")}}</td>
                        <td>{{__("commonv2.delayed_days")}}</td>
                    </tr>
                    </thead>
                    @foreach($book_details as $item)
                        <tr>
                            <td>{{$item->sub_book->sub_book_id}}</td>
                            <td>{{$item->book->title}}</td>
                            <td>{{$item->user->id}}</td>
                            <td>{{$item->user->name}}</td>
                            <td>{{$item->issued_by_person->name}}</td>
                            <td>{{\Carbon\Carbon::parse($item->date_to_return)
                            ->diffInDays(\Carbon\Carbon::parse($item->date_returned))}}</td>
                        </tr>
                    @endforeach
                @elseif($book_details && $todo=="fines_collected")
                    <thead>
                    <tr>
                        <td>{{__("common.book_id")}}</td>
                        <td>{{__("common.book_name")}}</td>
                        <td>{{__("common.user_id")}}</td>
                        <td>{{__("common.full_name")}}</td>
                        <td>{{__("common.issued_by")}}</td>
                        <td>{{__("commonv2.delayed_days")}}</td>
                        <td>{{__("commonv2.fine_paid")}}</td>
                        <td>{{__("commonv2.issued_on")}}</td>
                        <td>{{__("commonv2.returned_on")}}</td>
                    </tr>
                    </thead>
                    @php $fine_collected = 0; @endphp

                    @foreach($book_details as $item)
                        <tr>
                            <td>{{$item->sub_book->sub_book_id}}</td>
                            <td>{{$item->book->title}}</td>
                            <td>{{$item->user->id}}</td>
                            <td>{{$item->user->name}}</td>
                            <td>{{$item->issued_by_person->name}}</td>
                            <td>{{\Carbon\Carbon::parse($item->date_to_return)
                            ->diffInDays(\Carbon\Carbon::parse($item->date_returned))}}</td>
                            <td>{{$item->fine}}</td>
                            <td>{{Util::goodDate($item->date_borrowed)}}</td>
                            <td>{{Util::goodDate($item->date_returned)}}</td>
                        </tr>
                        @php $fine_collected += $item->fine @endphp
                    @endforeach
                    <tr>
                        <td>{{__("commonv2.total_fine_collected")}}</td>
                        <td colspan="20"><span
                                class="mr-2">{{$common::getSiteSettings("currency_symbol")}}</span>{{$fine_collected}}
                        </td>
                    </tr>
                @elseif($book_details && $todo=="all_books")
                    <thead>
                    <tr>				
                        <td>{{__("ACCESSION NO.")}}</td>
                        <td>{{__("DATE")}}</td>
                        <td>{{__("TITLE")}}</td>
                        <td>{{__("Edition")}}</td>
                        <td>{{__("AUTHOR")}}</td>
                        <td>{{__("COPYRIGHT")}}</td>
                        <td>{{__("PLACEPUB")}}</td>
                        <td>{{__("PUBLISHER")}}</td>
                        <td>{{__("DDC CALL NO")}}</td>
                        <td>{{__("PRICE")}}</td>
                    </tr>
                    </thead>

                    @foreach($book_details as $item)
                        <tr>
                            <td>{{$item->sub_book_id}}</td>
                            
                            <td>{{Util::goodDate($item->created_at)}}</td>
                            <td>{{$item->book->title}}</td>
                            
                            <td>{{$item->book->edition}}</td>

                            <td>{{$item->book->author}}</td>



                            <td>{{$item->book->published_date}}</td>
                            <td>{{$item->book->published_loc}}</td>
                            <td>{{$item->book->publisher}}</td>
                            <td>{{$item->book->circulation}} {{$item->book->dewey}} {{$item->book->authornumber}} {{$item->book->published_date}}</td>


                            <td>{{$item->book->price}}</td>
                            
                        </tr>
                       
                    @endforeach
                    
                @elseif($book_details && $todo=="all_active_student")
                
                    <thead>
                    <tr>	 			
                        <td>Std Id</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Role</td>
                        <td>Course</td>
                        <td>Section</td>
                        <td>Active</td>
                        <td>DateRegistered</td>
                    </tr>
                    </thead>

                    @foreach($book_details as $item)
                    @php
                                                $user_meta = App\Models\UserMeta::where("user_id",$item->id)->first();
                                                $assigned_on = null;
                                                if($user_meta){
                                                    $assigned_on = json_decode($user_meta->get_assign());
                                                }
                                            @endphp
                        <tr>
                            <td>{{$item->id}}</td>
                            
                            
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>@foreach(\App\Models\User::get_current_user_roles($item->id) as $role){{Str::title($role->name)}} @endforeach</td>

                            <td> @if(is_countable($assigned_on))
                                                @foreach($assigned_on as $items)
                                                    @foreach($items as $course=>$year)
                                                 
                                                         {{$common::getCourseName($course)}}
                                                    
                                                    @endforeach
                                                @endforeach
                                            @endif
                            </td>

                            <td>
                                            @if(is_countable($assigned_on))
                                                @foreach($assigned_on as $items)
                                                    @foreach($items as $course=>$year)
                                                      
                                                         {{$common::getCourseYearName($year)}}
                                                   
                                                    @endforeach
                                                @endforeach
                                            @endif
                                            </td>

                            

                            <td>{{$item->active}}</td>
                            <td>{{Util::goodDate($item->created_at)}}</td>
                            
                        </tr>
                       
                    @endforeach
                    @elseif($book_details && $todo=="all_inactive_student")
                
                    <thead>
                    <tr>	 			
                        <td>Std Id</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Role</td>
                        <td>Course</td>
                        <td>Section</td>
                        <td>Active</td>
                        <td>DateRegistered</td>
                    </tr>
                    </thead>

                    @foreach($book_details as $item)
                    @php
                                                $user_meta = App\Models\UserMeta::where("user_id",$item->id)->first();
                                                $assigned_on = null;
                                                if($user_meta){
                                                    $assigned_on = json_decode($user_meta->get_assign());
                                                }
                                            @endphp
                        <tr>
                            <td>{{$item->id}}</td>
                            
                            
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>@foreach(\App\Models\User::get_current_user_roles($item->id) as $role){{Str::title($role->name)}} @endforeach</td>

                            <td> @if(is_countable($assigned_on))
                                                @foreach($assigned_on as $items)
                                                    @foreach($items as $course=>$year)
                                                 
                                                         {{$common::getCourseName($course)}}
                                                    
                                                    @endforeach
                                                @endforeach
                                            @endif
                            </td>

                            <td>
                                            @if(is_countable($assigned_on))
                                                @foreach($assigned_on as $items)
                                                    @foreach($items as $course=>$year)
                                                      
                                                         {{$common::getCourseYearName($year)}}
                                                   
                                                    @endforeach
                                                @endforeach
                                            @endif
                                            </td>

                            

                            <td>{{$item->active}}</td>
                            <td>{{Util::goodDate($item->created_at)}}</td>
                            
                        </tr>
                       
                    @endforeach
                    @elseif($book_details && $todo=="all_issued")
                
                    <thead>
                    <tr>	 			
                        <td>Date</td>
                        <td>Accession</td>
                        <td>Name of borrower</td>
                        <td>Title</td>
                        <td>Name of Issuer</td>
                        
                    </tr>
                    </thead>

                    @foreach($book_details as $item)
                    <tr>
                               <td>{{Util::goodDate($item->created_at)}}</td>
                               <td>{{$item->sub_book_id}}</td>
                    @php
                    $hatdog = json_decode($item->meta_value);
                    
                    @endphp
                    @foreach($hatdog as $items)
                            
                            <td>{{ \App\Models\User::get_user_name($items->Target) }}</td>
                            
                            <td>{{ \App\Models\Book::get_book_name_byID($items->Modifier) }}</td>
                            <td>{{ \App\Models\User::get_user_name($items->User) }}</td>
                           
                            
                        </tr>
                        @endforeach
                       
                    @endforeach
                    @elseif($book_details && $todo=="all_return")
                
                    <thead>
                    <tr>	 			
                        <td>Date</td>
                        <td>Accession</td>
                        <td>Name of borrower</td>
                        <td>Title</td>
                        <td>Name of Issuer</td>
                        
                    </tr>
                    </thead>

                    @foreach($book_details as $item)
                    <tr>
                               <td>{{Util::goodDate($item->created_at)}}</td>
                               <td>{{$item->sub_book_id}}</td>
                    @php
                    $hatdog = json_decode($item->meta_value);
                    
                    @endphp
                    @foreach($hatdog as $items)
                            
                            <td>{{ \App\Models\User::get_user_name($items->User) }}</td>
                            
                            <td>{{ \App\Models\Book::get_book_name_byID($items->Modifier) }}</td>
                            <td>{{ \App\Models\User::get_user_name($items->Target) }}</td>
                           
                            
                        </tr>
                        @endforeach
                       
                    @endforeach
                    
                @else
                    <tr>
                        <td colspan="15">{{__("common.no_data_exist")}}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js", type="text/javascript"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
  function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('{{$title}}.' + (type || 'xlsx')));
    }
    ExportToExcel();
</script>
@endsection

