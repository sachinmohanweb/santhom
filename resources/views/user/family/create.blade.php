@extends('layouts.simple.master')
@section('title', 'Family')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Family Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Forms</li>
    <li class="breadcrumb-item active">Family Form</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Custom styles</h5>
                        <span>This family form collects essential information about your family. By providing details such as yourfamily code and family email, we tailor our services to better accommodate your family members.
                        </span>
                    </div>

                     @if($errors->any())
                        <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                     @endif
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="{{route('admin.family.store')}}" method="Post">
                        	@csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">Family Code</label>
                                    <input class="form-control" id="validationCustom01" type="text" 
                                    value="{{ old('family_code') }}" required="" name='family_code'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Family Name</label>
                                    <input class="form-control" id="validationCustom02" type="text" value="{{ old('family_name') }}"  required="" name='family_name'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Family Email</label>
                                    <input class="form-control" id="validationCustom02" type="email" value="{{ old('family_email') }}" required="" name='family_email'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                 <div class="col-md-4">
                                    <label class="form-label" for="validationCustom04">Prayer Group</label>
                                    <select class="form-select" id="validationCustom04" required="" name="prayer_group_id">
                                        <option value="">Choose...</option>
                                         @foreach($prayer_groups as $key=>$value)
                                        <option value="{{$value->id}}" {{ old('prayer_group_id') == '1' ? 'selected' : '' }}>{{$value->group_name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a valid prayer group.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom03">Address 1</label>
                                    <input class="form-control" id="validationCustom03" type="text" 
                                        required="" name="address1" value="{{ old('address1') }}">
                                    <div class="invalid-feedback">Please provide a valid adddress.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom03">Address 2</label>
                                    <input class="form-control" id="validationCustom03" type="text" 
                                     name="address2" value="{{ old('address2') }}">
                                    <div class="invalid-feedback">Please provide a valid address.</div>
                                </div>
                            </div>
                            <div class="row g-3">
                                
                                 <div class="col-md-4">
                                    <label class="form-label" for="validationCustom03">Post Office</label>
                                    <input class="form-control" id="validationCustom03" type="text" 
                                     name="post_office" value="{{ old('post_office') }}">
                                    <div class="invalid-feedback">Please provide a valid post office.</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom05">Pincode</label>
                                    <input class="form-control" id="validationCustom05" type="text" 
                                        required="" name="pincode" value="{{ old('pincode') }}">
                                    <div class="invalid-feedback">Please provide a valid zip.</div>
                                </div>
                                 <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom05">Map Location</label>
                                    <input class="form-control" id="validationCustom05" type="text" 
                                        name="map_location" value="{{ old('map_location') }}">
                                    <div class="invalid-feedback">Please provide a valid map location.</div>
                                </div>
                               
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <div class="checkbox p-0">
                                        <input class="form-check-input" id="invalidCheck" type="checkbox" required=""
                                         name="agree" {{ old('agree') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="invalidCheck">Agree to terms and
                                            conditions</label>
                                    </div>
                                    <div class="invalid-feedback">You must agree before submitting.</div>
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