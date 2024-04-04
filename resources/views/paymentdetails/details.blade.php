@extends('layouts.simple.master')
@section('title', 'Payment Details')

@section('css')

@endsection

@section('style')
   <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
   <h3>Payment Details</h3>
@endsection

@section('breadcrumb-items')
   <li class="breadcrumb-item">Payment Details</li>
@endsection

@section('content')
   <div class="container-fluid">
      <div>
         <div class="row product-page-main p-0">
            <div class="col-xxl-12 box-col-6 order-xxl-0 order-1">
               <div class="card">
                  @if($PaymentDetail)
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
                                 {{$PaymentDetail['purpose']}}
                              </div>
                              <ul class="product-color">
                                 <li class="bg-primary"></li>
                                 <li class="bg-secondary"></li>
                                 <li class="bg-success"></li>
                                 <li class="bg-info"></li>
                                 <li class="bg-warning"></li>
                              </ul>
                               <div class="">
                                 Date Updated : {{\Carbon\Carbon::parse($PaymentDetail['created_at'])->format('d-m-Y')}}
                              </div>

                           </div>
                           <div class="col-md-3">         
                              <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditPaymentDetailsModal">
                                 Edit Notification
                              </a>

                           </div>
                        </div>
                        <hr>
                        <div class="row">
                           <div class="col-md-8">
                              <p class="p_l_5">
                                 <b>
                                    {{$PaymentDetail['member']}}
                                 </b>
                              </p>
                           </div>
                           <div class="col-md-8">
                              <p class="p_l_5">
                                 <b>
                                    {{$PaymentDetail['date']}}
                                 </b>
                              </p>
                           </div>
                           <div class="col-md-8">
                              <p class="p_l_5">
                                 <b>
                                    {{$PaymentDetail['amount']}}
                                 </b>
                              </p>
                           </div>
                          
                        </div>
                     </div>


                     <div class="modal fade" id="EditPaymentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="EditFamilyModalArea" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">Payment Details</h5>
                                 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form class="needs-validation" novalidate="" action="{{route('admin.paymentdetails.update',['id'=>$PaymentDetail->id])}}" method="Post" enctype="multipart/form-data">
                                 <div class="modal-body">
                                    @csrf
                                    <div class="row g-3 mb-3">
                                       <div class="col-md-6">
                                          <label class="form-label" for="validationCustom04">Member</label>
                                          <select class="js-data-example-ajax form-select" id="member_id" name="member_id" required>
                                                 <option value="{{ $PaymentDetail['member_id'] }}" selected>{{ $PaymentDetail['member'] }}</option>

                                          </select>
                                          <div class="invalid-feedback">Please select a valid type.</div>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="form-label" for="validationCustom01">Purpose</label>
                                          <input class="form-control" id="validationCustom01" type="text" 
                                          value="{{$PaymentDetail['purpose'] }}" required="" name='purpose'>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>
                                    </div>
                                    <div class="row g-3">
                                       <div class="col-md-6">
                                          <label class="form-label" for="validationCustom01">Date</label>
                                          <input class="form-control" id="validationCustom01" type="date" 
                                          value="{{$PaymentDetail['date']}}" required="" name='date'>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="form-label" for="validationCustom01">Amount</label>
                                          <input class="form-control" id="validationCustom01" type="text" 
                                          value="{{$PaymentDetail['amount']}}" required="" name='amount'>
                                          <div class="valid-feedback">Looks good!</div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.paymentdetails.list') }}'">Close</button>
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
  $('#member_id').select2({
      placeholder: "Select member",
      ajax: {

          url: "<?= url('get_family_members_list') ?>",
          dataType: 'json',
          method: 'post',
          delay: 250,

           data: function(data) {
              return {
                  _token    : "<?= csrf_token() ?>",
                  search_tag: data.term,
              };
          },
          processResults: function(data, params) {
              params.page = params.page || 1;
              return {
                  results: data.results,
                  pagination: { more: (params.page * 10) < data.total_count }
              };
          },
          cache: true
      }
  });

  

</script>
@endsection