@extends("back.common.master")
@section("page_name") {{__("common.issued_book_list")}} @endsection
@section("content")

        @livewire("notification")

@endsection
@section("css_loc")
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <style>


.user-account {
	float: right;
	width: 110px;
	border-left: 1px solid #dd3e2b;
	border-right: 1px solid #dd3e2b;
	box-sizing: border-box;
	position: relative
}

.user-info {
	float: left;
	width: 100%;
	padding: 13px 10px;
	position: relative
}

.user-info img {
	margin-right: 10px;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px
}

.user-info a {
	color: #fff;
	font-size: 14px;
	float: left;
	margin-top: 8px
}

.user-info a:hover {
	color: #fff
}

.user-info>i {
	position: absolute;
	top: 51%;
	right: 10px;
	color: #fff;
	font-size: 12px;
	-webkit-transform: translateY(-50%);
	-moz-transform: translateY(-50%);
	-ms-transform: translateY(-50%);
	-o-transform: translateY(-50%);
	transform: translateY(-50%)
}

.user-profile {
	float: left;
	width: 100%
}

.cp-sec {
	float: left;
	width: 100%;
	margin-top: 5px;
	padding: 0 13px
}

.cp-sec>img {
	float: left;
	margin-top: 3px
}

.cp-sec p {
	float: right;
	color: #b2b2b2;
	font-size: 14px;
	font-weight: 500
}

.cp-sec p img {
	float: none;
	display: inline-block;
	position: relative;
	top: 3px;
	padding-right: 5px
}

.comment-sec {
	float: left;
	width: 100%
}

.comment-sec ul {
	float: left;
	width: 100%
}

.comment-sec ul li {
	float: left;
	width: 100%
}

.comment-sec ul ul {
	padding-left: 50px
}

.comment-list {
	display: table;
	padding-bottom: 30px
}

.comment {
	display: table-cell;
	vertical-align: top;
	width: 100%;
	padding-left: 10px
}

.comment h3 {
	color: #000;
	font-size: 16px;
	font-weight: 600;
	margin-bottom: 10px
}

.comment img {
	position: relative;
	top: 2px;
	margin-right: 5px
}

.comment span {
	color: #b2b2b2;
	font-size: 14px;
	display: block;
	margin-bottom: 14px
}

.comment p {
	color: #686868;
	font-size: 14px;
	margin-bottom: 10px;
	line-height: 20px
}

.comment>a {
	display: inline-block;
	color: #b2b2b2;
	font-size: 14px;
	font-weight: 600
}

.comment>a.active,
.comment>a:hover {
	color: #e44d3a
}

.comment>a i {
	font-weight: 600;
	margin-right: 6px
}

::-webkit-input-placeholder {
	color: #b2b2b2
}

::-moz-placeholder {
	color: #b2b2b2
}

:-ms-input-placeholder {
	color: #b2b2b2
}

:-moz-placeholder {
	color: #b2b2b2
}

.fgt-sec {
	float: left
}

.fgt-sec input[type=checkbox] {
	display: none
}

.fgt-sec label {
	float: left
}

.fgt-sec input[type=checkbox]+label span {
	display: inline-block;
	width: 15px;
	height: 15px;
	position: relative;
	border: 1px solid #e7e7e7;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px
}

.fgt-sec input[type=checkbox]+label span:before {
	content: '';
	width: 7px;
	height: 7px;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px;
	font-size: 8px;
	color: #fff;
	opacity: 0;
	visibility: hidden;
	background-color: #e44d3a;
	position: absolute;
	font-family: fontawesome;
	top: 50%;
	left: 50%;
	-webkit-transform: translateX(-50%) translateY(-50%);
	-moz-transform: translateX(-50%) translateY(-50%);
	-ms-transform: translateX(-50%) translateY(-50%);
	-o-transform: translateX(-50%) translateY(-50%);
	transform: translateX(-50%) translateY(-50%)
}

.fgt-sec input[type=checkbox]:checked+label span:before {
	opacity: 1;
	visibility: visible
}

.fgt-sec small {
	float: left;
	color: #000;
	font-size: 14px;
	font-weight: 600;
	margin-left: 10px;
	font-weight: 700
}

.fgt-sec input[type=radio] {
	display: none
}

.fgt-sec label {
	float: left
}

.fgt-sec input[type=radio]+label span {
	display: inline-block;
	width: 15px;
	height: 15px;
	position: relative;
	border: 1px solid #e7e7e7;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px
}

.fgt-sec input[type=radio]+label span:before {
	content: '';
	width: 7px;
	height: 7px;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px;
	font-size: 8px;
	color: #fff;
	opacity: 0;
	visibility: hidden;
	background-color: #e44d3a;
	position: absolute;
	font-family: fontawesome;
	top: 49%;
	left: 49%;
	-webkit-transform: translateX(-50%) translateY(-50%);
	-moz-transform: translateX(-50%) translateY(-50%);
	-ms-transform: translateX(-50%) translateY(-50%);
	-o-transform: translateX(-50%) translateY(-50%);
	transform: translateX(-50%) translateY(-50%)
}

.fgt-sec input[type=radio]:checked+label span:before {
	opacity: 1;
	visibility: visible
}

.user_profile {
	float: left;
	width: 100%;
	background-color: #fff;
	margin-bottom: 20px;
	text-align: center;
	margin-top: -40px
}

.user-pro-img {
	float: left;
	width: 100%;
	text-align: center;
	margin-bottom: 28px;
	margin-top: -95px;
	position: relative
}

.user-pro-img>a {
	width: 40px;
	height: 40px;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px;
	color: #fff;
	line-height: 40px;
	background-color: #e44d3a;
	position: absolute;
	top: 0;
	left: 60%
}

.user-pro-img img {
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px;
	float: none;
	border: 5px solid #fff
}

.user_pro_status {
	float: left;
	width: 100%;
	border-bottom: 1px solid #e5e5e5;
	padding-bottom: 27px
}

.user-tab-sec {
	float: left;
	width: 100%;
	padding-top: 4px
}

.user-tab-sec h3 {
	color: #000;
	font-size: 40px;
	font-weight: 400;
	text-transform: capitalize;
	margin-bottom: 7px
}

.message-btn {
	float: right;
	margin-top: 20px;
	margin-bottom: 30px
}

.message-btn a {
	display: inline-block;
	color: #fff;
	font-size: 16px;
	background-color: #e44d3a;
	padding: 12px
}

.message-btn a:hover {
	color: #fff
}

.message-btn a i {
	padding-right: 5px
}

.row {
	margin: 0
}

.save {
	background-color: #e44d3a;
	color: #fff;
	border-color: transparent
}

a:hover {
	color: initial
}

.chat-list {
	float: left;
	width: 100%;
	min-height: 390px
}

.active-status {
	width: 9px;
	height: 9px;
	border: 2px solid #ecf5fb;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px;
	position: absolute;
	top: -3px;
	right: 0
}

.status-info {
	width: 8px;
	height: 8px;
	background-color: #fff;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px;
	display: inline-block;
	margin-left: 7px
}

.chat-user-info h3 {
	margin-top: 7px;
	margin-left: 10px
}

.acc-setting {
	float: left;
	width: 100%;
	background-color: #fff;
	border-left: 1px solid #e5e5e5;
	border-bottom: 1px solid #e5e5e5;
	border-right: 1px solid #e5e5e5;
	-webkit-box-shadow: 1px 0 4px rgba(0, 0, 0, .24);
	-moz-box-shadow: 1px 0 4px rgba(0, 0, 0, .24);
	-ms-box-shadow: 1px 0 4px rgba(0, 0, 0, .24);
	-o-box-shadow: 1px 0 4px rgba(0, 0, 0, .24);
	box-shadow: 1px 0 4px rgba(0, 0, 0, .24)
}

.acc-setting form {
	float: left;
	width: 100%
}

.acc-setting>h3 {
	float: left;
	width: 100%;
	color: #000;
	font-weight: 600;
	font-size: 18px;
	text-transform: capitalize;
	border-bottom: 1px solid #e5e5e5;
	padding: 17px 20px
}

.notbar {
	float: left;
	width: 100%;
	border-bottom: 1px solid #e5e5e5;

	position: relative
}

.notbar h4 {
	color: #000;
	font-size: 16px;
	font-weight: 600;
	margin-bottom: 5px
}

.notbar p {
	color: #686868;
	font-size: 14px;
	line-height: 24px;
	width: 75%
}

.toggle-btn {
	position: absolute;
	top: 35px;
	right: 20px
}

.save-stngs {
	float: left;
	width: 100%;
	padding: 30px 20px 50px 20px
}

.save-stngs.pd2 {
	padding: 25px 20px 42px 20px
}

.save-stngs.pd3 {
	padding: 25px 20px 25px 20px
}

.save-stngs ul li {
	display: inline-block;
	margin-right: 17px
}

.save-stngs ul li button {
	display: inline-block;
	color: #000;
	font-size: 16px;
	border: 1px solid #e5e5e5;
	height: 40px;
	line-height: 40px;
	padding: 0 22px;
	font-weight: 600;
	background: 0 0;
	cursor: pointer
}

.save-stngs ul li button:hover {
	background-color: #e44d3a;
	color: #fff;
	border-color: transparent
}

.cp-field {
	float: left;
	width: 100%;
	margin-top: 29.4px;
	padding: 0 20px
}

