@extends('layouts.simple.master')
@section('title', 'Vikars')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Vikar Details Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Forms</li>
    <li class="breadcrumb-item active">Vikar Details Form</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Custom styles</h5>
                        <span>This family form collects essential information about your Vikars.</span>
                    </div>

                     @if($errors->any())
                        <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                     @endif
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="{{route('admin.vikar.store')}}" method="Post"
                        enctype="multipart/form-data">
                        	@csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">Name</label>
                                    <input class="form-control" id="validationCustom01" type="text" 
                                    value="{{ old('name') }}" required="" name='name'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Family Name</label>
                                    <input class="form-control" id="validationCustom02" type="text" value="{{ old('family_name') }}"  required="" name='family_name'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                 <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Date of birth</label>
                                    <input class="form-control" id="validationCustom02" type="date" value="{{ old('dob') }}"  required="" name='dob'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Designation</label>
                                    <select class="form-control" name="designation" required>
                                    <option value="">--Select--</option>
                                    <option value="1">Vikar</option>
                                    <option value="2">Asst.Vikar</option>
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
                                    <div class="invalid-feedback">Please provide a valid adddress.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom03">mobile</label>
                                    <input class="form-control" id="validationCustom03" type="text" 
                                     name="mobile" value="{{ old('mobile') }}">
                                    <div class="invalid-feedback">Please provide a valid address.</div>
                                </div>
                                 <div class="col-md-4">
                                    <label class="form-label" for="validationCustom03">Image</label>
                                      <label class="form-label" for="validationCustom03">Image</label>
                                      <input class="form-control" type="file"  name="image">
                                    <div class="invalid-feedback">Please provide a valid address.</div>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Submit form</button>
                            <a class="btn btn-primary" onclick="window.location='{{ route('admin.family.list') }}'">Cancel</a>
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