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
   <li class="breadcrumb-item">News/Announcement</li>
   <li class="breadcrumb-item active">News/Announcement Details</li>
@endsection

@section('content')
   <div class="container-fluid">
      <div>
         <div class="row product-page-main p-0">
            <div class="col-xxl-5 box-col-6 order-xxl-0 order-1">
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
                              <p class="p_l_5">
                                 <b>
                                    {{$news['body']}}
                                 </b>
                              </p>
                           </div>
                           <div class="col-md-4">
                              <img src="{{asset($news['image'])}}" width="100%">
                           </div>
                        </div>
                     </div>


                     <div class="modal fade" id="EditFamilyModal" tabindex="-1" role="dialog" aria-labelledby="EditFamilyModalArea" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">Family Details</h5>
                                 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form class="needs-validation" novalidate="" action="{{route('admin.news_announcement.update',['id'=>$news->id])}}" method="Post" enctype="multipart/form-data">
                                 <div class="modal-body">
                                    @csrf
                                    <div class="row g-3 mb-3">
                                       <div class="col-md-4">
                                          <label class="form-label" for="validationCustom04">Type</label>
                                          <select class="form-select" id="validationCustom04" name="type">
                                             <option value="">Choose...</option>
                                             <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>
                                             Trustee</option>
                                             <option value="2" {{ old('type') == '1' ? 'selected' : '' }}>Secretary</option>
                                          </select>
                                          <div class="invalid-feedback">Please select a valid type.</div>
                                       </div>

                                       <div class="col-md-8">
                                          <label class="form-label" for="validationCustom01">Heading</label>
                                          <input class="form-control" id="validationCustom01" type="text" 
                                          value="{{ $news['heading'] }}" required="" name='heading'>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>

                                    </div>
                                    <div class="row g-3">

                                       <div class="col-md-8">
                                          <label class="form-label" for="validationCustom03">Post Office</label>
                                          <textarea class="form-control" id="body" name="body" rows="8" cols="50" required>{{$news['body']}}</textarea><br>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>
                                       <div class="col-md-4 mb-3">
                                          <label class="form-label" for="validationCustom05">Image</label>
                                          <input class="form-control" id="validationCustom05" type="file" 
                                          name="image" value="{{ old('image') }}">
                                          <div class="invalid-feedback">Please provide a valid zip.</div>
                                       </div>


                                    </div>

                                 </div>
                                 <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.news_announcement.list') }}'">Close</button>
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
@endsection

@section('script')
<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/js/rating/jquery.barrating.js')}}"></script>
<script src="{{asset('assets/js/rating/rating-script.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/ecommerce.js')}}"></script>
<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection