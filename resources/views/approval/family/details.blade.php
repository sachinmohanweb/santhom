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
<li class="breadcrumb-item">Family Details</li>
@endsection

@section('content')
<div class="container-fluid">
   <div>
     <div class="row product-page-main p-0">
       <div class="col-xxl-12 box-col-6 order-xxl-0 order-1">
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

                  <form method="post" action="{{route('admin.family.approve')}}">
                      @csrf
                     <input type="hidden" name="family_id" value="{{$family->id}}">
                     <button class="purchase-btn btn btn-primary btn-hover-effect f-w-500" type="submit">Approve</button>
                  </form>        
                </a>



              </div>
            </div>

             <hr>
             <p>Prayer Group : {{$family->PrayerGroup->group_name}}</p>
             <hr>
             <div>
               <table class="product-page-width">
                 <tbody>
                   <tr>
                     <td> <b>Head Of The Family</b></td>
                     <td> <b>&nbsp;:&nbsp;</b></td>
                     <td>
                      @if($family->headOfFamily)
                        {{$family->headOfFamily->name}}
                      @else
                        nill
                      @endif
                     </td>
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
                     <td> <b>Post Office  </b></td>
                      <td> <b> &nbsp;:&nbsp;</b></td>
                     <td>{{$family->post_office}}</td>
                   </tr>
                   <tr>
                     <td> <b>Location  </b></td>
                      <td> <b> &nbsp;:&nbsp;</b></td>
                     <td>{{$family->map_location}}</td>
                   </tr>
                 </tbody>
               </table>
             </div>
             <hr>
             <div class="row">
               <div class="col-md-9">
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
                          @foreach($family->members as $key=>$value)
                            <tr>
                              <th scope="row">{{$key+1}}</th>
                              <td>
                                <a href="{{ route('admin.family.member.show_details', ['id' => $value->id]) }}">{{$value->name}}
                                </a>
                              </td>
                              <td>{{$value->relationship->relation_name}} </td>
                            </tr>
                          @endforeach  
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

@endsection

@section('script')
<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/js/rating/jquery.barrating.js')}}"></script>
<script src="{{asset('assets/js/rating/rating-script.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/ecommerce.js')}}"></script>
<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection