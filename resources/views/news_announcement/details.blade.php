@extends('layouts.simple.master')
@section('title', 'News/Announcement')

@section('css')

@endsection

@section('style')
   <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
   <h3>News/Announcement Details</h3>
@endsection

@section('breadcrumb-items')
   <li class="breadcrumb-item">News/Announcement Details</li>
@endsection

@section('content')
   <div class="container-fluid">
      <div>
         <div class="row product-page-main p-0">
            <div class="col-xxl-12 box-col-6 order-xxl-0 order-1">
               <div class="card">
                  @if($news)
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
                                 Title : {{$news['heading']}}
                              </div>
                              <ul class="product-color">
                                 <li class="bg-primary"></li>
                                 <li class="bg-secondary"></li>
                                 <li class="bg-success"></li>
                                 <li class="bg-info"></li>
                                 <li class="bg-warning"></li>
                              </ul>
                               <div class="">
                                 Date Updated : {{\Carbon\Carbon::parse($news['created_at'])->format('d-m-Y')}}
                              </div>

                           </div>
                           <div class="col-md-3">         
                              <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditFamilyModal">
                                 Edit News/Announcement
                              </a>

                           </div>
                        </div>
                        <hr>
                        <div class="row">
                           <div class="col-md-8">
                              <p class="p_l_5">Type : 
                                 <b>
                                    {{$news['type']}}
                                 </b>
                              </p>
                           </div><br>
                           @if($news['group_org_id'] != null)
                           <div class="col-md-8">
                              <p class="p_l_5">Group/Organization : 
                                 <b>
                                    {{$news['group_organization_name']}}
                                 </b>
                              </p>
                           </div><br>
                           @endif
                           <br>

                           <div class="col-md-8">
                              <p class="p_l_5">Description:
                                 <b>
                                    {{$news['body']}}
                                 </b>
                              </p>
                           </div>
                           <div class="col-md-8">
                              <p class="p_l_5">Media LInk : 
                                 <b>
                                  @if($news['link'])  
                                       <a href="{{$news['link']}}" target="_blank">click here</a>
                                  @endif  
                                 </b>
                              </p>
                           </div><br>
                           <div class="col-md-4">
                              @if($news->image) 
                                  <img src="{{asset($news->image)}} " width="100%">
                              @endif
                           </div>
                        </div>
                     </div>


                     <div class="modal fade" id="EditFamilyModal" tabindex="-1" role="dialog" aria-labelledby="EditFamilyModalArea" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">News/Announcement Edit Form</h5>
                                 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form class="needs-validation" novalidate="" action="{{route('admin.news_announcement.update',['id'=>$news->id])}}" method="Post" enctype="multipart/form-data">
                                 <div class="modal-body">
                                    @csrf
                                    <div class="row g-3 mb-3">
                                       <div class="col-md-5">
                                          <label class="form-label" for="validationCustom01">Heading</label>
                                          <input class="form-control" id="validationCustom01" type="text" 
                                          value="{{ $news['heading'] }}" required="" name='heading'>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>
                                       <div class="col-md-3">
                                          <label class="form-label" for="validationCustom04">Type</label>
                                          <select class="form-select" id="type"  name="type">
                                             <option value="">Select group/org</option>
                                             @foreach($type as $key=>$value)
                                                @if($value==$news['type'])
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

                                       <div class="col-md-8">
                                          <label class="form-label" for="validationCustom03">Description</label>
                                          <textarea class="form-control" id="body" name="body" rows="8" cols="50" required>{{$news['body']}}</textarea><br>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>
                                       <div class="col-md-4 mb-3">
                                          <div class="row">
                                             <div style="height: 50px;">
                                        </div>
                                                <label class="form-label" for="validationCustom05">Image
                                                Media Link</label>
                                                <input class="form-control" id="validationCustom05" type="text" name="link" value="{{$news['link']}}">
                                                <div class="invalid-feedback">Please provide a valid image.</div>
                                          </div>
                                          <div class="row">
                                             <div class="row g-3">
                                              @if($news['image'])

                                                     <!--  <div class="col-md-4 mb-3" id="OldImage">
                                                          <img class="img-fluid for-light" src="{{ asset($news->image) }}" alt="" style="max-width:100px !important;">
                                                      </div> -->
                                              @endif
                                              <!-- <div style="height: 55px;">
                                                   <div class="col-md-4 mb-3" style="width:150px">
                                                       <img class="img-fluid for-light" id="ImagePreview" style="max-width: 100px !important;">
                                                    </div>
                                              </div> -->
                                             <label class="form-label" for="validationCustom05">Image
                                             <span style="color:#95937f;font-size: 12px;">(400px W X 300px H)</span>
                                             </label>
                                             <input class="form-control" id="ImageFile" type="file" 
                                             name="image" value="{{ old('image') }}">
                                             <div class="invalid-feedback">Please provide a valid image.</div>
                                          </div>
                                       </div>


                                    </div>

                                 </div>
                                 <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.news_announcement.list') }}'">Close</button>
                                    @if($news->image)
                                        <a class="btn btn-danger" id="deleteImage" table_id ="{{$news->id}}">Delete Image</a>
                                    @endif
                                    <button class="btn btn-success" type="submit">Update changes</button>
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
                      news_id:'<?php echo $news->id ?>',
                  },
                  success: function(response) {
                     
                     $('#group_org_id').html('').append(response.results);

                  }
              });
          }
         $('#deleteImage').click(function() {

             var table_id = $(this).attr('table_id');
             var type = 'news';
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
     });
</script>
@endsection