.cp-field h5 {
	color: #000;
	font-size: 16px;
	font-weight: 600;
	float: left;
	width: 100%;
	margin-bottom: 10px
}

.cp-field h5 a {
	color: #000
}

.cpp-fiel {
	float: left;
	width: 100%;
	position: relative
}

.cp-field input {
	height: 40px;
	padding: 0 40px
}

.cp-field input,
.cp-field textarea {
	width: 100%;
	border: 1px solid #e5e5e5
}

.cp-field textarea {
	padding: 20px;
	height: 115px
}

.cpp-fiel i {
	position: absolute;
	top: 12px;
	left: 15px;
	color: #b2b2b2;
	font-size: 16px
}

.cp-field>p {
	float: left;
	width: 100%;
	color: #686868;
	font-size: 14px;
	line-height: 24px;
	margin-top: 5px
}

.notifications-list {
	float: left;
	width: 100%
}

.notfication-details {
	float: left;
	width: 100%;
	padding: 20px;
	border-bottom: 1px solid #e5e5e5
}

.notfication-details:last-child {
	border-bottom: 0
}

.noty-user-img {
	float: left;
	width: 35px
}

.noty-user-img img {
	width: 100%
}

.notification-info {
	float: left;
	width: auto;
	padding-left: 10px
}

.notification-info h3 {
	color: #686868;
	font-size: 14px;
	font-weight: 600;
	border: 0;
	padding: 0;
	margin-bottom: 6px
}

.notification-info h3 a {
	color: #000;
	font-size: 16px;
	display: inline-block
}

.notification-info>span {
	display: inline-block;
	color: #b2b2b2;
	font-size: 12px;
	font-weight: 600
}

.requests-list {
	float: left;
	width: 100%;
	padding-bottom: 0
}

.request-details {
	float: left;
	width: 100%;
	padding: 20px;
	border-bottom: 1px solid #e5e5e5
}

.request-details:last-child {
	border-bottom: 0
}

.request-info {
	float: left;
	padding-left: 10px
}

.request-info h3 {
	color: #000;
	font-size: 14px;
	font-weight: 600;
	padding: 0;
	border: 0;
	margin-bottom: 3px
}

.request-info span {
	color: #686868;
	font-size: 12px;
	display: inline-block
}

.accept-feat {
	float: right
}

.accept-feat ul li {
	display: inline-block
}

.accept-feat ul li button {
	cursor: pointer
}

.accept-req {
	color: #fff;
	font-size: 16px;
	background-color: #51a5fb;
	height: 30px;
	padding: 0 20px;
	font-weight: 600;
	border: 0;
	border: 1px solid #51a5fb
}

.close-req {
	height: 30px;
	width: 30px;
	text-align: center;
	line-height: 30px;
	border: 1px solid #e5e5e5;
	background: inherit;
	color: #b2b2b2;
	margin-left: 7px
}

.close-req i {
	font-weight: 600
}

.profile-bx-details {
	float: left;
	width: 100%;
	padding: 30px 7px 30px 7px
}

.profile-bx-details .row .col-lg-3 {
	padding: 0 7px
}

.profile-bx-info {
	float: left;
	width: 100%;
	background-color: #f2f2f2;
	padding: 20px;
	border: 1px solid #e5e5e5
}

.pro-bx {
	float: left;
	width: 100%;
	border-bottom: 1px solid #e5e5e5;
	padding-bottom: 10px
}

.bx-info {
	float: left;
	margin-top: 7px;
	padding-left: 15px
}

.bx-info h3 {
	color: #e44d3a;
	font-size: 20px;
	font-weight: 600;
	margin-bottom: 5px
}

.bx-info h5 {
	color: #000;
	font-size: 14px;
	font-weight: 600;
	margin: 0;
	padding: 0;
	border: 0
}

.profile-bx-info>p {
	float: left;
	width: 100%;
	font-size: 12px;
	line-height: 22px;
	padding-top: 3px
}

.pro-work-status {
	float: left;
	width: 100%;
	padding: 0 15px
}

.pro-work-status h4 {
	color: #000;
	font-size: 18px;
	font-weight: 600;
	margin-bottom: 50px
}

.img-bx {
	background-color: #efefef;
	padding: 20px
}

@-webkit-keyframes sk-bouncedelay {
	0%,
	100%,
	80% {
		-webkit-transform: scale(0)
	}
	40% {
		-webkit-transform: scale(1)
	}
}

@keyframes sk-bouncedelay {
	0%,
	100%,
	80% {
		-webkit-transform: scale(0);
		transform: scale(0)
	}
	40% {
		-webkit-transform: scale(1);
		transform: scale(1)
	}
}
    </style>
@endsection
@section("js_loc")
    <script src="{{asset('js/book_issued.js')}}"></script>
@endsection
