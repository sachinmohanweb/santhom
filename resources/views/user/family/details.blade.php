@extends('layouts.simple.master')
@section('title', 'Family')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Family Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Family</li>
<li class="breadcrumb-item active">Family Details</li>
@endsection

@section('content')
<div class="container-fluid">
   <div>
     <div class="row product-page-main p-0">
       <div class="col-xxl-5 box-col-6 order-xxl-0 order-1">
         <div class="card">
          @if($family)
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
                   <h3>{{$family->family_name}}</h3>
                 </div>
                 <div class="product-price">
                  Family Code : {{$family->family_code}}
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
                  Edit Family Details
                </a>

              </div>
            </div>

             <hr>
             <p>Prayer Group : {{$family->prayer_group}}</p>
             <hr>
             <div>
               <table class="product-page-width">
                 <tbody>
                   <tr>
                     <td> <b>Head Of The Family</b></td>
                     <td> <b>&nbsp;:&nbsp;</b></td>
                     <td>{{$family->head_of_family}}</td>
                   </tr>
                   <tr>
                     <td> <b>Email  </b></td>
                      <td> <b> &nbsp;:&nbsp;</b></td>
                     <td class="txt-success">{{$family->family_email}}</td>
                   </tr>
                   <tr>
                     <td> <b>Address  </b></td>
                      <td> <b> &nbsp;:&nbsp;</b></td>
                     <td>{{$family->address1}},{{$family->address2}}</td>
                   </tr>
                   <tr>
                     <td> <b>Pin Code  </b></td>
                      <td> <b>&nbsp;:&nbsp;</b></td>
                     <td>{{$family->pincode}}</td>
                   </tr>
                   <tr>
                     <td> <b>Location  </b></td>
                      <td> <b> &nbsp;:&nbsp;</b></td>
                     <td>{{$family->pincode}}</td>
                   </tr>
                 </tbody>
               </table>
             </div>
             <hr>
             <div class="row">
               <div class="col-md-4">
                 <h6 class="product-title">Family Members</h6>
               </div>
             </div>
             <div class="card-block row" style="margin: 10px;">
                    <div class="col-sm-8 col-lg-8 col-xl-8">
                      <div class="table-responsive">
                        <table class="table table-light">
                          <thead>
                            <tr>
                              <th scope="col">Id</th>
                              <th scope="col">Name</th>
                              <th scope="col">Relation</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">1</th>
                              <td>Web Development </td>
                              <td>Pixel@efo.com </td>
                            </tr>
                            <tr>
                              <th scope="row">1</th>
                              <td>Web Development </td>
                              <td>Pixel@efo.com </td>
                            </tr>
                            <tr>
                              <th scope="row">1</th>
                              <td>Web Development </td>
                              <td>Pixel@efo.com </td>
                            </tr>
                            <tr>
                              <th scope="row">1</th>
                              <td>Web Development </td>
                              <td>Pixel@efo.com </td>
                            </tr>
                            
                          </tbody>
                        </table>
                      </div>
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


@if($family)

 <div class="modal fade" id="EditFamilyModal" tabindex="-1" role="dialog" aria-labelledby="EditFamilyModalArea" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title">Family Details</h5>
             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="needs-validation" novalidate="" action="{{route('admin.family.update',['id'=>$family->id])}}" method="Post">
          <div class="modal-body">
                @csrf
                  <div class="row g-3 mb-3">
                      <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Family Code</label>
                          <input class="form-control" id="validationCustom01" type="text" 
                          value="{{$family->family_code}}" required="" name='family_code'>
                          <div class="valid-feedback">Looks good!</div>
                      </div>
                      <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Family Name</label>
                          <input class="form-control" id="validationCustom02" type="text" value="{{$family->family_name}}"  required="" name='family_name'>
                          <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Family Email</label>
                          <input class="form-control" id="validationCustom02" type="email" value="{{$family->family_email}}" required="" name='family_email'>
                          <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">Head of the Family</label>
                          <input class="form-control" id="validationCustom02" type="text" 
                          value="{{$family->head_of_family}}" required="" name='head_of_family'>
                          <div class="valid-feedback">Looks good!</div>
                      </div>
                       <div class="col-md-6">
                          <label class="form-label" for="validationCustom04">Prayer Group</label>
                          <select class="form-select" id="validationCustom04" required="" name="prayer_group">
                              <option >Choose...</option>
                              <option value="1" {{ old('prayer_group') == '1' ? 'selected' : '' }}>test prayer group</option>
                          </select>
                          <div class="invalid-feedback">Please select a valid prayer group.</div>
                      </div>
                  </div>
                  <div class="row g-3">
                      <div class="col-md-4">
                          <label class="form-label" for="validationCustom03">Address 1</label>
                          <input class="form-control" id="validationCustom03" type="text" 
                              required="" name="address1" value="{{$family->address1}}">
                          <div class="invalid-feedback">Please provide a valid adddress.</div>
                      </div>
                      <div class="col-md-4">
                          <label class="form-label" for="validationCustom03">Address 2</label>
                          <input class="form-control" id="validationCustom03" type="text" 
                              required="" name="address2" value="{{$family->address2}}">
                          <div class="invalid-feedback">Please provide a valid address.</div>
                      </div>
                      <div class="col-md-4 mb-3">
                          <label class="form-label" for="validationCustom05">Pincode</label>
                          <input class="form-control" id="validationCustom05" type="text" 
                              required="" name="pincode" value="{{$family->pincode}}">
                          <div class="invalid-feedback">Please provide a valid zip.</div>
                      </div>
                     
                  </div>
                 
          </div>
          <div class="modal-footer">
             <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.family.list') }}'">Close</button>
             <button class="btn btn-success" type="submit">Update changes</button>
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