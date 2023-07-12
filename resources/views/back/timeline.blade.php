@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name") {{__("common.dashboard")}} @endsection
@section("content")


    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    @include("back.common.spinner")
   @livewire("timeline")
@endsection
@section("css_loc")
    <style>
        svg:not(:root) {
	overflow: hidden;
}

select {
	margin: 0;
	font-family: inherit;
	font-size: inherit;
	line-height: inherit;
}

select {
	text-transform: none;
}

::-webkit-file-upload-button {
	font: inherit;
	-webkit-appearance: button;
}

@media print {
	*,
	*::before,
	*::after {
		text-shadow: none !important;
		box-shadow: none !important;
	}
	img {
		page-break-inside: avoid;
	}
	p,
	h3 {
		orphans: 3;
		widows: 3;
	}
	h3 {
		page-break-after: avoid;
	}
	@page {
		size: a3;
	}
	body {
		min-width: 992px !important;
	}
}

*,
*::before,
*::after {
	box-sizing: border-box;
}

@-ms-viewport {
	width: device-width;
}

img {
	vertical-align: middle;
	border-style: none;
}

h3 {
	margin-bottom: 0.5rem;
	font-family: inherit;
	font-weight: 400;
	line-height: 1.2;
	color: inherit;
}

h3 {
	font-size: 1.75rem;
}

.container-fluid {
	width: 100%;
	padding-right: 15px;
	padding-left: 15px;
	margin-right: auto;
	margin-left: auto;
}

.col-lg-3,
.col-lg-6 {
	position: relative;
	width: 100%;
	min-height: 1px;
	padding-right: 15px;
	padding-left: 15px;
}

@media (min-width: 992px) {
	.col-lg-3 {
		flex: 0 0 25%;
		max-width: 25%;
	}
	.col-lg-6 {
		flex: 0 0 50%;
		max-width: 50%;
	}
}

.btn:not(:disabled):not(.disabled) {
	cursor: pointer;
}

.btn:not(:disabled):not(.disabled):active,
.btn:not(:disabled):not(.disabled).active {
	background-image: none;
	box-shadow: none;
}

.btn:not(:disabled):not(.disabled):active:focus,
.btn:not(:disabled):not(.disabled).active:focus {
	box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25), none;
}

.btn-primary:not(:disabled):not(.disabled):active,
.btn-primary:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #0c7cd5;
	border-color: #0b75c9;
}

.btn-primary:not(:disabled):not(.disabled):active:focus,
.btn-primary:not(:disabled):not(.disabled).active:focus {
	box-shadow: none, 0 0 0 0.2rem rgba(33, 150, 243, 0.5);
}

.btn-secondary:not(:disabled):not(.disabled):active,
.btn-secondary:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #545b62;
	border-color: #4e555b;
}

.btn-secondary:not(:disabled):not(.disabled):active:focus,
.btn-secondary:not(:disabled):not(.disabled).active:focus {
	box-shadow: none, 0 0 0 0.2rem rgba(108, 117, 125, 0.5);
}

.btn-success:not(:disabled):not(.disabled):active,
.btn-success:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #3d8b40;
	border-color: #39833c;
}

.btn-success:not(:disabled):not(.disabled):active:focus,
.btn-success:not(:disabled):not(.disabled).active:focus {
	box-shadow: none, 0 0 0 0.2rem rgba(76, 175, 80, 0.5);
}

.btn-info:not(:disabled):not(.disabled):active,
.btn-info:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #008fa1;
	border-color: #008394;
}

.btn-info:not(:disabled):not(.disabled):active:focus,
.btn-info:not(:disabled):not(.disabled).active:focus {
	box-shadow: none, 0 0 0 0.2rem rgba(0, 188, 212, 0.5);
}

.btn-warning:not(:disabled):not(.disabled):active,
.btn-warning:not(:disabled):not(.disabled).active {
	color: #212529;
	background-color: #ffe608;
	border-color: #fae100;
}

.btn-warning:not(:disabled):not(.disabled):active:focus,
.btn-warning:not(:disabled):not(.disabled).active:focus {
	box-shadow: none, 0 0 0 0.2rem rgba(255, 235, 59, 0.5);
}

.btn-danger:not(:disabled):not(.disabled):active,
.btn-danger:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #ea1c0d;
	border-color: #de1b0c;
}

.btn-danger:not(:disabled):not(.disabled):active:focus,
.btn-danger:not(:disabled):not(.disabled).active:focus {
	box-shadow: none, 0 0 0 0.2rem rgba(244, 67, 54, 0.5);
}

.btn-light:not(:disabled):not(.disabled):active,
.btn-light:not(:disabled):not(.disabled).active {
	color: #212529;
	background-color: #dae0e5;
	border-color: #d3d9df;
}

.btn-light:not(:disabled):not(.disabled):active:focus,
.btn-light:not(:disabled):not(.disabled).active:focus {
	box-shadow: none, 0 0 0 0.2rem rgba(248, 249, 250, 0.5);
}

.btn-dark:not(:disabled):not(.disabled):active,
.btn-dark:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #1d2124;
	border-color: #171a1d;
}

.btn-dark:not(:disabled):not(.disabled):active:focus,
.btn-dark:not(:disabled):not(.disabled).active:focus {
	box-shadow: none, 0 0 0 0.2rem rgba(52, 58, 64, 0.5);
}

.btn-outline-primary:not(:disabled):not(.disabled):active,
.btn-outline-primary:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #2196f3;
	border-color: #2196f3;
}

.btn-outline-primary:not(:disabled):not(.disabled):active:focus,
.btn-outline-primary:not(:disabled):not(.disabled).active:focus {
	box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.5);
}

.btn-outline-secondary:not(:disabled):not(.disabled):active,
.btn-outline-secondary:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #6c757d;
	border-color: #6c757d;
}

.btn-outline-secondary:not(:disabled):not(.disabled):active:focus,
.btn-outline-secondary:not(:disabled):not(.disabled).active:focus {
	box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.5);
}

.btn-outline-success:not(:disabled):not(.disabled):active,
.btn-outline-success:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #4caf50;
	border-color: #4caf50;
}

.btn-outline-success:not(:disabled):not(.disabled):active:focus,
.btn-outline-success:not(:disabled):not(.disabled).active:focus {
	box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.5);
}

.btn-outline-info:not(:disabled):not(.disabled):active,
.btn-outline-info:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #00bcd4;
	border-color: #00bcd4;
}

.btn-outline-info:not(:disabled):not(.disabled):active:focus,
.btn-outline-info:not(:disabled):not(.disabled).active:focus {
	box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.5);
}

.btn-outline-warning:not(:disabled):not(.disabled):active,
.btn-outline-warning:not(:disabled):not(.disabled).active {
	color: #212529;
	background-color: #ffeb3b;
	border-color: #ffeb3b;
}

.btn-outline-warning:not(:disabled):not(.disabled):active:focus,
.btn-outline-warning:not(:disabled):not(.disabled).active:focus {
	box-shadow: 0 0 0 0.2rem rgba(255, 235, 59, 0.5);
}

.btn-outline-danger:not(:disabled):not(.disabled):active,
.btn-outline-danger:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #f44336;
	border-color: #f44336;
}

.btn-outline-danger:not(:disabled):not(.disabled):active:focus,
.btn-outline-danger:not(:disabled):not(.disabled).active:focus {
	box-shadow: 0 0 0 0.2rem rgba(244, 67, 54, 0.5);
}

.btn-outline-light:not(:disabled):not(.disabled):active,
.btn-outline-light:not(:disabled):not(.disabled).active {
	color: #212529;
	background-color: #f8f9fa;
	border-color: #f8f9fa;
}

.btn-outline-light:not(:disabled):not(.disabled):active:focus,
.btn-outline-light:not(:disabled):not(.disabled).active:focus {
	box-shadow: 0 0 0 0.2rem rgba(248, 249, 250, 0.5);
}

.btn-outline-dark:not(:disabled):not(.disabled):active,
.btn-outline-dark:not(:disabled):not(.disabled).active {
	color: #ffffff;
	background-color: #343a40;
	border-color: #343a40;
}

.btn-outline-dark:not(:disabled):not(.disabled):active:focus,
.btn-outline-dark:not(:disabled):not(.disabled).active:focus {
	box-shadow: 0 0 0 0.2rem rgba(52, 58, 64, 0.5);
}

.navbar-toggler:not(:disabled):not(.disabled) {
	cursor: pointer;
}

.page-link:not(:disabled):not(.disabled) {
	cursor: pointer;
}

.close:not(:disabled):not(.disabled) {
	cursor: pointer;
}

@supports (transform-style: preserve-3d) {}

.d-flex {
	display: flex !important;
}

.justify-content-center {
	justify-content: center !important;
}

@supports (position: sticky) {}

.p-4 {
	padding: 1.5rem !important;
}

.py-4 {
	padding-top: 1.5rem !important;
}

.py-4 {
	padding-bottom: 1.5rem !important;
}

.form-check .form-check-input:not(:checked)+.form-check-sign:before {
	animation: rippleOff 500ms;
}

.form-check .form-check-input:not(:checked)+.form-check-sign .check:after {
	animation: rippleOff 500ms;
}

@keyframes rippleOff {
	0% {
		opacity: 0;
	}
	50% {
		opacity: 0.2;
	}
	100% {
		opacity: 0;
	}
}

form {
	margin-bottom: 1.125rem;
}

.radio label label:has(input[type=radio][disabled]),
.radio label label:has(input[type=radio][disabled]):hover,
.radio label label:has(input[type=radio][disabled]):focus,
.radio label label:has(input[type=checkbox][disabled]),
.radio label label:has(input[type=checkbox][disabled]):hover,
.radio label label:has(input[type=checkbox][disabled]):focus,
.is-focused .radio label label:has(input[type=radio][disabled]),
.is-focused .radio label label:has(input[type=radio][disabled]):hover,
.is-focused .radio label label:has(input[type=radio][disabled]):focus,
.is-focused .radio label label:has(input[type=checkbox][disabled]),
.is-focused .radio label label:has(input[type=checkbox][disabled]):hover,
.is-focused .radio label label:has(input[type=checkbox][disabled]):focus,
.radio-inline label:has(input[type=radio][disabled]),
.radio-inline label:has(input[type=radio][disabled]):hover,
.radio-inline label:has(input[type=radio][disabled]):focus,
.radio-inline label:has(input[type=checkbox][disabled]),
.radio-inline label:has(input[type=checkbox][disabled]):hover,
.radio-inline label:has(input[type=checkbox][disabled]):focus,
.is-focused .radio-inline label:has(input[type=radio][disabled]),
.is-focused .radio-inline label:has(input[type=radio][disabled]):hover,
.is-focused .radio-inline label:has(input[type=radio][disabled]):focus,
.is-focused .radio-inline label:has(input[type=checkbox][disabled]),
.is-focused .radio-inline label:has(input[type=checkbox][disabled]):hover,
.is-focused .radio-inline label:has(input[type=checkbox][disabled]):focus,
.checkbox label label:has(input[type=radio][disabled]),
.checkbox label label:has(input[type=radio][disabled]):hover,
.checkbox label label:has(input[type=radio][disabled]):focus,
.checkbox label label:has(input[type=checkbox][disabled]),
.checkbox label label:has(input[type=checkbox][disabled]):hover,
.checkbox label label:has(input[type=checkbox][disabled]):focus,
.is-focused .checkbox label label:has(input[type=radio][disabled]),
.is-focused .checkbox label label:has(input[type=radio][disabled]):hover,
.is-focused .checkbox label label:has(input[type=radio][disabled]):focus,
.is-focused .checkbox label label:has(input[type=checkbox][disabled]),
.is-focused .checkbox label label:has(input[type=checkbox][disabled]):hover,
.is-focused .checkbox label label:has(input[type=checkbox][disabled]):focus,
.checkbox-inline label:has(input[type=radio][disabled]),
.checkbox-inline label:has(input[type=radio][disabled]):hover,
.checkbox-inline label:has(input[type=radio][disabled]):focus,
.checkbox-inline label:has(input[type=checkbox][disabled]),
.checkbox-inline label:has(input[type=checkbox][disabled]):hover,
.checkbox-inline label:has(input[type=checkbox][disabled]):focus,
.is-focused .checkbox-inline label:has(input[type=radio][disabled]),
.is-focused .checkbox-inline label:has(input[type=radio][disabled]):hover,
.is-focused .checkbox-inline label:has(input[type=radio][disabled]):focus,
.is-focused .checkbox-inline label:has(input[type=checkbox][disabled]),
.is-focused .checkbox-inline label:has(input[type=checkbox][disabled]):hover,
.is-focused .checkbox-inline label:has(input[type=checkbox][disabled]):focus,
.switch label label:has(input[type=radio][disabled]),
.switch label label:has(input[type=radio][disabled]):hover,
.switch label label:has(input[type=radio][disabled]):focus,
.switch label label:has(input[type=checkbox][disabled]),
.switch label label:has(input[type=checkbox][disabled]):hover,
.switch label label:has(input[type=checkbox][disabled]):focus,
.is-focused .switch label label:has(input[type=radio][disabled]),
.is-focused .switch label label:has(input[type=radio][disabled]):hover,
.is-focused .switch label label:has(input[type=radio][disabled]):focus,
.is-focused .switch label label:has(input[type=checkbox][disabled]),
.is-focused .switch label label:has(input[type=checkbox][disabled]):hover,
.is-focused .switch label label:has(input[type=checkbox][disabled]):focus {
	color: #999999;
}

select {
	-moz-appearance: none;
	-webkit-appearance: none;
}

html * {
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}

body,
h3 {
	font-family: "Roboto", "Helvetica", "Arial", sans-serif;
	font-weight: 300;
	line-height: 1.5em;
}

h3 {
	font-size: 1.5625rem;
	line-height: 1.4em;
	margin: 20px 0 10px;
}

.wrapper {
	position: relative;
	top: 0;
	height: 100vh;
}

body {
	background-color: #eee;
	color: #3C4858;
	font-weight: 300;
}

* {
	-webkit-tap-highlight-color: rgba(255, 255, 255, 0);
	-webkit-tap-highlight-color: transparent;
}

*:focus {
	outline: 0;
}
.com>img {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	margin-right: 10px
}

.com {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	-webkit-transition: all .4s ease-in;
	-moz-transition: all .4s ease-in;
	-ms-transition: all .4s ease-in;
	-o-transition: all .4s ease-in;
	transition: all .4s ease-in;
	color: #b2b2b2;
	float: left;
	margin-top: 6px;
	margin-right: 5px;
	position: relative;
	top: -5px
}

.user-data.full-width {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	background-color: #fff;
	margin-bottom: 20px;
	border-left: 1px solid #e5e5e5;
	border-right: 1px solid #e5e5e5;
	border-bottom: 1px solid #e5e5e5;
	text-align: center
}

.user-fw-status>li {
	margin: 0;
	padding: 15px 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	border-bottom: 0;
	border-top: 1px solid #e5e5e5
}

.user-fw-status>li {
	margin: 0;
	padding: 15px 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	border-bottom: 1px solid #e5e5e5;
	border-top: 1px solid #e5e5e5
}

.user-fw-status {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	list-style: none;
	float: left;
	width: 100%
}

.user-profile {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%
}

.user-specs>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 24px;
	font: inherit;
	vertical-align: baseline;
	color: #000;
	text-transform: capitalize;
	font-weight: 600;
	margin-bottom: 8px
}


.user-specs {
	margin: 0;
	padding: 63px 0 27px 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%
}

.username-dt {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	background-color: rgb(113 2 2);
	padding-top: 40px
}

.usr-pic>img {
	margin: 0;
	padding: 0;
	border: 5px solid #fff;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: none;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px;
	width: 100%
}

.usr-pic {
	margin: 0 auto;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	width: 110px;
	height: 110px;
	margin-bottom: -48px
}
a:hover,
a:focus {
	color: #89229b;
	text-decoration: none;
}


/*           Animations              */


/*
Animate.css - http://daneden.me/animate
Licensed under the MIT license - http://opensource.org/licenses/MIT
Copyright (c) 2015 Daniel Eden
*/


/* perfect-scrollbar v0.6.13 */

@supports (-ms-overflow-style: none) {}


/*          Changes for small display      */
@media (max-width:1920px) {
    #menu{
        width:65vw;
    }
    }
@media (max-width: 991px) {
    #menu{
        width:100vw;
    }
	html,
	body {
		overflow-x: hidden;
	}
	body {
		position: relative;
	}
}


/*# sourceMappingURL=dashboard-free.css.map */


/* Style.Tools Duplicate CSS Remover
 * 1.4 MB (+0.00% from 1.4 MB)
 * @src http://localhost/Elibrary/admin/booksearch.php */

@charset "UTF-8";

/*!
* Start Bootstrap - SB Admin v7.0.3 (https://startbootstrap.com/template/sb-admin)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
* Bootstrap v5.1.0 (https: //getbootstrap.com/)
* Copyright 2011-2021 The Bootstrap Authors * Copyright 2011-2021 Twitter, Inc. * Licensed under MIT (https: //github.com/twbs/bootstrap/blob/main/LICENSE)
*/

:root {
	--bs-blue: #0d6efd;
	--bs-indigo: #6610f2;
	--bs-purple: #6f42c1;
	--bs-pink: #d63384;
	--bs-red: #dc3545;
	--bs-orange: #fd7e14;
	--bs-yellow: #ffc107;
	--bs-green: #198754;
	--bs-teal: #20c997;
	--bs-cyan: #0dcaf0;
	--bs-white: #fff;
	--bs-gray: #6c757d;
	--bs-gray-dark: #343a40;
	--bs-gray-100: #f8f9fa;
	--bs-gray-200: #e9ecef;
	--bs-gray-300: #dee2e6;
	--bs-gray-400: #ced4da;
	--bs-gray-500: #adb5bd;
	--bs-gray-600: #6c757d;
	--bs-gray-700: #495057;
	--bs-gray-800: #343a40;
	--bs-gray-900: #212529;
	--bs-primary: #0d6efd;
	--bs-secondary: #6c757d;
	--bs-success: #198754;
	--bs-info: #0dcaf0;
	--bs-warning: #ffc107;
	--bs-danger: #dc3545;
	--bs-light: #f8f9fa;
	--bs-dark: #212529;
	--bs-primary-rgb: 13, 110, 253;
	--bs-secondary-rgb: 108, 117, 125;
	--bs-success-rgb: 25, 135, 84;
	--bs-info-rgb: 13, 202, 240;
	--bs-warning-rgb: 255, 193, 7;
	--bs-danger-rgb: 220, 53, 69;
	--bs-light-rgb: 248, 249, 250;
	--bs-dark-rgb: 33, 37, 41;
	--bs-white-rgb: 255, 255, 255;
	--bs-black-rgb: 0, 0, 0;
	--bs-body-rgb: 33, 37, 41;
	--bs-font-sans-serif: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
	--bs-font-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
	--bs-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
	--bs-body-font-family: "Roboto", "Helvetica";
	--bs-body-font-size: 1rem;
	--bs-body-font-weight: 400;
	--bs-body-line-height: 1.5;
	--bs-body-color: #212529;
	--bs-body-bg: #fff
}

