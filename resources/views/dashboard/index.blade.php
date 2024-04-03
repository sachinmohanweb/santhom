@extends('layouts.simple.master')

@section('title', 'Dashboard')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Dashboard</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row widget-grid">
	  <div class="col-xxl-4 col-sm-12 box-col-6">
		<div class="card profile-box">
		  <div class="card-body">
			<div class="media">
			  <div class="media-body"> 
				<div class="greeting-user">
				  <h4 class="f-w-600">Welcome to Santhom Connect</h4>
				  <p>St. Thomas Malankara Syrian Catholic Church, Nelanchira</p>
				  <div class="whatsnew-btn"><a class="btn btn-outline-white">Whats New !</a></div>
				</div>
			  </div>
			  <div>  
				<div class="clockbox">
				  <svg id="clock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 600">
					<g id="face">
					  <circle class="circle" cx="300" cy="300" r="253.9"></circle>
					  <path class="hour-marks" d="M300.5 94V61M506 300.5h32M300.5 506v33M94 300.5H60M411.3 107.8l7.9-13.8M493 190.2l13-7.4M492.1 411.4l16.5 9.5M411 492.3l8.9 15.3M189 492.3l-9.2 15.9M107.7 411L93 419.5M107.5 189.3l-17.1-9.9M188.1 108.2l-9-15.6"></path>
					  <circle class="mid-circle" cx="300" cy="300" r="16.2"></circle>
					</g>
					<g id="hour">
					  <path class="hour-hand" d="M300.5 298V142"></path>
					  <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
					</g>
					<g id="minute">
					  <path class="minute-hand" d="M300.5 298V67"></path>
					  <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
					</g>
					<g id="second">
					  <path class="second-hand" d="M300.5 350V55"></path>
					  <circle class="sizing-box" cx="300" cy="300" r="253.9">   </circle>
					</g>
				  </svg>
				</div>
				<div class="badge f-10 p-0" id="txt"></div>
			  </div>
			</div>
			<!-- <div class="cartoon"><img class="img-fluid" src="{{ asset('assets/images/dashboard/cartoon.svg') }}" alt="vector women with leptop">
			</div> -->
		  </div>
		</div>
	  </div>

	  <!-- <div class="col-xxl-4 col-sm-6 box-col-6">
		<div class="card profile-box">
		  <div class="card-body">
			<div class="media">
			  <div class="media-body"> 
				<div class="greeting-user">
				  <h4 class="f-w-600">Welcome to cuba</h4>
				  <p>Here whats happing in your account today</p>
				  <div class="whatsnew-btn"><a class="btn btn-outline-white">Whats New !</a></div>
				</div>
			  </div>
			  <div>  
				<div class="clockbox">
				  <svg id="clock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 600">
					<g id="face">
					  <circle class="circle" cx="300" cy="300" r="253.9"></circle>
					  <path class="hour-marks" d="M300.5 94V61M506 300.5h32M300.5 506v33M94 300.5H60M411.3 107.8l7.9-13.8M493 190.2l13-7.4M492.1 411.4l16.5 9.5M411 492.3l8.9 15.3M189 492.3l-9.2 15.9M107.7 411L93 419.5M107.5 189.3l-17.1-9.9M188.1 108.2l-9-15.6"></path>
					  <circle class="mid-circle" cx="300" cy="300" r="16.2"></circle>
					</g>
					<g id="hour">
					  <path class="hour-hand" d="M300.5 298V142"></path>
					  <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
					</g>
					<g id="minute">
					  <path class="minute-hand" d="M300.5 298V67"></path>
					  <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
					</g>
					<g id="second">
					  <path class="second-hand" d="M300.5 350V55"></path>
					  <circle class="sizing-box" cx="300" cy="300" r="253.9">   </circle>
					</g>
				  </svg>
				</div>
				<div class="badge f-10 p-0" id="txt"></div>
			  </div>
			</div>
			<div class="cartoon"><img class="img-fluid" src="{{ asset('assets/images/dashboard/cartoon.svg') }}" alt="vector women with leptop"></div>
		  </div>
		</div>
	  </div> -->

	 <!--  <div class="col-xxl-4 col-xl-6 col-md-6 col-sm-7 notification box-col-6">
		<div class="card height-equal"> 
		  <div class="card-header card-no-border">
			<div class="header-top">
			  <h5 class="m-0">Activity</h5>
			  <div class="card-header-right-icon">
				<div class="dropdown">
				  <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
				  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday  </a></div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="card-body pt-0">
			<ul> 
			  <li class="d-flex">
				<div class="activity-dot-primary"></div>
				<div class="w-100 ms-3">
				  <p class="d-flex justify-content-between mb-2"><span class="date-content light-background">8th March, 2022 </span><span>1 day ago</span></p>
				  <h6>Updated Product<span class="dot-notification"></span></h6>
				  <p class="f-light">Quisque a consequat ante sit amet magna...</p>
				</div>
			  </li>
			  <li class="d-flex">
				<div class="activity-dot-warning"></div>
				<div class="w-100 ms-3">
				  <p class="d-flex justify-content-between mb-2"><span class="date-content light-background">15th Oct, 2022 </span><span>Today</span></p>
				  <h6>Tello just like your product<span class="dot-notification"></span></h6>
				  <p>Quisque a consequat ante sit amet magna... </p>
				</div>
			  </li>
			  <li class="d-flex">
				<div class="activity-dot-secondary"></div>
				<div class="w-100 ms-3">
				  <p class="d-flex justify-content-between mb-2"><span class="date-content light-background">20th Sep, 2022 </span><span>12:00 PM</span></p>
				  <h6>Tello just like your product<span class="dot-notification"></span></h6>
				  <p>Quisque a consequat ante sit amet magna... </p>
				</div>
			  </li>
			</ul>
		  </div>
		</div>
	  </div>
	  <div class="col-xxl-4 col-md-6 appointment-sec box-col-6">
		<div class="appointment">
		  <div class="card">
			<div class="card-header card-no-border">
			  <div class="header-top">
				<h5 class="m-0">Recent Sales</h5>
				<div class="card-header-right-icon">
				  <div class="dropdown">
					<button class="btn dropdown-toggle" id="recentButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
					<div class="dropdown-menu dropdown-menu-end" aria-labelledby="recentButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
				  </div>
				</div>
			  </div>
			</div>
			<div class="card-body pt-0">
			  <div class="appointment-table table-responsive">
				<table class="table table-bordernone">
				  <tbody>
					<tr>
					  <td><img class="img-fluid img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/1.jpg') }}" alt="user"></td>
					  <td class="img-content-box"><a class="d-block f-w-500" href="">Jane Cooper</a><span class="f-light">10 minutes ago</span></td>
					  <td class="text-end">
						<p class="m-0 font-success">$200.00</p>
					  </td>
					</tr>
					<tr>
					  <td><img class="img-fluid img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/2.jpg') }}" alt="user"></td>
					  <td class="img-content-box"><a class="d-block f-w-500" href="">Brooklyn Simmons</a><span class="f-light">19 minutes ago</span></td>
					  <td class="text-end">
						<p class="m-0 font-success">$970.00</p>
					  </td>
					</tr>
					<tr>
					  <td><img class="img-fluid img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/3.jpg') }}" alt="user"></td>
					  <td class="img-content-box"><a class="d-block f-w-500" href="">Leslie Alexander</a><span class="f-light">2 hours ago</span></td>
					  <td class="text-end">
						<p class="m-0 font-success">$300.00</p>
					  </td>
					</tr>
					<tr>
					  <td><img class="img-fluid img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/4.jpg') }}" alt="user"></td>
					  <td class="img-content-box"><a class="d-block f-w-500" href="">Travis Wright</a><span class="f-light">8 hours ago</span></td>
					  <td class="text-end">
						<p class="m-0 font-success">$450.00</p>
					  </td>
					</tr>
					<tr>
					  <td><img class="img-fluid img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/5.jpg') }}" alt="user"></td>
					  <td class="img-content-box"><a class="d-block f-w-500" href="">Mark Green</a><span class="f-light">1 day ago</span></td>
					  <td class="text-end">
						<p class="m-0 font-success">$768.00</p>
					  </td>
					</tr>
				  </tbody>
				</table>
			  </div>
			</div>
		  </div>
		</div>
	  </div> -->
		<!-- <div class="col-xxl-auto col-xl-12 col-sm-6 box-col-6">
			<div class="row"> 
		  <div class="col-xxl-12 col-xl-6 box-col-12">
			<div class="card  widget-with-chart">
			  <div class="card-body"> 
				<div> 
				  <h4 class="mb-1">1,80k</h4><span class="f-light">Orders</span>
				</div>
				
			  </div>
			</div>
		  </div>
		  <div class="col-xxl-12 col-xl-6 box-col-12">
			<div class="card widget-with-chart">
			  <div class="card-body"> 
				<div> 
				  <h4 class="mb-1">6,90k</h4><span class="f-light">Profit</span>
				</div>
				
			  </div>
			</div>
		  </div>
			</div>
	  </div>
	  <div class="col-xxl-5 col-lg-12 col-md-11 box-col-8 col-ed-6"> 
		<div class="card papernote-wrap">
		  <div class="card-header card-no-border">
			<div class="header-top"> 
			  <h5>PaperNote</h5><a class="f-light d-flex align-items-center" href="#">View project <i class="f-w-700 icon-arrow-top-right"></i></a>
			</div>
		  </div>
		  <div class="card-body pt-0"> <img class="banner-img img-fluid" src="{{ asset('assets/images/dashboard/papernote.jpg') }}" alt="multicolor background">
			<div class="note-content mt-sm-4 mt-2">
			  <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit.</p>
			  <div class="note-labels">
				<ul>
				  <li> <span class="badge badge-light-primary">SAAS</span></li>
				  <li> <span class="badge badge-light-success">E-Commerce</span></li>
				  <li> <span class="badge badge-light-warning">Crypto</span></li>
				  <li> <span class="badge badge-light-info">Project</span></li>
				  <li> <span class="badge badge-light-secondary">NFT</span></li>
				  <li> <span class="badge badge-light-light">+9</span></li>
				</ul>
				<div class="last-label"> <span class="badge badge-light-success">Inprogress</span></div>
			  </div>
			  <div class="mt-sm-4 mt-2 user-details">
				<div class="customers">
				  <ul> 
					<li class="d-inline-block"><img class="img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/1.jpg') }}" alt="user"></li>
					<li class="d-inline-block"><img class="img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/6.jpg') }}" alt="user"></li>
					<li class="d-inline-block"><img class="img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/7.jpg') }}" alt="user"></li>
					<li class="d-inline-block"><img class="img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/3.jpg') }}" alt="user"></li>
					<li class="d-inline-block"><img class="img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/8.jpg') }}" alt="user"></li>
					<li class="d-inline-block">
					  <div class="light-card"><span class="f-w-500">+5</span></div>
					</li>
				  </ul>
				</div>
				<div class="d-flex align-items-center"> 
				  <h5 class="mb-0 font-primary f-18 me-1">$239,098</h5><span class="f-light f-w-500">(Budget)</span>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div> -->
	</div>
  </div>
    <script type="text/javascript">
        var session_layout = '{{ session()->get('layout') }}';
    </script>
@endsection

@section('script')
<script src="{{ asset('assets/js/clock.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/default.js') }}"></script>
<script src="{{ asset('assets/js/notify/index.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script>
@endsection
