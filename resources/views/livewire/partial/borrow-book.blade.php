

<div class="d-inline-block">
     
           </form>
             <style>
             .dateHighlight a { background: rgb(113 2 2) !important; color:white}
             .dateHighlight span { background: rgb(113 2 2) !important; color:white}
             .weekends>span{ background: #e5e4e4/* Old #f4d03f */ !important; color:white}
             .holiday>span{ background: #1dbc60 !important; color:white}

}</style>
    <div class="d-flex" style="    justify-content: flex-end;">
    <?php $activated = 0;?>
    @if(strpos($book_obj->preview_url, "google") !== false || strpos($book_obj->preview_url, "Amazon") !== false)
    @if(strpos($book_obj->preview_url, "printsec") !== false)
      <input class="button" type="button"
                onclick="show_preview()"
                value ="{{__("common.preview_book")}}">
    @endif
    @endif

      

        <input class="button" type="button" target="_blank" value="Details"
           href="{{$util::getIfNotEmpty($book_obj->preview_url) ?? ($book_obj->custom_file ? asset("uploads/".$book_obj->custom_file):"#")}}">
        @can("mng-borrow-book")
            @if($common::getSiteSettings("enable_user_borrow") && Auth::id() && $books_available)
                 <input class="button" type="button" value="{{__("commonv2.borrow_now")}}"
                        wire:click="listAvailableBooks">
                   @elseif(!$books_available)
                   <input class="button" type="button" value="Reservation"
                        wire:click="listAvailableBooks">
            @endif
        @endif
    </div>
    @php
    $now = new DateTime();
    $currentYear = $now->format('Y');
    $nextYearDT = $now->add(new DateInterval('P1Y'));
    $nextYear = $nextYearDT->format('Y');
    $holidaysdate = [];
    $temp;
    $templimit;
$holidays = App\Models\HolidaysManager::get();
foreach($holidays as $datedata){
    if(isset($datedata->noticetodate)){
     if(substr($datedata->noticedate, -4) == "xxxx"){
     
     $temp = new DateTime(substr($datedata->noticedate,0, -4).$currentYear);
     $templimit = new DateTime(substr($datedata->noticetodate,0, -4).$currentYear);
     while($temp <= $templimit){
     array_push($holidaysdate,$temp->format('m/d/Y'));
    $temp->add(new DateInterval('P1D'));
    }

     $temp = new DateTime(substr($datedata->noticedate,0, -4).$nextYear);
     $templimit = new DateTime(substr($datedata->noticetodate,0, -4).$nextYear);

     while($temp <= $templimit){
     array_push($holidaysdate,$temp->format('m/d/Y'));
    $temp->add(new DateInterval('P1D'));
    }
     


     }
     else{
    $templimit =  new DateTime($datedata->noticetodate);
    $temp = new DateTime($datedata->noticedate);

    while($temp <= $templimit){
     array_push($holidaysdate,$temp->format('m/d/Y'));
    $temp->add(new DateInterval('P1D'));
    }



    
    }
    }else{
       if(substr($datedata->noticedate, -4) == "xxxx"){
    array_push($holidaysdate,(substr($datedata->noticedate,0, -4).$nextYear));
    array_push($holidaysdate,(substr($datedata->noticedate,0, -4).$currentYear));
    }else{
        array_push($holidaysdate,$datedata->noticedate);
    }
    }
    
}
@endphp
    @if(count($available_books))
    
        <div class="d-block mt-3">
            <ul class="list-group">
            @if($available_books)
            @foreach($available_books as $book)
            @endforeach
            @if($activated == 0)
           
 @endif

   
@endif



            </li>
            @php
            $copies = 0;
            $copiesdatepick = 0;
            @endphp
                @foreach($available_books as $book)
                @php
                $copiesdatepick = $copiesdatepick + 1;
                @endphp
                 <span style="margin:0px;">Accession: {{$book->sub_book_id}} <br>Borrow and Return Date (from - to) </span>
            <li class="list-group-item">
                           
                            
                            <input id="issue_date_tmp{{$copiesdatepick}}" type="text" class="issue_date_tmp{{$copiesdatepick}}" @if($common::checkIfInBorrowedRequest($book->sub_book_id,$user_id)) disabled
                        @endif

                        style="
                
    height: calc(2.25rem + 5px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    width:110px;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
"> <span style="margin:5px;"> to</span>


<input id="return_date_tmp{{$copiesdatepick}}" type="text" class="return_date_tmp{{$copiesdatepick}}" disabled style="
                
    height: calc(2.25rem + 5px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    width:110px;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
">
    
<script>
let dates{{$copiesdatepick}} = [];


function getifday(date,holiday){

for (let i = 0; i < 5; i++) {
if(dates{{$copiesdatepick}}.includes(getFormattedDate(addDays(date,1)))){

}
else{

switch(date.getDay()){
    case 0: date = addDays(date,1);
    break;
    default:while(holiday.includes(getFormattedDate(date))){
date = addDays(date,1);
}
    date = addDays(date,1);
break;
}
if(date.getDay() == 0){
date = addDays(date,1);
}
}

}

return date;


}







function getifdaybuilder(date,holiday){

dates{{$copiesdatepick}}.push(getFormattedDate(date));
for (let i = 0; i < 5; i++) {

switch(date.getDay()){
    case 0: date = addDays(date,1);
    dates{{$copiesdatepick}}.push(getFormattedDate(date));
    break;
    default: while(holiday.includes(getFormattedDate(date))){
date = addDays(date,1);
dates{{$copiesdatepick}}.push(getFormattedDate(date));
}
date = addDays(date,1); dates{{$copiesdatepick}}.push(getFormattedDate(date));break;
}


if(date.getDay() == 0){
date = addDays(date,1);
dates{{$copiesdatepick}}.push(getFormattedDate(date))
}
}

}










function addDays(date, days) {
  const copy = new Date(Number(date))
  copy.setDate(date.getDate() + days)
  return copy
}










function datebuilder(date){
getifday(date);

}










function getFormattedDate(date) {
    let year = date.getFullYear();
    let month = (1 + date.getMonth()).toString().padStart(2, '0');
    let day = date.getDate().toString().padStart(2, '0');
  
    return month + '/' + day + '/' + year;
}





 @if($common::checkIfInBorrowedRequestsolo($book->sub_book_id))
 
var today = new Date();
 var data = {!!$common::checkIfInBorrowedRequestsoloData($book->sub_book_id)!!};
 var holidays = @json($holidaysdate);
 var borroweddata = {!!$common::checkIfInBorrowedsoloData($book->id)!!};
 data = data.concat(borroweddata);
 data.forEach(element =>  getifdaybuilder(new Date(element),holidays));

 var disabledDates = dates{{$copiesdatepick}};
 console.log(disabledDates);
    $("#issue_date_tmp{{$copiesdatepick}}").datepicker({
    beforeShowDay: function(date){
            var string = jQuery.datepicker.formatDate('mm/dd/yy', date);
            var day = date.getDay();
            if((day != 0)){
            if((disabledDates.indexOf(string) == -1)){
            return [holidays.indexOf(string) == -1, holidays.indexOf(string) == -1 ? "":"holiday"];
            }else{
            return [disabledDates.indexOf(string) == -1, disabledDates.indexOf(string) == -1 ? "":"dateHighlight"];
            }
            
            
            }else{
             return [day != 0, day != 0 ? "":"weekends"];
            }
           
            },
            todayHighlight: false,
            minDate: today,
        dateFormat: 'mm/dd/yy',
        altField: "#issue_date",
        altFormat: 'mm/dd/yy',
        onSelect: function () {
         var x =new Date($('#issue_date_tmp{{$copiesdatepick}}').val());
        if(disabledDates.includes(x)){
        alert("That date is occupied");
        }
        else{

        }
        var y = new Date($('#issue_date_tmp{{$copiesdatepick}}').val());
       
        
        
        var offset = Math.abs(today.getDate() - y.getDate());
        
            $("#return_date_tmp{{$copiesdatepick}}").datepicker({
        dateFormat: 'mm/dd/yy',
        altField: "#return_date",   
        altFormat: 'mm/dd/yy',
        
        onSelect: function (setDate,x) {},}).datepicker("setDate", new Date(getifday(x,holidays))).datepicker('disable');;

        
        },
    }).datepicker("setDate", new Date());
    $('#issue_date_tmp{{$copiesdatepick}}').val("Pick Date");

    
 @else
var today = new Date();
 var data = {!!$common::checkIfInBorrowedRequestsoloData($book->sub_book_id)!!};
 var holidays = @json($holidaysdate);
 var borroweddata = {!!$common::checkIfInBorrowedsoloData($book->id)!!};
 data = data.concat(borroweddata);
 data.forEach(element =>  getifdaybuilder(new Date(element),holidays));

 var disabledDates = dates{{$copiesdatepick}};
 console.log(disabledDates);
    $("#issue_date_tmp{{$copiesdatepick}}").datepicker({
    beforeShowDay: function(date){
            var string = jQuery.datepicker.formatDate('mm/dd/yy', date);
            var day = date.getDay();
            if((day != 0)){
            if((disabledDates.indexOf(string) == -1)){
            return [holidays.indexOf(string) == -1, holidays.indexOf(string) == -1 ? "":"holiday"];
            }else{
            return [disabledDates.indexOf(string) == -1, disabledDates.indexOf(string) == -1 ? "":"dateHighlight"];
            }
            
            
            }else{
             return [day != 0, day != 0 ? "":"weekends"];
            }
           
            },
            todayHighlight: false,
            minDate: today,
        dateFormat: 'mm/dd/yy',
        altField: "#issue_date",
        altFormat: 'mm/dd/yy',
        onSelect: function () {
         var x =new Date($('#issue_date_tmp{{$copiesdatepick}}').val());
        if(disabledDates.includes(x)){
        alert("That date is occupied");
        }
        else{

        }
        var y = new Date($('#issue_date_tmp{{$copiesdatepick}}').val());
       
        
        
        var offset = Math.abs(today.getDate() - y.getDate());
        
            $("#return_date_tmp{{$copiesdatepick}}").datepicker({
        dateFormat: 'mm/dd/yy',
        altField: "#return_date",   
        altFormat: 'mm/dd/yy',
        
        onSelect: function (setDate,x) {},}).datepicker("setDate", new Date(getifday(x,holidays))).datepicker('disable');;

        
        },
    }).datepicker("setDate", new Date());
    $('#issue_date_tmp{{$copiesdatepick}}').val("Pick Date");

    @endif
</script>
    




                @php
                $copies += 1;
                @endphp
                    <li class="list-group-item">
                        @if($common::checkIfInBorrowedRequest($book->sub_book_id,$user_id))
                            <input id="targeet{{$copies}}" class="button"
                            type="button" value="Cancel Borrow "
                                    wire:click="cancelThis('{{$book->sub_book_id}}')"><span>
                                    @if($common::checkIfInBorrowedRequestsolo($book->sub_book_id))
                                    Reserved
                                    @else
                                    Available
                                    @endif
                                    </span>
                            </button>
                        @else
                            <input id="target{{$copies}}" class="button"
                            type="button" value=
                            @if($common::checkIfInBorrowedRequestsolo($book->sub_book_id))
                                    "Schedule a Reservation"   
                                    @else
                                    "Reserve"   
                                    @endif

                                    
                            </button>



                            <script>
                            function addDays(date, days) {
  const copy = new Date(Number(date))
  copy.setDate(date.getDate() + days)
  return copy
}

                            function save(x,y) {
       
                            @php
                             $notifinfo = [];
                            $encrypt = $this->encrypt(json_encode($book->sub_book_id.$user_id));
                            @endphp
  window.livewire.emit('data_manager', {"issue_date": x});
  window.livewire.emit('data_manager', {"return_date": y});
  
        window.livewire.emit('data_manager', {"save_data": "{{$book->sub_book_id}}"});
        

}


                            
                            var y ;
       var x;
       Date.prototype.isValid = function () {
    // An invalid date object returns NaN for getTime() and NaN is the only
    // object not strictly equal to itself.
    return this.getTime() === this.getTime();
};  
        $( "#target{{$copies}}" ).click(function() {
        try {
      
        var y =  addDays(new Date($('#return_date_tmp{{$copiesdatepick}}').val()),1);
        var x = addDays(new Date($('#issue_date_tmp{{$copiesdatepick}}').val()),1);
       
        if(y.isValid() && x.isValid()){
        save(x.toISOString().substring(0, 10),y.toISOString().substring(0, 10));
        var y =  addDays(new Date($('#return_date_tmp{{$copiesdatepick}}').val()),0);
        var x = addDays(new Date($('#issue_date_tmp{{$copiesdatepick}}').val()),0);

            // $("#myModal").modal();
             
        var a =` {!! QrCode::size(200)->generate($encrypt) !!}`
  document.getElementById("demo").innerHTML = a;
  document.getElementById("iss").innerHTML = x.getFullYear() + "-" + (x.getMonth() + 1) + "-" + x.getDate();
  
  document.getElementById("ret").innerHTML = y.getFullYear() + "-" + (y.getMonth() + 1) + "-" + y.getDate();
        }else{
            
        }
        
        }
       
catch(err) {

  alert(err);
}

        
});
       

        </script>
                        @endif
                      <span> @if($common::checkIfInBorrowedRequestsolo($book->sub_book_id))
                                    Reserved by other : {{implode(",",json_decode($common::checkIfInBorrowedRequestsoloData($book->sub_book_id)))}}.
                                    @else
                                    Available for reservation
                                    @endif</span>
                      
                    </li><br>
                @endforeach
                
            </ul>
        </div>
        
       
    @endif

</div>

  <!-- Trigger the modal with a button -->

  <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(113 2 2);">
        <h4 class="modal-title" style="color: white!important;">SHAN ELIB QR AUTOMATION</h4>
          <button style="color: white!important;" type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div><br>
        <div id="demo" style="display: flex!important;
    justify-content: center;">
        </div>
        <div class="modal-body">
        <p style="font-size:24px;margin:0!important;">Title: <span style="font-size:24px;">{{isset($book_obj) ? $book_obj->title : "N/A"}}</span></p>
        <br>
        <p style="font-size:18px;margin:0!important;">Expected Borrowing Date : <span id="iss" style="font-size:18px;"></span> </script></p>
        <p style="font-size:18px;margin:0!important;">Expected Returning Date : <span id="ret" style="font-size:18px;"></span> </script></p>
          <p style="color:red;font-size:12px;margin:0!important;">*Save or Screenshot this image.<br>Valid only for 3 Days after the borrowing date<br>Proceed on Library and get QR scanned<br>Claim book on the librarian</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
<style>
.popup {
  display: none;
  position: fixed;
  padding: 10px;
  width: 280px;
  left: 50%;
  margin-left: -150px;
  height: 180px;
  top: 50%;
  margin-top: -100px;
  background: #FFF;
  z-index: 20;
}
</style>
