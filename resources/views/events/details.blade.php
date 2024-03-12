@extends('layouts.simple.master')
@section('title', 'Event Details')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Event Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Event</li>
<li class="breadcrumb-item active">Event Details</li>
@endsection

@section('content')
<div class="container-fluid">
   <div>
     <div class="row product-page-main p-0">
       <div class="col-xxl-5 box-col-6 order-xxl-0 order-1">
         <div class="card">
          @if($event)
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
                   <h3>{{$event->event_name}}</h3>
                 </div>
                 
                 <ul class="product-color">
                   <li class="bg-primary"></li>
                   <li class="bg-secondary"></li>
                   <li class="bg-success"></li>
                   <li class="bg-info"></li>
                   <li class="bg-warning"></li>
                 </ul>
                
              </div>
              <div class="col-md-3">         
                  <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditFamilyModal">
                  Edit Event Details
                </a>

              </div>
            </div>

             <hr>

             <div>
               <table class="product-page-width"  style="border-collapse: separate;border-spacing: 20px;">
                 <tbody>
                   <tr>
                     <td> <b>Date</b></td>
                     <td> <b>&nbsp;:&nbsp;</b></td>
                     <td>{{$event->date}}
                     
                     </td>
                   </tr>
                   <tr>
                     <td> <b>Venue  </b></td>
                      <td> <b> &nbsp;:&nbsp;</b></td>
                     <td class="txt-success">{{$event->venue}}</td>
                   </tr>
                  
                   <tr>
                     <td> <b>Details  </b></td>
                      <td> <b> &nbsp;:&nbsp;</b></td>
                     <td>{{$event->details}}</td>
                   </tr>
                 </tbody>
               </table>
             </div>
             <hr>
           </div>
           @endif
         </div>
       </div>
     </div>
   </div>
 </div>


@if($event)

 <div class="modal fade" id="EditFamilyModal" tabindex="-1" role="dialog" aria-labelledby="EditFamilyModalArea" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title">Family Details</h5>
             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="needs-validation" novalidate="" action="{{route('admin.event.update',['id'=>$event->id])}}" method="Post">
          <div class="modal-body">
              @csrf
                  <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label" for="validationCustom01">Event Name</label>
                            <input class="form-control" id="validationCustom01" type="text" 
                            value="{{ $event['event_name'] }}" required="" name='event_name'>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="validationCustom02">Date </label>
                            <input class="form-control" id="validationCustom02" type="date" value="{{$event['date'] }}"  required="" name='date'>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="validationCustom02">Venue</label>
                            <input class="form-control" id="validationCustom02" type="text" value="{{$event['venue']}}" name='venue'>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        
                    </div>
                    <div class="row g-3">
                        
                         <div class="col-md-12">
                            <label class="form-label" for="validationCustom04">Details</label>
                             <textarea class="form-control" id="details" name="details" rows="5" cols="50" >
                               {{$event['details']}}
                             </textarea><br>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                       
                    </div>      
          </div>
          <div class="modal-footer">
             <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.event.list') }}'">Close</button>
             <button class="btn btn-success" type="submit">Update</button>
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