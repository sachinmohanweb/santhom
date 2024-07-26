<?php
use App\Models\Obituary;

?>
@extends('layouts.simple.master')
@section('title', 'Family')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style type="text/css">
  .button_class{

      margin-top: 10px;
      padding: 10px;
  }
</style>
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
              <div class="col-md-10">

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
                  @if($family->status==1)
                    <span class="btn btn-success">Approved</span>
                  @elseif($family->status==2)
                    <span class="btn btn-danger">Pending</span>
                  @else
                    <span class="btn btn-danger">Blocked</span>
                  @endif
                
              </div>
              <div class="col-md-2">  
                <div class="row">
                    <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditFamilyModal">Edit Family Details</a>
                </div> 
                <div class="row">
                    @if($family->status==3)
                        <a class="btn btn-success btn-hover-effect f-w-500 button_class block_unblock_family" 
                        data-family-id="{{$family->id}}" data-type="unblock">Unblock Family</a>
                    @else
                        <a class="btn btn-danger btn-hover-effect f-w-500 button_class block_unblock_family" 
                        data-family-id="{{$family->id}}" data-type="block">Block Family</a>
                    @endif
                    
                </div>             

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
                        <h5>{{$family->headOfFamily->name}}</h5>
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
                     <td>
                      @if($family->map_location)
                      <a href="{{$family->map_location}}" target="_blank">Show on map</a>
                      @endif
                    </td>
                   </tr>
                 </tbody>
               </table>
             </div>
             <hr>
             <div class="row">
               <div class="col-md-9">
                 <h6 class="product-title">Family Members</h6>
               </div>
               <div class="col-md-3">
                 <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('admin.family.member.create.family_id',['family_id' => $family['id']])}}" data-bs-original-title="" title="">Add Family Member</a>
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
                              <th scope="col">Status</th>
                              <th scope="col">Relation</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($family->members as $key=>$value)
                            <tr>
                              <th scope="row">{{$key+1}}</th>
                              <td>

                                  @if($value->date_of_death)
                                  <?php
                                    $member_obituary = Obituary::where('member_id',$value->id)->first();

                                  ?>
                                  @if($member_obituary)

                                      <a href="{{ route('admin.obituary.show_details', ['id' => $member_obituary->id]) }}"><h6>{{$value->name}}</h6></a>
                                  @else
                                      <h6>{{$value->name}}</h6>
                                  @endif
                                   -  <span style="color:green"> Died on - {{$value->date_of_death}}</span>

                                  @else
                                      <a href="{{ route('admin.family.member.show_details', ['id' => $value->id]) }}"><h6>{{$value->name}}</h6></a>
                                  @endif
                              </td>
                              <td>
                                @if($value->status==1)
                                  <span class="btn-success p-1">Approved</span>
                                @else
                                  <span class="btn-danger p-1">Pending</span>
                                @endif
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
                          <label class="form-label" for="validationCustom01">Family Code
                           <span style="color:red">*</span></label>
                          <input class="form-control" id="validationCustom01" type="text" 
                          value="{{$family->family_code}}" required="" name='family_code'>
                          <div class="valid-feedback">Looks good!</div>
                      </div>
                      <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Family Name
                           <span style="color:red">*</span></label>
                          <input class="form-control" id="validationCustom02" type="text" value="{{$family->family_name}}"  required="" name='family_name'>
                          <div class="valid-feedback">Looks good!</div>
                      </div>
                       <div class="col-md-4">
                          <label class="form-label" for="validationCustom04">Prayer Group
                           <span style="color:red">*</span></label>
                          <select class="form-select" id="validationCustom04" required="" name="prayer_group_id">
                             <option value="">Choose...</option>
                                 @foreach($prayer_groups as $key=>$value)
                                  @if( $value->id==$family->prayer_group_id)
                                    <option value="{{$value->id}}" selected>{{$value->group_name}}</option>
                                  @else
                                    <option value="{{$value->id}}" >{{$value->group_name}}</option>
                                  @endif
                                @endforeach
                          </select>
                          <div class="invalid-feedback">Please select a valid prayer group.</div>
                      </div>

                      <div class="col-md-6">
                          <label class="form-label" for="validationCustom03">Address 1
                           <span style="color:red">*</span></label>
                          <input class="form-control" id="validationCustom03" type="text" 
                              required="" name="address1" value="{{$family->address1}}">
                          <div class="invalid-feedback">Please provide a valid adddress.</div>
                      </div>
                      <div class="col-md-6">
                          <label class="form-label" for="validationCustom03">Address 2</label>
                          <input class="form-control" id="validationCustom03" type="text" 
                            name="address2" value="{{$family->address2}}">
                          <div class="invalid-feedback">Please provide a valid address.</div>
                      </div>
                  </div>
                  <div class="row g-3">
                       <div class="col-md-4 mb-3">
                          <label class="form-label" for="validationCustom05">Post Office</label>
                          <input class="form-control" id="validationCustom05" type="text" 
                            name="post_office" value="{{$family->post_office}}">
                          <div class="invalid-feedback">Please provide a valid Post office.</div>
                      </div>
                      <div class="col-md-4 mb-3">
                          <label class="form-label" for="validationCustom05">Pincode
                           <span style="color:red">*</span></label>
                          <input class="form-control" id="validationCustom05" type="number" 
                              required="" name="pincode" value="{{$family->pincode}}" oninput="javascript: if (this.value.length > 6) this.value = this.value.slice(0, 6);" min="100000" 
                              max="999999">
                          <div class="invalid-feedback">Please provide a valid 6 digit pincode.</div>
                      </div>
                       <div class="col-md-4 mb-3">
                          <label class="form-label" for="validationCustom05">Map Location</label>
                          <input class="form-control" id="validationCustom05" type="text" 
                            name="map_location" value="{{$family->map_location}}">
                          <div class="invalid-feedback">Please provide a valid Map Location.</div>
                      </div>
                     
                  </div>
                 
          </div>
          <div class="modal-footer">
             <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.family.list') }}'">Close</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>

  $(document).ready(function() {
      $('.block_unblock_family').click(function() {
          var familyId = $(this).data('family-id');
          var type = $(this).data('type');

          Swal.fire({
              title: 'Are you sure?',
              text: "You want to " +type+ " this family?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes,  ' +type+ '  it!'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '/block_unblock_family',
                      type: 'POST',
                      data: {
                          _token: '{{ csrf_token() }}',
                          family_id: familyId
                      },
                      success: function(response) {
                          Swal.fire(
                              '' +type+ '',
                              'Family has been ' +type+'ed.',
                              'success'
                          ).then(() => {
                              location.reload();
                          });
                      },
                      error: function(xhr, status, error) {
                          Swal.fire(
                              'Error!',
                              'An error occurred while '+type+' this family.',
                              'error'
                          );
                      }
                  });
              }
          });
      });
  });
</script>
@endsection