*,
 ::after,
 ::before {
	box-sizing: border-box
}

@media (prefers-reduced-motion:no-preference) {
	:root {
		scroll-behavior: smooth
	}
}

body {
	margin: 0;
	font-family: var(--bs-body-font-family);
	font-size: var(--bs-body-font-size);
	font-weight: var(--bs-body-font-weight);
	line-height: var(--bs-body-line-height);
	color: var(--bs-body-color);
	text-align: var(--bs-body-text-align);
	background-color: var(--bs-body-bg);
	-webkit-text-size-adjust: 100%;
	-webkit-tap-highlight-color: transparent
}

@font-face {
	font-family: Nexa-bold;
	src: url(nexa-bold-webfont.woff)
}

h3 {
	margin-top: 0;
	margin-bottom: .5rem;
	font-weight: 500;
	line-height: 1.2
}

h3 {
	font-size: calc(1.3rem + .6vw)
}

@media (min-width:1200px) {
	h3 {
		font-size: 1.75rem
	}
}

p {
	margin-top: 0;
	margin-bottom: 1rem
}

ul {
	padding-left: 2rem
}

ul {
	margin-top: 0;
	margin-bottom: 1rem
}

a:hover {
	color: #9697bb
}

a:not([href]):not([class]),
a:not([href]):not([class]):hover {
	color: inherit;
	text-decoration: none
}

img,
svg {
	vertical-align: middle
}

button:focus:not(:focus-visible) {
	outline: 0
}

select {
	margin: 0;
	font-family: inherit;
	font-size: inherit;
	line-height: inherit
}

select {
	text-transform: none
}

select {
	word-wrap: normal
}

select:disabled {
	opacity: 1
}

[type=button]:not(:disabled),
[type=reset]:not(:disabled),
[type=submit]:not(:disabled),
button:not(:disabled) {
	cursor: pointer
}

::-moz-focus-inner {
	padding: 0;
	border-style: none
}

::-webkit-datetime-edit-day-field,
 ::-webkit-datetime-edit-fields-wrapper,
 ::-webkit-datetime-edit-hour-field,
 ::-webkit-datetime-edit-minute,
 ::-webkit-datetime-edit-month-field,
 ::-webkit-datetime-edit-text,
 ::-webkit-datetime-edit-year-field {
	padding: 0
}

::-webkit-inner-spin-button {
	height: auto
}

::-webkit-search-decoration {
	-webkit-appearance: none
}

::-webkit-color-swatch-wrapper {
	padding: 0
}

::-webkit-file-upload-button {
	font: inherit
}

::file-selector-button {
	font: inherit
}

::-webkit-file-upload-button {
	font: inherit;
	-webkit-appearance: button
}

.container-fluid {
	width: 100%;
	padding-right: var(--bs-gutter-x, .75rem);
	padding-left: var(--bs-gutter-x, .75rem);
	margin-right: auto;
	margin-left: auto
}

.row {
	--bs-gutter-x: 1.5rem;
	--bs-gutter-y: 0;
	display: flex;
	flex-wrap: wrap;
	margin-top: calc(var(--bs-gutter-y) * -1);
	margin-right: calc(var(--bs-gutter-x) * -.5);
	margin-left: calc(var(--bs-gutter-x) * -.5)
}

.row>* {
	flex-shrink: 0;
	width: 100%;
	max-width: 100%;
	padding-right: calc(var(--bs-gutter-x) * .5);
	padding-left: calc(var(--bs-gutter-x) * .5);
	margin-top: var(--bs-gutter-y)
}

@media (min-width:992px) {

	.col-lg-3 {
		flex: 0 0 auto;
		width: 25%
	}
	.col-lg-6 {
		flex: 0 0 auto;
		width: 50%
	}
}

.form-control[type=file]:not(:disabled):not([readonly]),
[type=file].dataTable-input:not(:disabled):not([readonly]) {
	cursor: pointer
}

.dataTable-input::file-selector-button,
.form-control::file-selector-button {
	padding: .375rem .75rem;
	margin: -.375rem -.75rem;
	-webkit-margin-end: .75rem;
	margin-inline-end: .75rem;
	color: #212529;
	background-color: #e9ecef;
	pointer-events: none;
	border-color: inherit;
	border-style: solid;
	border-width: 0;
	border-inline-end-width: 1px;
	border-radius: 0;
	transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
	.dataTable-input::file-selector-button,
	.form-control::file-selector-button {
		transition: none
	}
}

.dataTable-input:hover:not(:disabled):not([readonly])::-webkit-file-upload-button,
.form-control:hover:not(:disabled):not([readonly])::-webkit-file-upload-button {
	background-color: #dde0e3
}

.dataTable-input:hover:not(:disabled):not([readonly])::file-selector-button,
.form-control:hover:not(:disabled):not([readonly])::file-selector-button {
	background-color: #dde0e3
}

.form-control-sm::file-selector-button {
	padding: .25rem .5rem;
	margin: -.25rem -.5rem;
	-webkit-margin-end: .5rem;
	margin-inline-end: .5rem
}

.form-control-lg::file-selector-button {
	padding: .5rem 1rem;
	margin: -.5rem -1rem;
	-webkit-margin-end: 1rem;
	margin-inline-end: 1rem
}

.form-control-color:not(:disabled):not([readonly]) {
	cursor: pointer
}

.form-floating>.dataTable-input:not(:-moz-placeholder-shown),
.form-floating>.form-control:not(:-moz-placeholder-shown) {
	padding-top: 1.625rem;
	padding-bottom: .625rem
}

.form-floating>.dataTable-input:not(:-ms-input-placeholder),
.form-floating>.form-control:not(:-ms-input-placeholder) {
	padding-top: 1.625rem;
	padding-bottom: .625rem
}

.form-floating>.dataTable-input:not(:-moz-placeholder-shown)~label,
.form-floating>.form-control:not(:-moz-placeholder-shown)~label {
	opacity: .65;
	transform: scale(.85) translateY(-.5rem) translateX(.15rem)
}

.form-floating>.dataTable-input:not(:-ms-input-placeholder)~label,
.form-floating>.form-control:not(:-ms-input-placeholder)~label {
	opacity: .65;
	transform: scale(.85) translateY(-.5rem) translateX(.15rem)
}

.visually-hidden-focusable:not(:focus):not(:focus-within) {
	position: absolute!important;
	width: 1px!important;
	height: 1px!important;
	padding: 0!important;
	margin: -1px!important;
	overflow: hidden!important;
	clip: rect(0, 0, 0, 0)!important;
	white-space: nowrap!important;
	border: 0!important
}

.d-flex {
	display: flex!important
}

.justify-content-center {
	justify-content: center!important
}

.p-4 {
	padding: 1.5rem!important
}

.py-4 {
	padding-top: 1.5rem!important;
	padding-bottom: 1.5rem!important
}

body,
html {
	height: 100%
}

.row {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline
}

.col-lg-3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline
}

.wrapper>main {
	margin: 0;
	padding: 19px 0;
	float: left;
	width: 100%
}

.sd-title>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 18px;
	font: inherit;
	vertical-align: baseline;
	color: #000;
	font-weight: 600;
	float: left
}

.usy-dt>img {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px
}

.usy-name>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 16px;
	font: inherit;
	vertical-align: baseline;
	color: #000;
	text-transform: capitalize;
	font-weight: 600;
	margin-bottom: 6px;
	margin-top: 2px
}

.usy-name>span {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	color: #b2b2b2
}

.ed-options>li {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	margin-bottom: 15px
}

.job_descp>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 18px;
	font: inherit;
	vertical-align: baseline;
	color: #000;
	font-weight: 600;
	margin-bottom: 20px
}

.job_descp>p {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 16px;
	font: inherit;
	vertical-align: baseline;
	line-height: 24px;
	color: #686868;
	margin-bottom: 20px
}

.skill-tags>li {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	display: inline-block;
	margin-right: 6px;
	margin-bottom: 10px
}

.job-status-bar>a {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	float: right;
	color: #b2b2b2;
	margin-top: 5px
}

div>ul>li {
	display: inline
}

.wrapper {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	position: relative;
	height: auto
}

.main-section {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%
}

.main-section-data {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%
}

.sd-title {
	margin: 0;
	padding: 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	border-bottom: 1px solid #e5e5e5;
	position: relative
}

.la.la-ellipsis-v {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 30px;
	font: inherit;
	vertical-align: baseline;
	float: right;
	color: #b7b7b7;
	position: absolute;
	right: 5px;
	top: 15px
}

.col-lg-6 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline
}

.main-ws-sec {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%
}

.posts-section {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%
}

.post_topbar {
	margin: 0;
	padding: 20px 20px 15px 20px;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	position: relative
}

.usy-dt {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left
}

.usy-name {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	margin-left: 10px
}

.ed-opts {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: right;
	position: relative;
	top: 7px
}

.ed-opts-open {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 30px;
	font: inherit;
	vertical-align: baseline;
	-webkit-transition: all .4s ease-in;
	-moz-transition: all .4s ease-in;
	-ms-transition: all .4s ease-in;
	-o-transition: all .4s ease-in;
	transition: all .4s ease-in;
	color: #b2b2b2;
	float: right;
	position: relative;
	left: 13px
}

.ed-options {
	margin: 0;
	padding: 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	list-style: none;
	position: absolute;
	top: 100%;
	right: 0;
	width: 130px;
	background-color: #fff;
	-webkit-box-shadow: 0 0 10px rgba(0, 0, 0, .28);
	-moz-box-shadow: 0 0 10px rgba(0, 0, 0, .28);
	-ms-box-shadow: 0 0 10px rgba(0, 0, 0, .28);
	-o-box-shadow: 0 0 10px rgba(0, 0, 0, .28);
	box-shadow: 0 0 10px rgba(0, 0, 0, .28);
	opacity: 0;
	visibility: hidden;
	z-index: 0
}

.job_descp {
	margin: 0;
	padding: 0 20px 20px 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	border-bottom: 1px solid #e5e5e5
}

.skill-tags {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	list-style: none;
	float: left;
	width: 100%
}

.job-status-bar {
	margin: 0;
	padding: 15px 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%
}

.la.la-eye {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 20px;
	font: inherit;
	vertical-align: baseline;
	margin-right: 7px;
	position: relative;
	top: 3px
}

.right-sidebar {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%
}

.wrapper {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	position: relative
}

.filter-heading>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 18px;
	font: inherit;
	vertical-align: baseline;
	float: left;
	color: #000;
	font-weight: 600
}

.filter-heading>a {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	float: right;
	color: #686868;
	margin-top: 4px
}

.filter-ttl>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 16px;
	font: inherit;
	vertical-align: baseline;
	float: left;
	color: #000;
	font-weight: 600
}

.filter-ttl>a {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	float: right;
	color: #686868
}

.filter-dd>form {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	position: relative
}

.job-tp>select {
	margin: 0;
	padding: 0 10px;
	-webkit-appearance: none;
	-moz-appearance: none;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	-ms-border-radius: 4px;
	-o-border-radius: 4px;
	border-radius: 4px;
	width: 100%;
	height: 30px;
	background-color: #f2f2f2;
	color: #b2b2b2;
	font-size: 12px;
	font-weight: 600;
	border: 1px solid #e5e5e5
}

.job-details>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	color: #000;
	font-weight: 600;
	margin-bottom: 10px
}

.job-details>p {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	line-height: 20px;
	color: #686868
}

.filter-secs {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	background-color: #fff
}

.filter-heading {
	margin: 0;
	padding: 23px 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	border-bottom: 1px solid #e5e5e5;
	margin-bottom: 27px
}

.paddy {
	margin: 0;
	padding: 0 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%
}

.filter-dd {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	margin-bottom: 27px
}

.filter-ttl {
	margin: 0;
	padding: 0 0 8px 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	border-bottom: 1px solid #e5e5e5;
	margin-bottom: 10px
}

.job-tp {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	position: relative
}

.la.la-ellipsis-v {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline
}

.widget.widget-jobs {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	background-color: #fff;
	border-left: 1px solid #e4e4e4;
	border-right: 1px solid #e4e4e4;
	border-bottom: 1px solid #e4e4e4;
	margin-bottom: 20px;
	-webkit-box-shadow: 1px 0 2px rgba(0, 0, 0, .24);
	-moz-box-shadow: 1px 0 2px rgba(0, 0, 0, .24);
	-ms-box-shadow: 1px 0 2px rgba(0, 0, 0, .24);
	-o-box-shadow: 1px 0 2px rgba(0, 0, 0, .24);
	box-shadow: 1px 0 2px rgba(0, 0, 0, .24)
}

.jobs-list {
	margin: 0;
	padding: 20px 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%
}

.job-info {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	margin-bottom: 22px
}

.job-details {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 170px
}

.hr-rate {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: right;
	width: 40px
}

.sd-title>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 18px;
	font: inherit;
	vertical-align: baseline;
	color: #000000;
	font-weight: 600;
	float: left;
}

.usy-dt>img {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	-ms-border-radius: 100px;
	-o-border-radius: 100px;
	border-radius: 100px;
}

