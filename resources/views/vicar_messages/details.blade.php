@extends('layouts.simple.master')
@section('title', 'Vicar Messages')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
  <style type="text/css">
    .p_l_5 {
      padding-left: 10px !important;
    }
  </style>
@endsection

@section('breadcrumb-title')
<h3>Vicar Message Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Family</li>
<li class="breadcrumb-item active">Vicar Message Details</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="edit-profile">
    <div class="row">

       @if($message)

        <div class="col-xl-12">
          <form class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Message Details</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-8 col-md-8">
                  <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <p class="p_l_5"><b>{{$message->subject}} </b> </p>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Message</label>
                    <p class="p_l_5"><b>{{$message->message_body}} </b> </p>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4">
                  <div class="mb-3">
                    <label class="form-label">Image </label>
                      <div class="mb-3">
                        <img src="{{asset($message->image)}} " width="100%">
                      </div>
                </div>                
              </div>
            </div>
              <div class="card-footer text-end" style="padding:17px !important">
                <a href="{{route('admin.vicarmessages.edit', ['id' => $message->id])}}"><button class="btn btn-primary" type="button" >Update Details</button></a>
              </div>
              </div>
            </div>
          </form>
        </div>
      @endif

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