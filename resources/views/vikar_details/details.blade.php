@extends('layouts.simple.master')
@section('title', 'Vikars')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
    <h3>Vikars Details</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Family</li>
    <li class="breadcrumb-item active">Vikars Details</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div>
            <div class="row product-page-main p-0">
                <div class="col-xxl-5 box-col-6 order-xxl-0 order-1">
                    <div class="card">
                    @if($VikarDetail)
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
                                        <h3>{{$VikarDetail->name}}</h3>
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
                                        Edit Vikar Details
                                    </a>

                                </div>

                                <hr>
                                <p>Family Name : {{$VikarDetail->family_name}}</p>
                                <hr>
                                <div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="product-page-width" style="border-collapse: separate;border-spacing: 10px;">
                                                <tbody>
                                                    <tr>
                                                        <td> <b>Date of Birth</b></td>
                                                        <td> <b>&nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VikarDetail->dob}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Designation  </b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VikarDetail->designation}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td> <b>Date og Joining  </b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VikarDetail->date_of_joining}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Date og Relieving  </b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VikarDetail->date_of_relieving}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Email</b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VikarDetail->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Mobile</b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VikarDetail->mobile}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="{{asset($VikarDetail->photo)}}" width="100%">
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



            @if($VikarDetail)

            <div class="modal fade" id="EditFamilyModal" tabindex="-1" role="dialog" aria-labelledby="EditFamilyModalArea" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Family Details</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="needs-validation" novalidate="" action="{{route('admin.vikar.update',['id'=>$VikarDetail->id])}}" method="Post"  enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom01">Name</label>
                                        <input class="form-control" id="validationCustom01" type="text" 
                                        value="{{$VikarDetail['name'] }}" required="" name='name'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Family Name</label>
                                        <input class="form-control" id="validationCustom02" type="text" value="{{$VikarDetail['family_name'] }}"  required="" name='family_name'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Date of birth</label>
                                        <input class="form-control" id="validationCustom02" type="date" value="{{$VikarDetail['dob'] }}"  required="" name='dob'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Designation</label>
                                        <select class="form-control" name="designation" required>
                                            <option value="">--Select--</option>
                                            <option value="1" {{ $VikarDetail->designation === 'Vikar' ? 'selected' :'' }}>Vikar</option>
                                            <option value="2" {{ $VikarDetail->designation === 'Asst.Vikar' ? 'selected' :'' }}>Asst.Vikar</option>
                                        </select>  
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Date of Joining</label>
                                        <input class="form-control" id="validationCustom02" type="date" value="{{$VikarDetail['date_of_joining'] }}"  required="" name='date_of_joining'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Date of relieving</label>
                                        <input class="form-control" id="validationCustom02" type="date" value="{{$VikarDetail['date_of_relieving'] }}" name='date_of_relieving'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom03">Email</label>
                                        <input class="form-control" id="validationCustom03" type="email" 
                                        required="" name="email" value="{{$VikarDetail['email'] }}">
                                        <div class="invalid-feedback">Please provide a valid adddress.</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom03">mobile</label>
                                        <input class="form-control" id="validationCustom03" type="text" 
                                        name="mobile"value="{{$VikarDetail['mobile'] }}">
                                        <div class="invalid-feedback">Please provide a valid address.</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom03">Image</label>
                                        <label class="form-label" for="validationCustom03">Image</label>
                                        <input class="form-control" type="file"  name="image">
                                        <div class="invalid-feedback">Please provide a valid address.</div>
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