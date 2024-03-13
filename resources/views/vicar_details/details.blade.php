@extends('layouts.simple.master')
@section('title', 'Vicars')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
    <h3>Vicars Details</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Family</li>
    <li class="breadcrumb-item active">Vicars Details</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div>
            <div class="row product-page-main p-0">
                <div class="col-xxl-5 box-col-6 order-xxl-0 order-1">
                    <div class="card">
                    @if($VicarDetail)
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
                                        <h3>{{$VicarDetail->name}}</h3>
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
                                        Edit Vicar Details
                                    </a>

                                </div>

                                <hr>
                                <p>Family Name : {{$VicarDetail->family_name}}</p>
                                <hr>
                                <div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="product-page-width" style="border-collapse: separate;border-spacing: 10px;">
                                                <tbody>
                                                    <tr>
                                                        <td> <b>Date of Birth</b></td>
                                                        <td> <b>&nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->dob}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Designation  </b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->designation}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td> <b>Date og Joining  </b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->date_of_joining}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Date og Relieving  </b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->date_of_relieving}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Email</b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Mobile</b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->mobile}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            @if($VicarDetail->photo) 
                                                    <img src="{{asset($VicarDetail->photo)}} " width="100%">
                                            @else
                                              <div style="height: 70px; width: 100px; background-color: #7366ff; color: white; line-height: 70px; font-size: 12px;">No Image</div>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>



            @if($VicarDetail)

            <div class="modal fade" id="EditFamilyModal" tabindex="-1" role="dialog" aria-labelledby="EditFamilyModalArea" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Vicars Details</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="needs-validation" novalidate="" action="{{route('admin.vicar.update',['id'=>$VicarDetail->id])}}" method="Post"  enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom01">Name</label>
                                        <input class="form-control" id="validationCustom01" type="text" 
                                        value="{{$VicarDetail['name'] }}" required="" name='name'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Family Name</label>
                                        <input class="form-control" id="validationCustom02" type="text" value="{{$VicarDetail['family_name'] }}"  required="" name='family_name'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Date of birth</label>
                                        <input class="form-control" id="validationCustom02" type="date" value="{{$VicarDetail['dob'] }}"  required="" name='dob'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Designation</label>
                                        <select class="form-control" name="designation" required>
                                            <option value="">--Select--</option>
                                            <option value="1" {{ $VicarDetail->designation === 'Vicar' ? 'selected' :'' }}>Vicar</option>
                                            <option value="2" {{ $VicarDetail->designation === 'Asst.Vicar' ? 'selected' :'' }}>Asst.Vicar</option>
                                        </select>  
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Date of Joining</label>
                                        <input class="form-control" id="validationCustom02" type="date" value="{{$VicarDetail['date_of_joining'] }}"  required="" name='date_of_joining'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Date of relieving</label>
                                        <input class="form-control" id="validationCustom02" type="date" value="{{$VicarDetail['date_of_relieving'] }}" name='date_of_relieving'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom03">Email</label>
                                        <input class="form-control" id="validationCustom03" type="email" 
                                        required="" name="email" value="{{$VicarDetail['email'] }}">
                                        <div class="invalid-feedback">Please provide a valid email.</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom03">mobile</label>
                                        <input class="form-control" id="validationCustom03" type="text" 
                                        name="mobile"value="{{$VicarDetail['mobile'] }}">
                                        <div class="invalid-feedback">Please provide a valid mobile.</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom03">Image</label>
                                        <label class="form-label" for="validationCustom03">Image</label>
                                        <input class="form-control" type="file"  name="image">
                                        <div class="invalid-feedback">Please provide a valid image.</div>
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