.usy-name>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 16px;
	font: inherit;
	vertical-align: baseline;
	color: #000000;
	text-transform: capitalize;
	font-weight: 600;
	margin-bottom: 6px;
	margin-top: 2px;
}

.usy-name>span {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	color: #b2b2b2;
}

.ed-options>li {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	margin-bottom: 15px;
}

.job_descp>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 18px;
	font: inherit;
	vertical-align: baseline;
	color: #000000;
	font-weight: 600;
	margin-bottom: 20px;
}

.job_descp>p {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 16px;
	font: inherit;
	vertical-align: baseline;
	line-height: 24px;
	color: #686868;
	margin-bottom: 20px;
}

.skill-tags>li {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	display: inline-block;
	margin-right: 6px;
	margin-bottom: 10px;
}

.job-status-bar>a {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	float: right;
	color: #b2b2b2;
	margin-top: 5px;
}

.job-details>h3 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	color: #000000;
	font-weight: 600;
	margin-bottom: 10px;
}

.job-details>p {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 14px;
	font: inherit;
	vertical-align: baseline;
	line-height: 20px;
	color: #686868;
}

.main-section {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
}

.main-section-data {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
}

.row {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}

.sd-title {
	margin: 0;
	padding: 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	border-bottom: 1px solid #e5e5e5;
	position: relative;
}

.la.la-ellipsis-v {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 30px;
	font: inherit;
	vertical-align: baseline;
	float: right;
	color: #b7b7b7;
	position: absolute;
	right: 5px;
	top: 15px;
}

.main-ws-sec {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
}

.posts-section {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
}

.post-bar {
	margin: 0;
	padding: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	-ms-border-radius: 4px;
	-o-border-radius: 4px;
	border-radius: 4px;
	float: left;
	width: 100%;
	background-color: #fff;
	border-left: 1px solid #e4e4e4;
	border-right: 1px solid #e4e4e4;
	border-bottom: 1px solid #e4e4e4;
	margin-bottom: 20px;
}

.post_topbar {
	margin: 0;
	padding: 20px 20px 15px 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	position: relative;
}

.usy-dt {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
}

.usy-name {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	margin-left: 10px;
}

.ed-opts {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: right;
	position: relative;
	top: 7px;
}

.ed-opts-open {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 30px;
	font: inherit;
	vertical-align: baseline;
	-webkit-transition: all 0.4s ease-in;
	-moz-transition: all 0.4s ease-in;
	-ms-transition: all 0.4s ease-in;
	-o-transition: all 0.4s ease-in;
	transition: all 0.4s ease-in;
	color: #b2b2b2;
	float: right;
	position: relative;
	left: 13px;
}

.ed-options {
	margin: 0;
	padding: 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	list-style: none;
	position: absolute;
	top: 100%;
	right: 0;
	width: 130px;
	background-color: #fff;
	-webkit-box-shadow: 0 0 10px rgba(0, 0, 0, 0.28);
	-moz-box-shadow: 0 0 10px rgba(0, 0, 0, 0.28);
	-ms-box-shadow: 0 0 10px rgba(0, 0, 0, 0.28);
	-o-box-shadow: 0 0 10px rgba(0, 0, 0, 0.28);
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.28);
	opacity: 0;
	visibility: hidden;
	z-index: 0;
}

.job_descp {
	margin: 0;
	padding: 0 20px 20px 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	border-bottom: 1px solid #e5e5e5;
}

.skill-tags {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	list-style: none;
	float: left;
	width: 100%;
}

.job-status-bar {
	margin: 0;
	padding: 15px 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
}

.la.la-eye {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 20px;
	font: inherit;
	vertical-align: baseline;
	margin-right: 7px;
	position: relative;
	top: 3px;
}

.right-sidebar {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
}

.widget.widget-jobs {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	background-color: #fff;
	border-left: 1px solid #e4e4e4;
	border-right: 1px solid #e4e4e4;
	border-bottom: 1px solid #e4e4e4;
	margin-bottom: 20px;
	-webkit-box-shadow: 1px 0px 2px rgba(0, 0, 0, 0.24);
	-moz-box-shadow: 1px 0px 2px rgba(0, 0, 0, 0.24);
	-ms-box-shadow: 1px 0px 2px rgba(0, 0, 0, 0.24);
	-o-box-shadow: 1px 0px 2px rgba(0, 0, 0, 0.24);
	box-shadow: 1px 0px 2px rgba(0, 0, 0, 0.24);
}

.jobs-list {
	margin: 0;
	padding: 20px 20px;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
}

.job-info {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 100%;
	margin-bottom: 22px;
}

.job-details {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: left;
	width: 170px;
}

.hr-rate {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	float: right;
	width: 40px;
}

.col-lg-6 {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}
    </style>
@endsection

