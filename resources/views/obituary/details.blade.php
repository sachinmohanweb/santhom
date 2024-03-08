@extends('layouts.simple.master')
@section('title', 'Obituaries')

@section('css')

@endsection

@section('style')
   <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
   <h3>Obituary Details</h3>
@endsection

@section('breadcrumb-items')
   <li class="breadcrumb-item">Obituary</li>
   <li class="breadcrumb-item active">Obituary Details</li>
@endsection

@section('content')
   <div class="container-fluid">
      <div>
         <div class="row product-page-main p-0">
            <div class="col-xxl-5 box-col-6 order-xxl-0 order-1">
               <div class="card">
                  @if($obituary)
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
                                 Member : {{$obituary['name_of_member']}}
                              </div>
                              <ul class="product-color">
                                 <li class="bg-primary"></li>
                                 <li class="bg-secondary"></li>
                                 <li class="bg-success"></li>
                                 <li class="bg-info"></li>
                                 <li class="bg-warning"></li>
                              </ul>
                               <div class="">
                                 Date of Death : {{\Carbon\Carbon::parse($obituary['date_of_death'])->format('d-m-Y')}}
                              </div>

                           </div>
                           <div class="col-md-3">         
                              <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditObituaryModal">
                                 Edit Obituary details
                              </a>

                           </div>
                        </div>
                        <hr>
                        <div class="row">
                           <div class="col-md-8">
                              <table class="product-page-width"  style="border-collapse: separate;border-spacing: 20px;">
                                <tbody>
                                  <tr>
                                    <td> <b>Display till  </b></td>
                                     <td> <b> &nbsp;:&nbsp;</b></td>
                                    <td class="txt-success">{{$obituary->display_till_date}}</td>
                                  </tr>
                                  <tr>
                                    <td> <b>Funeral Date  </b></td>
                                     <td> <b> &nbsp;:&nbsp;</b></td>
                                    <td>{{$obituary->funeral_date}}</td>
                                  </tr>
                                  <tr>
                                    <td> <b>Funeral Time  </b></td>
                                     <td> <b>&nbsp;:&nbsp;</b></td>
                                    <td>{{$obituary->funeral_time}}</td>
                                  </tr>
                                  <tr>
                                    <td> <b>Other Details  </b></td>
                                     <td> <b>&nbsp;:&nbsp;</b></td>
                                    <td>{{$obituary->notes}}</td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                           </div>
                           <div class="col-md-4">
                              <img src="{{asset($obituary['photo'])}}" width="100%">
                           </div>
                        </div>

                     </div>


                     <div class="modal fade" id="EditObituaryModal" tabindex="-1" role="dialog" aria-labelledby="EditFamilyModalArea" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">Obituary Details</h5>
                                 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form class="needs-validation" novalidate="" action="{{route('admin.obituary.update',['id'=>$obituary->id])}}" method="Post" enctype="multipart/form-data">
                                 <div class="modal-body">
                                 @csrf
                                       <div class="row g-3 mb-3">
                                       <div class="col-md-6">
                                          <label class="form-label" for="validationCustom04">Name of the member</label>
                                          <input class="form-control" id="validationCustom01" type="text" 
                                          value="{{$obituary->name_of_member}}" required name='name_of_member'>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>
                                       <div class="col-md-3">
                                          <label class="form-label" for="validationCustom04">Date of death</label>
                                          <input class="form-control" id="validationCustom01" type="date" 
                                          value="{{$obituary->date_of_death}}" required="" name='date_of_death'>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>
                                       <div class="col-md-3">
                                          <label class="form-label" for="validationCustom04">Display Till</label>
                                          <input class="form-control" id="validationCustom01" type="date" 
                                          value="{{$obituary->display_till_date}}" required name='display_till_date'>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>

                                    </div>
                                    <div class="row g-3 mb-3">
                                       <div class="col-md-4">
                                          <label class="form-label" for="validationCustom04">Date of Funeral</label>
                                          <input class="form-control" id="validationCustom01" type="date" 
                                          value="{{$obituary->funeral_date}}" name='funeral_date'>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>
                                       <div class="col-md-4">
                                          <label class="form-label" for="validationCustom04">Time of funeral </label>
                                          <input class="form-control" id="validationCustom01" type="time" 
                                          value="{{$obituary->funeral_time}}" name='funeral_time'>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>
                                       <div class="col-md-4 mb-3">
                                          <label class="form-label" for="validationCustom05">Image</label>
                                          <input class="form-control" id="validationCustom05" type="file" 
                                          name="photo" value="{{ old('photo') }}">
                                          <div class="invalid-feedback">Please provide a valid image.</div>
                                       </div>

                                    </div>
                                    <div class="row g-3">

                                       <div class="col-md-12">
                                          <label class="form-label" for="validationCustom03">Note</label>
                                          <textarea class="form-control" id="note" name="notes" rows="5" cols="50">{{$obituary->notes}}</textarea><br>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>


                                    </div>


                                 </div>
                                 <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.obituary.list') }}'">Close</button>
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