<?php

namespace App\Http\Livewire;

use App\Traits\CustomCommonLive;
use Livewire\Component;
use Redirect;

class Dashboard extends Component
{
    
    use CustomCommonLive;
    public $chart;
    public $echototest;
    public $today;

public $year;
public $month;
public $day;
public $hour;
public $weeknumber;
public $weekMap;
public $dayOfTheWeek;
public $weekday;

protected $listeners = ['data_manager','echototest'];
    public function data_manager($datas)
{

        
    Redirect::to('/dashboard/'.bin2hex($datas));
}
    public function mount($sdate){
   
    if($sdate == "Null"){
   
    }else{
      $this->echototest = hex2bin($sdate);
      
    }

    }

    public function render()
    {
    
     $this->today=  now();

 $this->year = $this->today->year;
$this->month = $this->today->month;
 $this->day =  $this->today->day;
 $this->hour = $this->today->hour;
 $this->weeknumber = $this->today->weekOfYear;
 $this->weekMap = [
    0 => 'Sun',
    1 => 'Mon',
    2 => 'Tue',
    3 => 'Wed',
    4 => 'Thu',
    5 => 'Fri',
    6 => 'Sat',
];
 $this->dayOfTheWeek = $this->today->dayOfWeek;
 $this->weekday = $this->weekMap[$this->dayOfTheWeek];
        return view('livewire.dashboard');
    }
   
function getDemographic($_date) {
 $date = Date("m/d/y");
$month = Date("M");
$Day = Date("d");
$year = Date("Y");
$timezoneTime = date("h a");
$location;
$HostName = "localhost";
$HostUser = "root"; //"kurtsevi_onetapph";
$HostPass = ""; //"hm9QLPizBWn1#4wZt6KG1";
$DatabaseName = "elib_sfac";
$conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);
    $HostName = "localhost";
$HostUser = "root";
$HostPass = "";
$DatabaseName = "elib_sfac";

$conn = mysqli_connect($HostName,$HostUser,$HostPass, $DatabaseName);
if(!$conn){
 die('Could not Connect My Sql:' .mysql_error());
}
    $currentselection = 7;
    $date = date("d-M-Y", strtotime($_date));
    
    $month = date("M", strtotime($date));
    $monthse = date("n", strtotime($date));
    $year = date("Y", strtotime($date));
    $endofmonth = date("t", strtotime($date));
    $male = 0;
    $female = 0;
    $selection = [0, 7, 14, 21, 28];
    $data = [];
    $graphrow = 5;
    //requires selected month
    //return each week of selected month
    // week must consist of total check in per 7 days
    //There is always offset at the end or starting week
    //
    //select * from web_checkin where month = '$month'
    //Data should look like this
    //Range of Day to define the week
    if ($graphrow = 5) {
        array_push($selection, $endofmonth);
    }
    //represent how many row
    //Data is multi dimensional (Aug 1 - Aug 7, Male, Female, Total)
    for ($x = 1;$x <= $graphrow;$x++) {
        $male = 0;
        $female = 0;
        $temp = $selection[$x - 1] + 1;
        $sql = "SELECT gender
            FROM `web_checkin` 
            Where Day >=  $temp
            AND Day <= ($selection[$x])
            AND Month =  '$monthse'
            AND Year = $year
            "
            
            ;

        $result = $conn->query($sql);
       
       if(empty($result)){
       }else{

        if ($result->num_rows > 0) {
         
            while ($row = $result->fetch_assoc()) {
             
                if ($row["gender"] == "MALE") {
                
     
                    $male++;
                } else {
                    $female++;
                }
            }
        } else {
        }
        array_push($data, [$month . " " . ($selection[$x - 1] + 1) . " - " . ($selection[$x]) . " ",
        //$year,
        $male, $female, $male + $female, ]);
       }
       
    }
    $conn->close();
    $currentselection+= 7;
    return $data;
}

function getReturnRate($_date ) {
     $date = Date("m/d/y");
$month = Date("M");
$Day = Date("d");
$year = Date("Y");
$timezoneTime = date("h a");
$branchName;
$location;
$qrStoreName = "D";

$HostName = "localhost";
$HostUser = "root"; //"kurtsevi_onetapph";
$HostPass = ""; //"hm9QLPizBWn1#4wZt6KG1";
$DatabaseName = "elib_sfac";
$conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);
$qrStoreName = $conn->real_escape_string($qrStoreName);

    $HostName = "localhost";

//Define your database username here.
$HostUser = "root";

//Define your database password here.
$HostPass = "";

//Define your database name here.
$DatabaseName = "elib_sfac";

$conn = mysqli_connect($HostName,$HostUser,$HostPass, $DatabaseName);
if(!$conn){
 die('Could not Connect My Sql:' .mysql_error());
}
    $date = date("d-M-Y", strtotime($_date));
    $month = date("M", strtotime($date));
    $year = date("Y", strtotime($date));
    $weekNo = date("W", strtotime($date));
    $endofmonth = date("t", strtotime($date));
    $pastvisitor = array();
    $currentvisitor = array();
    $returnee = array();
    //have choices
    //day
    //week
    //month
    //x = get count of ppl that visited #branchname  where date =$range
    //y = get count of ppl that visited #branchname where date
    //x is the visitor of this current week
    //check if x has already visited last week
    //if yes get the count of x that already visited last week
    //return y/x * 100 = returnrate percentage
    $sql = "SELECT DISTINCT name, weekNumber 
            FROM `web_checkin` 
            WHERE weekNumber in ($weekNo - 2,$weekNo - 1,$weekNo)
            AND year = $year 
            ";

    $result = $conn->query($sql);
     if(empty($result)){
    dd($result);
       }else{
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
       
            if ($row["weekNumber"] == ($weekNo - 2)) {
            
                if (in_array($row["name"], $pastvisitor)) {
                } else {
                    array_push($pastvisitor, $row["name"]);
                }
            }
              if ($row["weekNumber"] == ($weekNo - 1)) {
            
                if (in_array($row["name"], $pastvisitor)) {
                } else {
                    array_push($pastvisitor, $row["name"]);
                }
            }
              if ($row["weekNumber"] == $weekNo) {
            
                if (in_array($row["name"], $currentvisitor)) {
                   
                } else {
                    array_push($currentvisitor, $row["name"]);
                }
            }
            
        }
    } else {
    }
    }
    $conn->close();
    //get return rate by pastvisitor / current visitor * 100;
    foreach ($currentvisitor as $visitors) {
    if (in_array($visitors, $pastvisitor)) {
    array_push($returnee, $visitors);
                } else {
                    
                }
    }
    if (count($returnee)== 0 || count($pastvisitor) == 0){
    $returnrate =array((count($returnee) / 1) * 100,count($currentvisitor),count($pastvisitor),count($returnee));
    }else{
    $returnrate =array((count($returnee) / count($pastvisitor)) * 100,count($currentvisitor),count($pastvisitor),count($returnee));
    
    }
    
    //SELECT DISTINCT concat(fname," ",lname), weekNumber FROM `web_checkin` where weekNumber in (29,30,31) and qrStoreName = 'D'
    //figuring out how mysql data will output the user that entered this week and also entered last two weeks.
    //SELECT DISTINCT fname, weekNumber FROM `web_checkin` where weekNumber in (29,30,31) and qrStoreName = 'D'
    //31 = current Date
    //29,30 = past visitor
    return $returnrate;
}
function getAddressLoc($_date) {
 $date = Date("m/d/y");
$month = Date("M");
$Day = Date("d");
$year = Date("Y");
$timezoneTime = date("h a");
$branchName;
$location;
$qrStoreName = "D";

$HostName = "localhost";
$HostUser = "root"; //"kurtsevi_onetapph";
$HostPass = ""; //"hm9QLPizBWn1#4wZt6KG1";
$DatabaseName = "elib_sfac";
$conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);
$qrStoreName = $conn->real_escape_string($qrStoreName);
$query = "SELECT qrStoreName FROM branch WHERE qrStoreName = '$qrStoreName'";
$result = mysqli_query($conn, $query);
    //get week
    //get qr store id
    // get address
    //syntax = SELECT DISTINCT (SUBSTRING(address,1, INSTR(address, "-")-2)), count(address) from `web_checkin` where qrStoreName = 'D' and weeknumber = 9 group by address
   $HostName = "localhost";

//Define your database username here.
$HostUser = "root";

//Define your database password here.
$HostPass = "";

//Define your database name here.
$DatabaseName = "elib_sfac";

$conn = mysqli_connect($HostName,$HostUser,$HostPass, $DatabaseName);
if(!$conn){
 die('Could not Connect My Sql:' .mysql_error());
}
    $date = date("d-M-Y", strtotime($_date));
    $month = date("M", strtotime($date));
    $year = date("Y", strtotime($date));
    $weekNo = date("W", strtotime($date));
    $endofmonth = date("t", strtotime($date));
    $pastvisitor = array();
    $currentvisitor = array();
    $returnee = array();
    $sql = "SELECT location, sum(quantity) as count
     from (SELECT DISTINCT (section) as location, 
     count(section) as quantity 
     from `web_checkin` 
     where  weeknumber = $weekNo 
     group by section)a
group by location";
     $loc = array();
    $result = $conn->query($sql);
    
    if (!empty($result->num_rows)) {
    
        while ($row = $result->fetch_assoc()) {
            array_push($loc,array($row["location"],$row["count"]));
            
            
        }
    } else {
    array_push($loc,array('No available data for this week',1));
    }
    $conn->close();
   
    return $loc;

}
function getFootTraffic($_date) {
 $date = Date("m/d/y");
$month = Date("M");
$Day = Date("d");
$year = Date("Y");
$timezoneTime = date("h a");
$branchName;
$location;
$qrStoreName = "D";

$HostName = "localhost";
$HostUser = "root"; //"kurtsevi_onetapph";
$HostPass = ""; //"hm9QLPizBWn1#4wZt6KG1";
$DatabaseName = "elib_sfac";
$conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);
$qrStoreName = $conn->real_escape_string($qrStoreName);
$query = "SELECT qrStoreName FROM branch WHERE qrStoreName = '$qrStoreName'";
$result = mysqli_query($conn, $query);
$HostName = "localhost";

//Define your database username here.
$HostUser = "root";

//Define your database password here.
$HostPass = "";

//Define your database name here.
$DatabaseName = "elib_sfac";

$conn = mysqli_connect($HostName,$HostUser,$HostPass, $DatabaseName);
if(!$conn){
 die('Could not Connect My Sql:' .mysql_error());
}
    $date = date("d-M-Y", strtotime($_date));
    $month = date("M", strtotime($date));
    $day = date("d", strtotime($_date));
    $year = date("Y", strtotime($date));
    $weekNo = date("W", strtotime($date));
    $endofmonth = date("t", strtotime($date));
    $weekDay = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
    $weekdata = array();
    $hourdata = array();
    foreach($weekDay as $Days){
        $sql = "Select sum(traffic) as traffic 
        from(SELECT count(*) as traffic
        from `web_checkin` 
        where weeknumber = $weekNo 
        and weekDay = '". $Days ."')a
        ";

        $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($weekdata,array($row["traffic"],$Days));
            
            
        }
    } else {
    }
        }
    for($x = 0; $x <= 24;$x++){
        $sql = "Select sum(traffic) as traffic 
        from (SELECT count(*) as traffic
        from `web_checkin` 
        where weeknumber = $weekNo
        and Day = $day
        and Time = '". $x ."')a
        ";

        $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($hourdata,array($row["traffic"],$x));
            
            
        }
    } else {
    }
        }
         
         $conn->close();
         
        
         $data = array();
         array_push($data,array($weekdata, $hourdata));
         return $data;
    
    //check if company has branch
    //if 0 then show “No data available”
    //if 1 then get the whole week check in
    // shows each total
    
}

function getIndividualLoc($_date){
 $date = Date("m/d/y");
$month = Date("M");
$Day = Date("d");
$year = Date("Y");
$timezoneTime = date("h a");
$branchName;
$location;
$qrStoreName = "D";

$HostName = "localhost";
$HostUser = "root"; //"kurtsevi_onetapph";
$HostPass = ""; //"hm9QLPizBWn1#4wZt6KG1";
$DatabaseName = "elib_sfac";
$conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);
$qrStoreName = $conn->real_escape_string($qrStoreName);
$query = "SELECT qrStoreName FROM branch WHERE qrStoreName = '$qrStoreName'";
$result = mysqli_query($conn, $query);
 $date = date("d-M-Y", strtotime($_date));
    $month = date("M", strtotime($date));
    $day = date("d", strtotime($_date));
    $year = date("Y", strtotime($date));
    $weekNo = date("W", strtotime($date));
    $endofmonth = date("t", strtotime($date));
     $HostName = "localhost";

