@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name") {{__("common.dashboard")}} @endsection


@section("content")
@livewire('dashboard',['sdate' => $sdate])
<style>
@charset "utf-8";
@import url("https://fonts.googleapis.com/css2?family=Poppins&family=Roboto&family=Ubuntu&display=swap");

/* CSS Document */

@media (min-width: 1200px)
.container, .container-lg, .container-md, .container-sm, .container-xl {
    max-width: 1400px;
}
/* --- Dashboard Div Start ---*/
.dashboard {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.dashboard-conatiner {
    width: 80%;
    display: inline-flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
}

.dashboard_1 {
    background-color: rgb(255, 255, 255);
    margin: 15px;
    box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
    padding: 20px 2px;e
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* --- Dashboard Div End ---*/

/* --- Charts Start ---*/
#chartD {
    display: inline-flex;
    align-items: center;
}
/* --- Charts Ends ---*/

/* --- Text Designs Start ---*/
.onetapText {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    letter-spacing: 2px;
}

.blankbg {
    background-color: white;
}
/* --- Text Designs End ---*/

.chartA {
    width: 657px;
    height: 520px;
}

.chartB {
    width: 1287px;
}

.chartC {
    width: 282px;
    height: 520px;
}

.chartD {
    width: 282px;
    height: 520px;
}

.chartE {
    width: 627px;
    height: 520px;
}

.chartF {
    width: 627px;
    height: 520px;
}

/* Description Start*/
.description {
    color: #e5e4e4/* Old #f4d03f */
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

    .description #second-div {
        margin: 20px;
        display: flex;
        width: 100%;
        justify-content: space-evenly;
        flex-direction: row;
    }

        .description #second-div div {
            flex-direction: row;
        }

    .description div {
        font-family: "Ubuntu", sans-serif;
        text-align: center;
    }

    .description h1 {
        font-family: "Roboto", sans-serif;
        font-weight: 1000;
        line-height: 15px;
    }

    .description h3 {
        font-family: "Roboto", sans-serif;
        color: #e5e4e4/* Old #f4d03f */;
    }

    .description #secondary-desc {
        color: #04759d;
    }
/* Description End*/

/* Description1 Start*/
.description1 {
    font-family: "Roboto", sans-serif;
    width: 100%;
    display: flex;
    justify-content: space-evenly;
}

    .description1 div {
        text-align: center;
        display: flex;
        color: #033c67;
        font-size: 1.2rem;
    }

        .description1 div span {
            margin: 5px;
        }

    .description1 #highlight {
        font-weight: 1000;
        color: #04759d;
    }

/* Description1 End*/
.subtitle {
    font-family: "Ubuntu", sans-serif;
    font-size: 1.4vh;
    display: flex;
    justify-content: center;
    flex-direction: column;
    width: 609px;
}

    .subtitle h3 {
        color: rgb(113 2 2);
        font-weight: 400;
    }

.chartB-continaer {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

</style>

               
@endsection
@section("js_loc")
<script src="{{asset('front/js/slick.min.js')}}"></script>
<script src="{{asset('front/js/jquery.magnific-popup.min.js')}}"></script>

<script src="{{asset('front/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('front/js/isotope.pkgd.min.js')}}"></script>

@endsection
