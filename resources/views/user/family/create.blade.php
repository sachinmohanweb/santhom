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
                        <h5>Details</h5>
                        <span>This family form collects essential information about your family.
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
                                    <label class="form-label" for="validationCustom01">Family Code
                                        <span style="color:red">*</span></label>
                                    <input class="form-control" id="validationCustom01" type="text" 
                                    value="{{ old('family_code') }}" required="" name='family_code'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Family Name
                                        <span style="color:red">*</span></label>
                                    <input class="form-control" id="validationCustom02" type="text" value="{{ old('family_name') }}"  required="" name='family_name'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                 <div class="col-md-4">
                                    <label class="form-label" for="validationCustom04">Prayer Group
                                    <span style="color:red">*</span></label>
                                    <select class="form-select" id="validationCustom04" required="" name="prayer_group_id">
                                        <option value="">Choose...</option>
                                         @foreach($prayer_groups as $key=>$value)
                                        <option value="{{$value->id}}" {{ old('prayer_group_id') == '1' ? 'selected' : '' }}>{{$value->group_name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a valid prayer group.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom03">Address 1
                                    <span style="color:red">*</span></label>
                                    <input class="form-control" id="validationCustom03" type="text" 
                                        required="" name="address1" value="{{ old('address1') }}">
                                    <div class="invalid-feedback">Please provide a valid adddress.</div>
                                </div>
                                <div class="col-md-6">
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
                                    <label class="form-label" for="validationCustom05">Pincode
                                    <span style="color:red">*</span></label>
                                    <input class="form-control" id="validationCustom05" type="number" 
                                        required="" name="pincode" value="{{ old('pincode') }}" 
                                        oninput="javascript: if (this.value.length > 6) this.value = this.value.slice(0, 6);" min="100000" max="999999">
                                    <div class="invalid-feedback">Please provide a valid 6 digit pincode</div>
                                </div>
                                 <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom05">Map Location</label>
                                    <input class="form-control" id="validationCustom05" type="text" 
                                        name="map_location" value="{{ old('map_location') }}">
                                    <div class="invalid-feedback">Please provide a valid map location.</div>
                                </div>
                               
                            </div>

                            <button class="btn btn-primary" type="submit">Save</button>
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