//Define your database username here.
$HostUser = "root";

//Define your database password here.
$HostPass = "";

//Define your database name here.
$DatabaseName = "elib_sfac";

$conn = mysqli_connect($HostName,$HostUser,$HostPass, $DatabaseName);
if(!$conn){
 die('Could not Connect My Sql:' .mysql_error());
}
     $sql = "Select branchName, sum(visitor) as visitor
     from (
     SELECT branchName, 
     count(branchName) as visitor
     from `web_checkin` 
     where weeknumber = $weekNo
     and year = $year
     group by branchName
     UNION ALL
     SELECT branchName, 
     count(branchName) as visitor
     from `web_checkin` 
     where weeknumber = $weekNo
     and year = $year
     group by branchName)a group by branchname;
     ";
     $individualdata = array();
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($individualdata,array($row["branchName"],$row["visitor"]));
        }
    } else {
    array_push($individualdata,array("No Data Available",1));
    }
    $conn->close();
   
    return $individualdata;
}


function displayA($_data){
    $returnrate = $_data[0];
    $currentvisitor = $_data[1];
    $pastvisitor = $_data[2];
    $returnee = $_data[3];
     echo "
<?php
if(!defined('index_page')) {
    die('Direct access not permitted');
 }
?>
<div class='col-lg-3'>
<div class='card'>
<h5 class='card-header'>Return rate (Weekly)</h5>
<div class='card-body' style='min-height:500px'>
    <div id='chartC'>
    </div>
    <div class=description>
        

        <div id='second-div'>
            <div>
                <h1>$pastvisitor</h1>
                <p>Previous Visitor
            </div>
            <div id='secondary-desc'>
                <h1>$currentvisitor</h1>
                <p>Current Visitor</p>
            </div>
             <div id='secondary-desc'>
                <h1>$returnee</h1>
                <p>Returned Visitor</p>
            </div>
            
        </div>
        </div>
    </div>
    </div>
</div>


<script>
var options = {
    colors: ['rgb(113 2 2)'],
    series: [$returnrate],
    chart: {
        height: 340,
        type: 'radialBar',
        toolbar: {
            show: true
        }
    },
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 225,
            hollow: {
                margin: 0,
                size: '70%',
                background: '#fff',
                image: undefined,
                imageOffsetX: 0,
                imageOffsetY: 0,
                position: 'front',
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 0,
                    blur: 4,
                    opacity: 0.24
                }
            },
            track: {
                background: '#fff',
                strokeWidth: '67%',
                margin: 0, // margin is in pixels
                dropShadow: {
                    enabled: true,
                    top: -3,
                    left: 0,
                    blur: 4,
                    opacity: 0.35
                }
            },

            dataLabels: {
                show: true,
                name: {
                    offsetY: -10,
                    show: true,
                    color: '#888',
                    fontSize: '17px'
                },
                value: {
                    formatter: function(val) {
                        return parseInt(val);
                    },
                    color: '#111',
                    fontSize: '36px',
                    show: true,
                }
            }
        }
    },
    stroke: {
        lineCap: 'round'
    },
    labels: ['Percent'],
};

var chart = new ApexCharts(document.querySelector('#chartC'), options);
chart.render();
</script>     
     ";
            
     }
     
    
    function displayB($_data){
    $demographicData = $_data;
    $dataLength = count($demographicData);
    $title = "Demographic (Monthly)";
    $seriesData;
    $filler;
    $male =0;
    $female =0 ;
     $categories = " ";
    $firstpart = "
<div class='col-lg-6'>
<div class='card'>
<h5 class='card-header'>$title</h5>
<div class='card-body' style='min-height:500px'>
    <div id='chartA'>
    </div>

    <div class=description1>
        <div>
        </div>
        <div id='secondary-desc'>
        </div>
    </div>
    <div class='subtitle'>
        
       
    </div>
    </div>
    </div>
</div>


<script>
var options = {
    colors: ['rgb(113 2 2)', '#14b2d7'],
    dataLabels: {
        style: {
            colors: ['#fff']
        }
    },
    markers: {
        colors: ['#fff']
    },
    series: [{
        name: 'Male',
        data: [";
        
        $secpart ="]
    }, {
        name: 'Female',
        data: [";

       
        $thirdpart = "]
    }],
    chart: {
        type: 'bar',
        height: 320,
        width: 610,
        stacked: true,
        toolbar: {
            show: true
        },
        zoom: {
            enabled: true
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            borderRadius: 10
        },
    },
    xaxis: {
       categories: [";
       
          
           $fourthpart =  "],
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false
        }
    },
    legend: {
        position: 'bottom',
    },
    fill: {
        opacity: 1
    }
};

var chart = new ApexCharts(document.querySelector('#chartA'), options);
chart.render();
</script>
    ";
     //Str builder for categories
      for($x =0; $x < $dataLength; $x++){
       //filler avoids error for php to str direct conversion
       $filler = $demographicData[$x][0];
       if($x == 0){
       
       $categories = $categories . "'$filler'";
       }else{
       $categories = $categories . ",'$filler'";
       }
       }
       //String builder for Series (Combination of Male And Female)


       //String builder for Male
       for($x =0; $x < $dataLength; $x++){
       //filler avoids error for php to str direct conversion
       $filler = $demographicData[$x][1];
       if($x == 0){
       
       $male = $male + $filler;
       }else{
       $male = $male . ",'$filler'";
       }
       }
       //String builder for female
       for($x =0; $x < $dataLength; $x++){
       //filler avoids error for php to str direct conversion
       $filler = $demographicData[$x][2];
       if($x == 0){
       
       $female = $female + $filler;
       }else{
       $female = $female . ",'$filler'";
       }
       }

    /*first part is the chart with div 
    between first part and sec part : is male data
    between secpart and third part is : fem data
    between third data and fourth data is the categories data
    */
      echo $firstpart . $male . $secpart . $female . $thirdpart . $categories . $fourthpart;
     }
    function displayC($_data){
    $locationData = $_data;
    $dataLength =  count($locationData);
    $visitorcount =0;
     for($x =0; $x < $dataLength; $x++){
       $filler = $locationData[$x][1];
       $visitorcount = $visitorcount + $filler;
       }
     $firstpart = "<div class='col-lg-3 '>
     <div class='card'>
     <h5 class='card-header'> Visitor Section<h5>
<div class='card-body ' style='min-height:500px'>
    <div id='chartD'>
    </div>

    <div class=description>
       
        <div id='second-div'>
            <div>
                <h1>$dataLength</h1>
                <p>Location</p>
            </div>
            <div id='secondary-desc'>
                <h1>$visitorcount</h1>
                <p>Visitor</p>
            </div>
        </div>
        </div>
        </div>
    </div>
</div>

<script>
var options = {
    colors: ['#14b2d7', '#58d5f1', '#04759d'],
    series: [";

    //series data comes over here 

    //must return data looks like this 44, 55, 13, 43, 22
    $data = "";
    
       for($x =0; $x < $dataLength; $x++){
       //filler avoids error for php to str direct conversion
       $filler = $locationData[$x][1];
       if($x == 0){
       $data = $data . $filler;
       }else{
       $data = $data . ",$filler";
       }
       }

    //end of series data
    $secpart = "],
    chart: {
        height: 350,
        type: 'pie',
    },
    labels: [";
    //label data comes over here 

    //must return data looks like this  'Team A', 'Team B', 'Team C', 'Team D', 'Team E'
    $loc = "";
    
       for($x =0; $x < $dataLength; $x++){
       //filler avoids error for php to str direct conversion
       $filler = $locationData[$x][0];
       if($x == 0){
       $loc = $loc . "'$filler'";
       }else{
       $loc = $loc . ",'$filler'";
       }
       }
    //end of label data

    $thirdpart = "],
    legend: {
        position: 'bottom',
        offsetY: 1
    },
    responsive: [{
        breakpoint: 430,
        options: {
            chart: {
                width: 400
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

var chart = new ApexCharts(document.querySelector('#chartD'), options);
chart.render();
</script>";
          //first part - data series - 2nd part -- team series -- 3rd part  
          echo $firstpart . $data . $secpart .$loc. $thirdpart;
     ;}
    function displayD($_data){
    $ftrda = $_data[0][0];
   
    $ftrdalength = count($ftrda);
  $ftrdb = $_data[0][1];
  $ftrdblength = count($ftrdb);
  $ftrdadata = "";
  $ftrdacol = "";
  $ftrdbdata = "";
  $ftrdbcol = "";

    $firspar =  "

    
   
<div class='col-lg-12 '>
<div class='card'>
<h5 class='card-header'>Foot traffic</h5>
    <div class='card-body d-flex' style='min-height:500px'>
        <div class='col-lg-6'>
            <div  id='chartB'>
            </div>
            <div class=description1>
                <div>
                </div>
                <div id='secondary-desc'>
                </div>
            </div>
            <div class='subtitle'>
                <h3>FOOT TRAFFIC (DAYS OF THE WEEK)</h3>
              
            </div>
        </div>
        <div class='col-lg-6' >
            <div id='chartB1'>
            </div>
            <div class=description1>
                <div>
                </div>
                <div id='secondary-desc'>
                </div>
            </div>
            <div class='subtitle'>
                <h3>FOOT TRAFFIC (TIME OF THE DAY)</h3>
                 
            </div>
        </div>
    </div>
</div>
</div>
<script>
var optionsA = {
    colors: ['rgb(113 2 2)'],
    series: [{
        name: 'People',
        data: [";
        for($x =0; $x < $ftrdalength; $x++){
       $filler = $ftrda[$x][0];
       if($x == 0){
       $ftrdadata = $ftrdadata . "'$filler'";
       }else{
       $ftrdadata = $ftrdadata . ",'$filler'";
       }
       }
         $secpart = "]
    }],
    chart: {
        width: 609,
        type: 'line',
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight'
    },
    grid: {
        row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
        },
    },
    xaxis: {
        categories: [";

        for($x =0; $x < $ftrdalength; $x++){
       //filler avoids error for php to str direct conversion
      
       $filler = $ftrda[$x][1];
       if($x == 0){
       $ftrdacol = $ftrdacol . "'$filler'";
       }else{
       $ftrdacol = $ftrdacol . ",'$filler'";
       }
       }
        

        $thirdpart = "],
    }
};

var chartA = new ApexCharts(document.querySelector('#chartB'), optionsA);
chartA.render();
</script>

<script>
var optionsA1 = {
    colors: ['#14b2d7'],
    series: [{
        name: 'People',
        data: [";
        for($x =0; $x < $ftrdblength; $x++){
       $filler = $ftrdb[$x][0];
       if($x == 0){
       $ftrdbdata = $ftrdbdata . "'$filler'";
       }else{
       $ftrdbdata = $ftrdbdata . ",'$filler'";
       }
       }
        $fourtpart = "]
    }],
    chart: {
        width: 609,
        type: 'line',
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight'
    },
    grid: {
        row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
        },
    },
    xaxis: {
        categories: [";
         for($x =0; $x < $ftrdblength; $x++){
       //filler avoids error for php to str direct conversion
      
       $filler = $ftrdb[$x][1];
       if($x == 0){
       $ftrdbcol = $ftrdbcol . "'$filler'";
       }else{
       $ftrdbcol = $ftrdbcol . ",'$filler'";
       }
       }
        

        $fifthpart = "],
    }
};

var chartA = new ApexCharts(document.querySelector('#chartB1'), optionsA1);
chartA.render();
</script>
    ";
     echo $firspar . $ftrdadata . $secpart . $ftrdacol . $thirdpart . $ftrdbdata . $fourtpart . $ftrdbcol . $fifthpart;
     }
    function displayE($_data){
    $individualLocData = $_data;
    $ildLength = count($individualLocData);
    $ildData = ""; 
    $ildDataCount = 0;
    $ildColumn = "";
     for($x =0; $x < $ildLength; $x++){
       //filler avoids error for php to str direct conversion
      
       $filler = $individualLocData[$x][1];
       $ildDataCount = $ildDataCount + $filler ;
       if($x == 0){
       
       $ildData = $ildData . "'$filler'";
       }else{
       $ildData = $ildData . ",'$filler'";
     
       }
       }
     $firstpart = "<div class='dashboard_1 chartE'>

    <div id='chartE'>
    </div>
    <div class=description1>
        <div>
        </div>
        <div id='secondary-desc'>
        </div>
    </div>
    <div class='subtitle'>
        <h3>INDIVIDUAL  FOOT TRAFFIC</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt u.</p>
    </div>
</div>

<script>
var optionsE = {
    colors: ['rgb(113 2 2)'],
    series: [{
        data: ["; 
        $secpart = "]
    }],
    chart: {
        type: 'histogram',
        height: 320,
        width: 609,
        events: {
            dataPointSelection: function(e, chart, opts) {
                var arraySelected = []
                opts.selectedDataPoints.map(function(selectedIndex) {
                    return selectedIndex.map(function(s) {
                        return arraySelected.push(chart.w.globals.series[0][s])
                    })

                });
                arraySelected = arraySelected.reduce(function(acc, curr) {
                    return acc + curr;
                }, 0)

                document.querySelector('#selected-count').innerHTML = arraySelected
            }
        }
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: false

            }
        }
    },
    states: {
        active: {
            allowMultipleDataPointsSelection: true
        }
    },
    xaxis: {
        categories: [";
        
        $thirdpart = "],
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false
        }
    },
    yaxis: {
        tickAmount: 4,
        labels: {
            offsetX: -5,
            offsetY: -5,

        },
    },
    tooltip: {
        x: {
            format: 'dd MMM yyyy'
        },
    },
};

var chartE = new ApexCharts(document.querySelector('#chartE'), optionsE);
chartE.render();


chart.addEventListener('dataPointSelection', function(e, opts) {
    console.log(e, opts)
})
</script>";


        for($x =0; $x < $ildLength; $x++){
       //filler avoids error for php to str direct conversion
      
       $filler = $individualLocData[$x][0];
       if($x == 0){

       $ildColumn = $ildColumn . "'$filler'";
       }else{
       $ildColumn = $ildColumn . ",'$filler'";
       }
       }
echo $firstpart . $ildData . $secpart . $ildColumn . $thirdpart;
            
     ;}
    function displayF($_data){
    $cardUtilData = $_data;
    $cuDlength = count($cardUtilData);
    $cudData = "";
    $cudColumn = "";
    for($x =0; $x < $cuDlength; $x++){
       //filler avoids error for php to str direct conversion
      
       $filler = $cardUtilData[$x][0];
       if($x == 0){

       $cudData = $cudData . "'$filler'";
       }else{
       $cudData = $cudData . ",'$filler'";
       }
       }
       for($x =0; $x < $cuDlength; $x++){
       //filler avoids error for php to str direct conversion
      
       $filler = $cardUtilData[$x][1];
       if($x == 0){

       $cudColumn = $cudColumn . "'$filler'";
       }else{
       $cudColumn = $cudColumn . ",'$filler'";
       }
       }
    $firstpart = "
    <div class='dashboard_1 chartF'>
    <div id='chartF'>
    </div>
    <div class=description1>
        <div>
        </div>
        <div id='secondary-desc'>
        </div>
    </div>
    <div class='subtitle'>
        <h3>LOYALTY CARD UTILIZATION</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt u.</p>
    </div>
</div>

<script>
var optionsF = {
    colors: ['rgb(113 2 2)', '#14b2d7'],
    series: [{
            name: 'Card Utilization',
            data: [";
           
            $secpart = "]
        }
    ],
    chart: {
        height: 320,
        width: 609,
        type: 'line',
        zoom: {
            enabled: false
        },
    },
    dataLabels: {
        enabled: false

    },
    stroke: {
        curve: 'straight',
    },
    legend: {
        tooltipHoverFormatter: function(val, opts) {
            return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
        }
    },
    markers: {
        size: 0,
        hover: {
            sizeOffset: 6
        }
    },
    xaxis: {
        categories: [";
        $thirdpart = "]
    },
    tooltip: {
        y: [{
                title: {
                    formatter: function(val) {
                        return val + ' (mins)'
                    }
                }
            },
            {
                title: {
                    formatter: function(val) {
                        return val + ' per session'
                    }
                }
            },
            {
                title: {
                    formatter: function(val) {
                        return val;
                    }
                }
            }
        ]
    },
    grid: {
        borderColor: '#f1f1f1',
    }
};

var chartF = new ApexCharts(document.querySelector('#chartF'), optionsF);
chartF.render();
</script>";
    echo $firstpart . $cudData . $secpart . $cudColumn . $thirdpart;
     }
    
}
