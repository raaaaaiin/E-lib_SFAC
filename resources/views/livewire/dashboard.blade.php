  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
           
  <style>
  .card{
      max-height:550px;
      min-height:550px;
      overflow:hidden;
  }
  .table tbody td {
    border: none;
     padding-top: 0px; 
     padding-bottom: 0px; 
    font-size: 14px;
    background: #fff;}

  </style>
  

             <div class="main-section d-flex justify-content-center" ><div class="container" style="  max-width: 1400px;">

              @php

$firstDayofPreviousMonth = Carbon\Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
$lastDayofPreviousMonth = Carbon\Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
 $mostborrowedpreviousmonth =  App\Models\Borrowed::select('sub_book_id','book_id','created_at',App\Models\UserDataMeta::raw('count(sub_book_id) as Amount'))->whereBetween('created_at', [$firstDayofPreviousMonth, $lastDayofPreviousMonth])->groupBy("sub_book_id")->orderBy("amount","desc")->LIMIT(10)->get();        
                            @endphp
  <div class="col">
                            <div class="alert alert-light" role="alert">
                                <h4 class="alert-heading">Recommendation on book demand</h4>
                                <hr/>
                                <p>"Buy another copy or alternatively marked as Book Reserve:
                                @foreach($mostborrowedpreviousmonth as $mbrData)
                                            {{Illuminate\Support\Str::limit(App\Models\SubBook::get_directbook_name($mbrData->book_id), 45,)}}
                                            @endforeach

                                "</p>
                            </div>
                        </div>


            


             <div class='search-input d-flex pb-2' style="justify-content: flex-end; ">
              
        <input id="dateonchange" value="{{$this->echototest =="Null" ? "mm/dd/yyyy" : $this->echototest}}"style="
                
    height: calc(2.25rem + 5px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    width:calc(10em + 5px);
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
" type='date' name='dateselection' class="issue_date_tmp hasDatepicker" id='dateselection' value="">


<button class="btn btn-dark btn-sm ml-2" name="submit" type="submit" value="save" style="height: calc(2.25rem + 5px);"><i class="far fa-hdd mr-1"></i> Over all Statistic                        </button>
    </div>
    <script>
   $('#dateonchange').change(function(){
    window.livewire.emit('data_manager', $('#dateonchange').val());	
    });
    
    </script>
<div class="row">
                            <div class="col-lg-3 col-6">
                                <div class="card" style="height:150px;max-height:150px!important;min-height:150px!important" >
                                    <div class="card-body" style="height:150px;max-height:150px!important;min-height:150px!important">
                                        <h5 class="text-muted">Total User</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">{{\App\Models\User::count()}}</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <span><!-- <i class="fa fa-fw fa-arrow-up"></i> Font Awesome fontawesome.com --></span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6" style="height:150px;max-height:150px!important;min-height:150px!important">
                                <div class="card" style="height:150px;max-height:150px!important;min-height:150px!important">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Book Borrowed</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">{{\App\Models\borrowed::count()}}</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <span><!-- <i class="fa fa-fw fa-arrow-up"></i> Font Awesome fontawesome.com --></span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue2"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6" style="height:150px;max-height:150px!important;min-height:150px!important">
                                <div class="card" style="height:150px;max-height:150px!important;min-height:150px!important">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Book Returned</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">{{\App\Models\borrowed::count() - \App\Models\borrowed::whereNull('date_returned')->count()}}</h1>
                                        </div>
                                        
                                    </div>
                                    <div id="sparkline-revenue3"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6" style="height:150px;max-height:150px!important;min-height:150px!important">
                                <div class="card" style="height:150px;max-height:150px!important;min-height:150px!important">
                                    <div class="card-body">
                                        <h5 class="text-muted">Available Book</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">{{\App\Models\SubBook::where("active",1)->count()}}</h1>
                                        </div>
                                        
                                    </div>
                                    <div id="sparkline-revenue4"></div>
                                </div>
                            </div>
                        </div>
                        <br>































<div id="change" class="row">

@php
  if(empty($this->echototest)){
  $date = date("Y/m/d");
  }
  else
  {
$newdate = $this->echototest;
$time = strtotime($newdate);
$newformat = date('m/d/y',$time);
$date = $newformat;
}

  $demographicData= $this->getDemographic($date);
  $returnRateData = $this->getReturnRate($date);
  $locationData = $this->getAddressLoc($date);
  $foottrafficData = $this->getFootTraffic($date);
 
   $this->displayA($returnRateData);
   $this->displayB($demographicData);
   $this->displayC($locationData);
   $this->displayD($foottrafficData);

@endphp
</div>



                        <div class="row">
                            <!-- ============================================================== -->
                      
                            <!-- ============================================================== -->

                                          <!-- recent orders  -->
                            <!-- ============================================================== -->
                            
                          <div class="col-lg-9">
                                <!-- ============================================================== -->
                                <!-- top perfomimg  -->
                                <!-- ============================================================== -->
                                @php


                                                  $searches =  App\Models\UserDataMeta::select('meta_value',App\Models\UserDataMeta::raw('count(meta_value) as Amount'),'meta_key')->groupBy("meta_value")->orderBy("amount","desc")->LIMIT(10)->get();
                                                 
                                                @endphp
                                <div class="card" >
                                    <h5 class="card-header">Top Searches</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table no-wrap p-table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Campaign</th>
                                                        <th class="border-0">Searched</th>
                                                        <th class="border-0">Typed</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($searches as $data)
                                               
                                                    <tr>
                                                        <td>{{$data["meta_value"]}}</td>
                                                        <td>{{$data["Amount"]}}</td>
                                                        <td>{{$data["meta_key"]}}</td>
                                                    </tr>
                                                    @endforeach
                                                    
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">Next</a>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- end top perfomimg  -->
                                <!-- ============================================================== -->
                            </div>
                            @php
                            $data= DB::select("Select b.id as cat_id,cat_name as cat_name, count(a.cat_id) 
as Amount, a.cat_id
from borroweds as A JOIN dewey_decimals as B on a.cat_id = B.id
group by a.cat_id 
order by amount 
desc limit 10");

$series = [];
                           $labels =[];
                            foreach($data as $data){
                                array_push($series, $data->Amount);
                                array_push($labels, $data->cat_name);
                            }
                            $imploded_string = implode(",", $series);
                            $implodedv2_string = implode('","', $labels);

                            @endphp
                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Most Category borrowed</h5>
                                    <div class="card-body">
                                    <div id="chartG">
                                    </div>
                                        <script>
                                            var options = {
          series: [{{$imploded_string}}],
           labels: [{!!'"'.$implodedv2_string.'"'!!}],
          chart: {
          height: 350,
          type: 'donut',
        },legend: {
        position: 'bottom',
        offsetY: 1
    },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 350
            },
            
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chartG"), options);
        chart.render();
                                        </script>
                                     
                                     </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->

    
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- customer acquistion  -->
                            <!-- ============================================================== -->
                           
                            <!-- ============================================================== -->
                            <!-- end customer acquistion  -->
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                        @php
                        $latestborrow =  App\Models\Borrowed::orderby('id','desc')->LIMIT(8)->get();
                        @endphp
                        <div class="col-lg-12">
                                <div class="card">
                                    <h5 class="card-header">Recent Borrow</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">No</th>
                                                        <th class="border-0">Image</th>
                                                        <th class="border-0">Book Name</th>
                                                        <th class="border-0">Author</th>
                                                        <th class="border-0">Borrow Date</th>
                                                        
                                                        <th class="border-0">Return Date</th>
                                                        <th class="border-0">Borrower</th>
                                                        <th class="border-0">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($latestborrow as $latestdata)
                                                    <tr>
                                                        <td>{{$latestdata->id}}</td>
                                                        <td>
                                                            <div class="m-r-10"><img src="{{asset("uploads/".App\Models\User::get_user_photo($latestdata->user_id))}}" alt="user" class="rounded" width="45"></div>
                                                        </td>
                                                        <td>{{App\Models\SubBook::get_directbook_name($latestdata->book_id)}}</td>
                                                        <td>	Mark Myers</td>
                                                        <td>{{$latestdata->date_borrowed}}</td>
                                                        
                                                        <td>{{$latestdata->date_returned}}</td>
                                                        <td>{{App\Models\User::get_user_name($latestdata->user_id)}}</td>
                                                        <td><span class="badge-dot badge-brand mr-1"></span>{{$latestdata->date_returned ? "Returned" : "Issued"}}</td>
                                                    </tr>
                                                    @endforeach
                                                       
                                                    
                                                    
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">Next</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
              				                        <!-- product category  -->
                            <!-- ============================================================== -->
                           
                            <!-- ============================================================== -->
                            <!-- end product category  -->
                                   <!-- product sales  -->
                            <!-- ============================================================== -->
                            
                            <!-- ============================================================== -->
                            <!-- end product sales  -->
                            <!-- ============================================================== -->
                            
                        </div>

                       
                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- total revenue  -->
                            <!-- ============================================================== -->
  
                            
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- category revenue  -->
                            <!-- ============================================================== -->
                            
                            <!-- ============================================================== -->
                            <!-- end category revenue  -->
                            <!-- ============================================================== -->

                            <div class="col-lg-9">
                                <div class="card">
                                @php
                                 $requesttransac = App\Models\UserNotif::select(App\Models\UserNotif::raw('DATE(created_at) as date'),
                                 'meta_key as req',App\Models\UserNotif::raw('count(created_at) as cnt'))
                                 ->whereIn('meta_key',['Request','Approved','Return'])
                                 ->groupby(['meta_key','date'])
                                 ->having('cnt', '>', -1)
                                 ->orderby('date','asc')
                                 ->get();
                                 $builderdate =[];
                                 $builderA =[];
                                 $builderB =[];
                                 $builderC =[];
                                 $position = -1;
                                 $mutex ="";

                                 foreach($requesttransac as $data){

                                 if (in_array($data->date, $builderdate)) {
                                  
                                 
                                    
                                        
                                    }else{
                                    $position = $position + 1;
                                     
                                    array_push($builderdate,$data->date);
                                        $builderA[$position] = 0;
                                        $builderB[$position] = 0;
                                        $builderC[$position] = 0;
                                    }

                              





                                 if($data->req =="Request"){
                                 
                                 $builderA[$position] = $data->cnt;
                                 
                                 
                             
                                 }

                                 if($data->req =="Approved"){
                                 $builderB[$position] = $data->cnt;
                                 
                                 }

                                 if($data->req =="Return"){
                                 $builderC[$position] = $data->cnt;

                                 }
                                 

                                    
                                   
                               


                                 }
                                 $implodedA = implode('","', $builderA);
                                 $implodedB = implode('","', $builderB);
                                 $implodedC = implode('","', $builderC);
                                 $implodedD = implode('","', $builderdate);
                                @endphp
                                    <h5 class="card-header">Monthly Transaction</h5>
                                    <div class="card-body" style="overflow:hidden">
                                        <div id="displayH">

                                        </div>
                                        <script>
                                        var options = {
          series: [{
          name: 'Request',
          data: [{!!'"'.$implodedA.'"'!!}]
        }, {
          name: 'Approved',
          data: [{!!'"'.$implodedB.'"'!!}]
        }, {
          name: 'Return',
          data: [{!!'"'.$implodedC.'"'!!}]
        }],
          chart: {
          height: 350,
          type: 'area'
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
          categories: [{!!'"'.$implodedD.'"'!!}]
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          },
        },
        };

        var chart = new ApexCharts(document.querySelector("#displayH"), options);
        chart.render();
                                        </script>
                                    <div class="card-footer">
                                        
                                    </div>
                                    </div>
                                </div>
                            </div>


                        
                                                    <div class="col-lg-3">
                                <div class="card">
                                @php
                                 $clickcondition = array("VisitCategories");
                            $clicked =  App\Models\UserDataMeta::select('meta_value',App\Models\UserDataMeta::raw('count(meta_value) as Amount'),'meta_key')->whereIn('meta_key',$clickcondition)->groupBy("meta_value")->orderBy("amount","desc")->LIMIT(5)->get();
                           $series = [];
                           $labels =[];
                            foreach($clicked as $data){
                                array_push($series, $data->Amount);
                                array_push($labels, $data->meta_value);
                            }
                            $imploded_string = implode(",", $series);
                            $implodedv2_string = implode('","', $labels);
                            
                                @endphp
                                    <h5 class="card-header">Most Clicked Category</h5>
                                    <div class="card-body">
                                        <div id="displayI">
                                       
                                        </div>
                                      
                                        <script>
                                        
                                        var options = {
          series: [
          {{$imploded_string}}
          
          ],
           labels: [{!!'"'.$implodedv2_string.'"'!!}],
          chart: {
          height: 350,
          type: 'donut',
        },legend: {
        position: 'bottom',
        offsetY: 1
    },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 350
            },
            
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#displayI"), options);
        chart.render();
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        



                        <div class="row">
                            <div class="col-lg-4">
                                <!-- ============================================================== -->
                                <!-- social source  -->
                                <!-- ============================================================== -->
                                @php
                                 $mostborrowed =  App\Models\Borrowed::select('sub_book_id','book_id',App\Models\UserDataMeta::raw('count(sub_book_id) as Amount'))->groupBy("sub_book_id")->orderBy("amount","desc")->LIMIT(10)->get();
                                @endphp
                                <div class="card">
                                    <h5 class="card-header">Most borrowed book</h5>
                                    <div class="card-body p-0">
                                        <ul class="social-sales list-group list-group-flush">
                                        @foreach($mostborrowed as $mbrData)
                                            <li class="list-group-item social-sales-content"><span class="social-sales-name">{{Illuminate\Support\Str::limit(App\Models\SubBook::get_directbook_name($mbrData->book_id), 45,)}}</span><span style="color: #c6c6c6;" class="float-right text-dark">{{$mbrData->Amount}} <i style="color: #c6c6c6;" class="fa fa-eye" aria-hidden="true"></i></span>
                                            </li>
                                            @endforeach
                                            
                                            
                                        </ul>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">Next</a>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- end social source  -->
                                <!-- ============================================================== -->
                            </div>
                            <div class="col-lg-4">
                            @php
                            $trendingcondition = array("Categories","VisitCategories");
                            $trending =  App\Models\UserDataMeta::select('meta_value',App\Models\UserDataMeta::raw('count(meta_value) as Amount'),'meta_key')->whereIn('meta_key',$trendingcondition)->groupBy("meta_value")->orderBy("amount","desc")->LIMIT(10)->get();
                           
                            @endphp
                                <!-- ============================================================== -->
                                <!-- sales traffice source  -->
                                <!-- ============================================================== -->
                                <div class="card">
                                    <h5 class="card-header">Trend Category</h5>
                                    <div class="card-body p-0">
                                    <ul class="country-sales list-group list-group-flush">
                                        @foreach($trending as $views)
                                         <li class="country-sales-content list-group-item"><span class="mr-2"> </span>
                                                <span alt="" class="">{{$views->meta_value}}</span><span style="color: #c6c6c6;" class="float-right text-dark">{{$views->Amount}} <i style="color: #c6c6c6;" class="fa fa-eye" aria-hidden="true"></i></span>
                                            </li>
                                        @endforeach
                                           
                                           
                                        </ul>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">Next</a>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end sales traffice source  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- sales traffic country source  -->
                            <!-- ============================================================== -->
                            <div class="col-lg-4">
                            @php
                             $clicked =  App\Models\BookMeta::where('meta_key','Views')->orderByRaw('CONVERT(meta_value, SIGNED) desc')->LIMIT(9)->get();
                             
                            @endphp
                                <div class="card">
                                    <h5 class="card-header">Top Clicked Book</h5>
                                    <div class="card-body p-0">
                                        <ul class="country-sales list-group list-group-flush">
                                        @foreach($clicked as $views)
                                         <li class="country-sales-content list-group-item"><span class="mr-2"> </span>
                                                <span alt="App\Models\SubBook::get_directuniquebook_name($views->unique_id)" class="">{{Illuminate\Support\Str::limit(App\Models\SubBook::get_directuniquebook_name($views->unique_id), 45,)}}</span><span style="color: #c6c6c6;" class="float-right text-dark">{{$views->meta_value}} <i style="color: #c6c6c6;" class="fa fa-eye" aria-hidden="true"></i></span>
                                            </li>
                                        @endforeach
                                           
                                           
                                        </ul>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">Next</a>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end sales traffice country source  -->
                            <!-- ============================================================== -->
                        </div>
</div> 
</div>

