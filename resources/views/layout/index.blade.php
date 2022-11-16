<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - ClinicNet </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">s
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
qr
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
 <!-- <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">-->

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.4.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

<!-- =======================================================
* Tambahan baru .. 
* untuk quyery ..
======================================================== -->
<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" /> -->

<!-- ======================================================== -->

<!-- ========== bARU2 ============== lARAVEL 9 ========= -->$_COOKIE

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
<link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">


<!-- <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> -->
<link href="{{ asset('baru2/jquery.inputpicker.css?v3') }}" rel="stylesheet" type="text/css">

<!-- Coba2 -->

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="{{ asset('baru2/fm.selectator.jquery.css?cb=29') }}" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-=================== --->


<style>
		body {
			font-family: 'Open Sans', sans-serif;
			margin: 0;
			background-color: #eee;
		}
		#wrapper {
			padding: 0;
			max-width: 1024px;
			margin: 0 auto;
			background-color: #fff;
		}
		#wrapper_inner {
			padding: 1rem 5rem 7rem;
			max-width: 1024px;
			margin: 0 auto;
		}
		header {
			padding-top: 2rem;
			padding-bottom: 2rem;
			margin-bottom: 2rem;
		}
		h1 {
			font-weight: 400;
			margin: 0;
			font-size: 2.25rem;
		}
		h1 > small {
			color: #888;
		}
		hr {
			border: 0;
			border-top: 1px solid #dcdcdc;
		}
		small {
			color: #666;
		}
		input[type=button] {
			background-color: #fafafa;
			-moz-border-radius: 2px;
			-webkit-border-radius: 2px;
			border-radius: 2px;
			border: 1px solid #dcdcdc;
			display: inline-block;
			cursor: pointer;
			color: #666;
			padding: 10px 16px;
			text-decoration: none;
			text-transform: uppercase;
			outline: none;
		}
		input[type=button]:hover {
			background-color: #f6f6f6;
		}
		input[type=button]:active {
			position: relative;
			top: 1px;
		}
		section {
			margin-bottom: 1.5rem;
		}
		label {
			display: block;
			margin-bottom: 5px;
		}
		#select1,
		#select1_ajax {
			width: 250px;
			padding: 7px 10px;
		}
		#select2,
		#select2_ajax,
		#select3,
		#select3_ajax,
		#select5,
		#select5_ajax,
		#select6 {
			width: 350px;
			height: 36px;
		}
		#select4,
		#select4_ajax {
			width: 350px;
			height: 50px;
		}
		.option_one,
		.option_two,
		.option_three,
		.option_four,
		.option_five,
		.option_six,
		.option_seven,
		.option_eight,
		.option_nine,
		.option_ten,
		.option_eleven,
		.option_twelve,
		.option_thirteen,
		.option_fourteen {
		}
		.group_one,
		.group_two,
		.group_three {
		}
	</style>

</head>

<body>

  <!-- ======= Header ======= -->
  @include('layout.header')

  <!-- ======= Sidebar ======= -->
  @include('layout.sidebar')

    <!-- ======= Page Content ======= -->
    
   @yield('content', 'Default content')
    
  <!-- ======= Footer ======= -->
  @include('layout.footer')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!--- UJI COBA -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>-->
  
  <!-- Tambahan Baru -->
  <script src="{{ asset('baru2/jquery-3.6.0.min.js')}}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('baru2/jquery.form.min.js') }}"></script>
  <script src="{{ asset('baru2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('baru2/html5-qrcode.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('baru2/jquery.inputpicker.js') }}"></script>
<!-- <script src="{{ asset('baru2/datatables.min.js') }}"></script> -->


 <script src="{{ asset('baru2/fm.selectator.jquery.js?cb=29') }}"></script> 


<!-- Baru coba2 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
-->

<!-- bARU LARAVEL 9 
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>