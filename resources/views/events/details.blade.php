@extends('layouts.simple.master')
@section('title', 'Event Details')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
<style type="text/css">
    .clockpicker-popover{
        z-index: 1060 !important;
    }
</style>
@endsection

@section('breadcrumb-title')
<h3>Event Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Event Details</li>
@endsection

@section('content')
<div class="container-fluid">
   <div>
     <div class="row product-page-main p-0">
       <div class="col-xxl-12 box-col-6 order-xxl-0 order-1">
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
                  <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditEventModal">
                  Edit Event Details
                </a>

              </div>
            </div>

             <hr>

             <div class="row">
                <div class="col-md-9">

                   <table class="product-page-width"  style="border-collapse: separate;border-spacing: 20px;">
                     <tbody>
                       <tr>
                         <td> <b>Date</b></td>
                         <td> <b>&nbsp;:&nbsp;</b></td>
                         <td>{{$event->date}}
                         
                         </td>
                       </tr>
                       <tr>  
                         <td> <b>Time</b></td>
                         <td> <b>&nbsp;:&nbsp;</b></td>
                         <td>{{$event->time_value}}
                         
                         </td>
                       </tr>
                       <tr>
                         <td> <b>Venue  </b></td>
                          <td> <b> &nbsp;:&nbsp;</b></td>
                         <td class="txt-success">{{$event->venue}}</td>
                       </tr>
                      
                       <tr>
                         <td> <b>Media Link  </b></td>
                          <td> <b> &nbsp;:&nbsp;</b></td>
                         <td>
                            @if($event->link)
                            <a href="{{$event->link}}" target="_blank">click here</a>
                            @endif
                        </td>
                       </tr>
                       <tr>
                         <td> <b>Details  </b></td>
                          <td> <b> &nbsp;:&nbsp;</b></td>
                         <td>{{$event->details}}</td>
                       </tr>
                     </tbody>
                   </table>
                </div>
                @if($event->image)
                    <div class="col-md-3">
                        <img src="{{asset($event->image)}}" width="100%">
                    </div>
                @endif

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

 <div class="modal fade" id="EditEventModal" tabindex="-1" role="dialog" aria-labelledby="EditEventModalArea" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title">Event Details</h5>
             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="needs-validation" novalidate="" action="{{route('admin.event.update',['id'=>$event->id])}}" method="Post" enctype="multipart/form-data">
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
                            <label class="form-label" for="validationCustom02">Time </label>

                            <div class="input-group">
                            <input class="form-control" type="text" value="{{ $event['time'] }}" data-bs-original-title="" name="time" required title="hh:mm:ss"
                            pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]">
                            <div class="invalid-feedback">Time format hh:mm:ss</div>
                        </div>
                    </div>

                        <div class="col-md-4">
                            <label class="form-label" for="validationCustom02">Media Link</label>
                            <input class="form-control" id="validationCustom02" type="text" value="{{$event['link']}}" name='link'>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label" for="validationCustom02">Venue</label>
                            <input class="form-control" id="validationCustom02" type="text" value="{{$event['venue']}}" name='venue'>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        
                    </div>
                    <div class="row g-3">
                        
                         <div class="col-md-8">
                            <label class="form-label" for="validationCustom04">Details</label>
                             <textarea class="form-control" id="details" name="details" rows="5" cols="50" >
                               {{$event['details']}}
                             </textarea><br>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-md-4">
                            <div class="row g-3">
                            @if($event['image'])

                                    <div class="col-md-4 mb-3" id="OldImage">
                                        <img class="img-fluid for-light" src="{{ asset($event->image) }}" alt="" style="max-width:100px !important;">
                                    </div>
                            @endif
                            
                            <label class="form-label" for="validationCustom05">Image
                            <span style="color:#95937f;font-size: 12px;">(400px W X 300px H)</span>
                            </label>
                            <input class="form-control" id="ImageFile" type="file" 
                                 name="image" value="{{ $event['image'] }}">
                            <div class="invalid-feedback">Please provide a valid zip.</div>
                        </div>
                       
                    </div>      
          </div>
          <div class="modal-footer">
             <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.event.list') }}'">Close</button>
            @if($event->image)
                <a class="btn btn-danger" id="deleteImage" table_id ="{{$event->id}}">Delete Image</a>
            @endif
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
<script type="text/javascript">
  $('#deleteImage').click(function() {

      var table_id = $(this).attr('table_id');
      var type = 'events';
      var deleteUrl = '{{url("/deleteImage")}}'
      var csrfToken = '{{csrf_token()}}' ;

      $.ajax({
          url: deleteUrl,
          method: 'POST',
          contentType: 'application/json',
          data: JSON.stringify({ type: type, table_id: table_id,_token: csrfToken}),
          success: function(response) {
            location.reload();            
          },
          error: function(xhr, status, error) {
            location.reload();
          }
      });
  });
</script>

@endsection