@extends('layouts.simple.master')
@section('title', 'Daily Schedules')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Daily Schedules Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Daily Schedules Details</li>
@endsection

@section('content')
<div class="container-fluid">
   <div>
     <div class="row product-page-main p-0">
       <div class="col-xxl-12 box-col-6 order-xxl-0 order-1">
         <div class="card">
          @if($DailySchedules)
           <div class="card-body">
            @if (Session::has('success'))
              <div class="alert alert-success">
                 <ul>
                    <li>{!! Session::get('success') !!}</li>
                 </ul>
              </div>
            @endif
            @if (Session::has('error'))
              <div class="alert alert-danger">
                 <ul>
                    <li>{!! Session::get('error') !!}</li>
                 </ul>
              </div>
           @endif
            <div class="row">
              <div class="col-md-9">

                 <div class="product-page-details">
                      <h1>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $DailySchedules->date)->format('d-m-y') }}: {{ \Carbon\Carbon::createFromFormat('H:i:s', $DailySchedules->time)->format('h:i A') }}</h1>
                 </div>
                 
                 <ul class="product-color">
                   <li class="bg-primary"></li>
                   <li class="bg-secondary"></li>
                   <li class="bg-success"></li>
                   <li class="bg-info"></li>
                   <li class="bg-warning"></li>
                   <li class="bg-primary"></li>
                   <li class="bg-secondary"></li>
                   <li class="bg-success"></li>
                   <li class="bg-info"></li>
                   <li class="bg-warning"></li>
                 </ul>
                
              </div>
              <div class="col-md-3">         
                  <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditscheduleModal">
                  Edit Daily Schedule 
                </a>

              </div>
            </div>

             <hr>

             <div class="row">
                <div class="col-md-9">

                   <table class="product-page-width" style="border-collapse: separate; border-spacing: 20px; width: 100%; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px; background-color: #f9f9f9;">
                      <tbody>
                          <tr>
                              <td style="padding: 10px; text-align: center; font-weight: bold; border-bottom: 1px solid #ddd;">Details</td>
                          </tr>
                          <tr>
                            <td>Title</td>
                            <td>:</td>
                              <td style="padding: 10px;">{!! $DailySchedules->title !!}</td>
                          </tr>
                           <tr>
                            <td>Venu</td>
                            <td>:</td>
                              <td style="padding: 10px;">{!! $DailySchedules->venue !!}</td>
                          </tr>
                           <tr>
                            <td>Details</td>
                            <td>:</td>
                              <td style="padding: 10px;">{!! $DailySchedules->details !!}</td>
                          </tr>
                      </tbody>
                  </table>
                </div>
               

             </div>
             <hr>
           </div>
           @endif
         </div>
       </div>
     </div>
   </div>
 </div>

@if($DailySchedules)

 <div class="modal fade" id="EditscheduleModal" tabindex="-1" role="dialog" aria-labelledby="EditEventModalArea" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title">Memory Details</h5>
             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="needs-validation" novalidate="" action="{{route('admin.daily.schedules.update',['id'=>$DailySchedules->id])}}" method="Post" enctype="multipart/form-data">
          <div class="modal-body">
              @csrf
             
                 <div class="row mb-2">
                <div class="profile-title">
                  <div class="media-body">
                    <div class="row">
                      <div class="col-md-6">
                        <label class="form-label">Date<span style="color:red">*</span></label>
                        <input class="form-control" type="date" placeholder="date" id="date" name="date" value="{{$DailySchedules->date}}">
                      </div>
                       <div class="col-md-6">
                        <label class="form-label" for="validationCustom02">Time<span style="color:red">*</span></label>
                          <div class="input-group clockpicker">
                            <input class="form-control" type="text" value="{{ $DailySchedules->time}}" data-bs-original-title="" name="time" required  title="hh:mm:ss">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                          </div>
                       
                        </div>
                      </div><br>
                      <div class="row">
                        <div class="col-md-6">
                         <label class="form-label" for="validationCustom02">Venue <span style="color:red">*</span></label>
                          <input class="form-control" id="validationCustom02" type="text" value="{{ $DailySchedules->venue }}" name='venue' required>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                         <div class="col-md-6">
                           <label class="form-label" for="validationCustom02">Title <span style="color:red">*</span></label>
                            <input class="form-control" id="validationCustom02" type="text" value="{{ $DailySchedules->title }}" name='title' required>
                            <div class="valid-feedback">Looks good!</div>
                          </div>
                        </div><br>
                       
                    <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">Schedules<span style="color:red">*</span></label>
                        <textarea class="form-control" id="details" name="details" rows="5" required>
                          {{$DailySchedules->details}}</textarea ><br>
                        <div class="valid-feedback">Looks good!</div>
                      </div>
                    </div>

                  

                  </div>
                </div>
              </div>
              <div class="form-footer">
                <button class="btn btn-primary">Save</button>

                <a class="btn btn-primary" onclick="window.location='{{ route('admin.daily.schedules.list') }}'">Cancel</a>
              </div>
          </div>
          </form>
       </div>
    </div>
 </div>

@endif

@endsection

@section('script')
<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/js/rating/jquery.barrating.js')}}"></script>
<script src="{{asset('assets/js/rating/rating-script.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/ecommerce.js')}}"></script>
<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection