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
<li class="breadcrumb-item">Event</li>
<li class="breadcrumb-item active">Daily Schedules Details</li>
@endsection

@section('content')
<div class="container-fluid">
   <div>
     <div class="row product-page-main p-0">
       <div class="col-xxl-5 box-col-6 order-xxl-0 order-1">
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
                  @if($DailySchedules->type=='Normal Day')
                      @if($DailySchedules->day_category=='Mon-Sat')
                          <h3>Monday-Saturday</h3>
                      @else
                          <h3>Sunday</h3>
                      @endif
                  @else
                   <h3>Special Day</h3>
                  @endif
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
                  <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditscheduleModal">
                  Edit Daily Schedule 
                </a>

              </div>
            </div>

             <hr>

             <div class="row">
                <div class="col-md-9">

                   <table class="product-page-width"  style="border-collapse: separate;border-spacing: 20px;">
                     <tbody>
                        @if($DailySchedules->type=='Special Day')                      
                         <tr>
                         <td> <b>Date</b></td>
                         <td> <b>&nbsp;:&nbsp;</b></td>
                         <td>{{$DailySchedules->date}}
                         
                         </td>
                       </tr>
                       @endif
                          <tr>
                         <td> <b>Details</b></td>
                         <td> <b>&nbsp;:&nbsp;</b></td>
                         <td>{!! $DailySchedules->details !!}
                         
                         </td>
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
                        <label class="form-label">Schedule Type</label>
                        <select class="form-control" name="type" id="type" required>
                          <option value="">--Select--</option>
                          <option value="1"  {{ $DailySchedules->type === 'Normal Day' ? 'selected' :'' }}>Normal Day</option>
                          <option value="2"  {{ $DailySchedules->type === 'Special Day' ? 'selected' :'' }}>Special Day</option>
                         
                        </select>  
                      </div>
                      <div class="col-md-6" id="normal_day_options">
                        <label class="form-label">Day Category</label>
                        <select class="form-control" name="day_category" id="day_category">
                          <option value="">--Select--</option>
                          <option value="1">Monday to Saturday</option>
                          <option value="2">Sunday</option>
                         
                        </select>  
                      </div>
                      <div class="col-md-6" id="special_day_options">
                        <label class="form-label">Date<span style="color:red">*</span></label>
                        <input class="form-control" type="date" placeholder="date" id="date" name="date">
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
                <button class="btn btn-primary btn-block">Save</button>

                <a class="btn btn-primary" onclick="window.location='{{ route('admin.biblical.citation.list') }}'">Cancel</a>
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
<script type="text/javascript">
  CKEDITOR.replace('details')
</script>
<script type="text/javascript">

  $(document).ready(function() {

      var type = '{{$DailySchedules->type}}';
      if(type=='Normal Day'){
          var day_category = '{{$DailySchedules->day_category}}';
          $('#normal_day_options').show();
          $('#special_day_options').hide();
          $('#day_category').attr('required', 'required');
          if(day_category=='Mon-Sat'){
              $('#day_category').val(1);
          }else{
              $('#day_category').val(2);
          }
      }else{
          var special_date = '{{$DailySchedules->date}}';
          $('#normal_day_options').hide();
          $('#special_day_options').show();
          $('#date').attr('required', 'required');
          $('#date').val(special_date);
      }


      $('#type').change(function() {

        var selectedType = $(this).val();
        if (selectedType === '1') {
            $('#normal_day_options').show();
            $('#special_day_options').hide();
            $('#day_category').attr('required', 'required');
            $('#date').removeAttr('required');

        } else if (selectedType === '2') {
            $('#normal_day_options').hide();
            $('#day_category').removeAttr('required');
            $('#special_day_options').show();
            $('#date').attr('required', 'required');

        }
    });

  });

</script>
@endsection