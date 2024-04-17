@extends('layouts.simple.master')
@section('title', 'Vicar Details')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Vicar Details Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Vicar Details Form</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Details</h5>
                        <span>This Vicar details form collects information about Vicars and Ass.Vicars.</span>
                    </div>

                     @if($errors->any())
                        <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                     @endif
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="{{route('admin.vicar.store')}}" method="Post"
                        enctype="multipart/form-data">
                        	@csrf
                            <div class="row g-3 mb-3">

                                <div class="col-md-2">
                                    <label class="form-label">Title</label>
                                      <select class="form-control" name="title">
                                        <option value="">--Select--</option>
                                          @foreach($titles as $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                          @endforeach
                                      </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">Name</label>
                                    <input class="form-control" id="validationCustom01" type="text" 
                                    value="{{ old('name') }}" required="" name='name'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="validationCustom02">Family Name</label>
                                    <input class="form-control" id="validationCustom02" type="text" value="{{ old('family_name') }}"  required="" name='family_name'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                 <div class="col-md-3">
                                    <label class="form-label" for="validationCustom02">Date of birth</label>
                                    <input class="form-control" id="validationCustom02" type="date" value="{{ old('dob') }}"  required="" name='dob'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Designation</label>
                                    <select class="form-control" name="designation" required>
                                    <option value="">--Select--</option>
                                    <option value="1">Vicar</option>
                                    <option value="2">Asst.Vicar</option>
                                  </select>  
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Date of Joining</label>
                                    <input class="form-control" id="validationCustom02" type="date" value="{{ old('date_of_joining') }}"  required="" name='date_of_joining'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Date of relieving</label>
                                    <input class="form-control" id="validationCustom02" type="date" value="{{ old('date_of_relieving') }}"  name='date_of_relieving'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom03">Email</label>
                                    <input class="form-control" id="validationCustom03" type="email" 
                                        required="" name="email" value="{{ old('email') }}">
                                    <div class="invalid-feedback">Please provide a valid email.</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="validationCustom03">mobile</label>
                                    <input class="form-control" id="validationCustom03" type="text" 
                                     name="mobile" value="{{ old('mobile') }}">
                                    <div class="invalid-feedback">Please provide a valid mobile.</div>
                                </div>
                                 <div class="col-md-3">
                                    <label class="form-label" for="validationCustom03">Image</label>
                                      <label class="form-label" for="validationCustom03">Image</label>
                                      <input class="form-control" type="file"  name="image" id="ImageFile">
                                    <div class="invalid-feedback">Please provide a valid Image.</div>
                                </div>
                                 <div class="col-md-2">
                                    <img class="img-fluid for-light" id="ImagePreview" style="max-width: 100% !important;">
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Save</button>
                            <a class="btn btn-primary" onclick="window.location='{{ route('admin.vicar.list') }}'">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection