@extends('layouts.simple.master')
@section('title', 'Notifications')

@section('css')

@endsection

@section('style')
   <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
   <h3>Notifications</h3>
@endsection

@section('breadcrumb-items')
   <li class="breadcrumb-item">NNotifications</li>
   <li class="breadcrumb-item active">News/Announcement Details</li>
@endsection

@section('content')
   <div class="container-fluid">
      <div>
         <div class="row product-page-main p-0">
            <div class="col-xxl-5 box-col-6 order-xxl-0 order-1">
               <div class="card">
                  @if($Notification)
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
                                 <h3></h3>
                              </div>
                              <div class="product-price">
                                 {{$Notification['title']}}
                              </div>
                              <ul class="product-color">
                                 <li class="bg-primary"></li>
                                 <li class="bg-secondary"></li>
                                 <li class="bg-success"></li>
                                 <li class="bg-info"></li>
                                 <li class="bg-warning"></li>
                              </ul>
                               <div class="">
                                 Date Updated : {{\Carbon\Carbon::parse($Notification['created_at'])->format('d-m-Y')}}
                              </div>

                           </div>
                           <div class="col-md-3">         
                              <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditFamilyModal">
                                 Edit Notification
                              </a>

                           </div>
                        </div>
                        <hr>
                        <div class="row">
                           <div class="col-md-8">
                              <p class="p_l_5">Type : 
                                 <b>
                                    {{$Notification['type']}}
                                 </b>
                              </p>
                           </div><br>
                           @if($Notification['group_org_id'] != null)
                           <div class="col-md-8">
                              <p class="p_l_5">Group/Organization : 
                                 <b>
                                    {{$Notification['group_organization_name']}}
                                 </b>
                              </p>
                           </div><br>
                           @endif
                           <br>
                           <div class="col-md-8">
                              <p class="p_l_5">
                                 <b>
                                    {{$Notification['content']}}
                                 </b>
                              </p>
                           </div>
                          
                        </div>
                     </div>


                     <div class="modal fade" id="EditFamilyModal" tabindex="-1" role="dialog" aria-labelledby="EditFamilyModalArea" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">Notifications Details</h5>
                                 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form class="needs-validation" novalidate="" action="{{route('admin.notification.update',['id'=>$Notification->id])}}" method="Post" enctype="multipart/form-data">
                                 <div class="modal-body">
                                    @csrf
                                    <div class="row g-3 mb-3">
                                      <div class="col-md-5">
                                          <label class="form-label" for="validationCustom01">title</label>
                                          <input class="form-control" id="validationCustom01" type="text" 
                                          value="{{$Notification['title']}}" required="" name='title'>
                                          <div class="valid-feedback">Looks good!</div>
                                      </div>
                                      <div class="col-md-3">
                                          <label class="form-label" for="validationCustom04">Type</label>
                                          <select class="form-select" id="type"  name="type">
                                             <option value="">Select group/org</option>
                                             @foreach($type as $key=>$value)
                                                @if($value==$Notification['type'])
                                                   <option value="{{$key}}" selected>{{$value}}</option>
                                                @else
                                                   <option value="{{$key}}">{{$value}}</option>
                                                @endif
                                             @endforeach
                                          </select>
                                          <div class="invalid-feedback">Please select a valid type.</div>
                                       </div>

                                       <div class="col-md-4" id="group_org_div">
                                          <label class="form-label" for="validationCustom04">Group/Org.</label>
                                              <select class="js-data-example-ajax form-selec" id="group_org_id" name="group_org_id"></select>
                                            
                                          <div class="invalid-feedback">Please select a valid type.</div>
                                       </div>

                                     
                                  </div>
                                  <div class="row g-3">
                                      
                                       <div class="col-md-12">
                                          <label class="form-label" for="validationCustom03">Content</label>
                                          <textarea class="form-control" id="content" name="content" rows="6" cols="50" required>{{$Notification['content']}}</textarea><br>
                                          <div class="valid-feedback">Looks good!</div>
                                      </div>
                                      
                                      
                                     
                                  </div>

                                 </div>
                                 <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.notification.list') }}'">Close</button>
                                    <button class="btn btn-success" type="submit">Update</button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>

                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection

@section('script')
<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/js/rating/jquery.barrating.js')}}"></script>
<script src="{{asset('assets/js/rating/rating-script.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/ecommerce.js')}}"></script>
<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
<script type="text/javascript">
     $(document).ready(function(){

         type =  $('#type').val();
         if(type==3 || type == '4'){
            $('#group_org_div').show();
            fillgroup(type)
         }else{
            $('#group_org_div').hide();
         }

         $('#type').change(function(){
             var selectedValue = $(this).val();
             if(selectedValue == '3' || selectedValue == '4') {
                 $('#group_org_div').show();
             } else {
                 $('#group_org_div').hide();
             }
         });

         $('#group_org_id').select2({
             placeholder: "Select group/org",
             ajax: {

                 url: "<?= url('get_group_org_list') ?>",
                 dataType: 'json',
                 method: 'post',
                 delay: 250,

                  data: function(data) {
                     return {
                         _token    : "<?= csrf_token() ?>",
                         search_tag: data.term,
                            type: $('#type').val(),
                     };
                 },
                 processResults: function(data, params) {
                     params.page = params.page || 1;
                     return {
                         results: data.results,
                         pagination: { more: (params.page * 30) < data.total_count }
                     };
                 },
                 cache: true
             }
         });


         function fillgroup(type) {
              $.ajax({
                  url: "<?= url('get_group_org_list') ?>",
                  type: 'POST',
                  dataType: 'json',
                  data: {
                      _token: "<?= csrf_token() ?>",
                      type: type,
                      news_id:'<?php echo $Notification->id ?>',
                  },
                  success: function(response) {
                     
                     $('#group_org_id').html('').append(response.results);

                  }
              });
          }
     });
</script>
@endsection