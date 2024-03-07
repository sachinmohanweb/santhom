@extends('layouts.simple.master')
@section('title', 'Create Event')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Event Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Forms</li>
    <li class="breadcrumb-item active">Event Form</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Custom styles</h5>
                        <span>This family form collects essential information about Event in our church.
                        </span>
                    </div>

                     @if($errors->any())
                        <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                     @endif
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="{{route('admin.event.store')}}" method="Post">
                        	@csrf
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">Event Name</label>
                                    <input class="form-control" id="validationCustom01" type="text" 
                                    value="{{ old('event_name') }}" required="" name='event_name'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Date </label>
                                    <input class="form-control" id="validationCustom02" type="date" value="{{ old('date') }}"  required="" name='date'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Venue</label>
                                    <input class="form-control" id="validationCustom02" type="text" value="{{ old('venue') }}" name='venue'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                
                            </div>
                            <div class="row g-3">
                                
                                 <div class="col-md-12">
                                    <label class="form-label" for="validationCustom04">Details</label>
                                     <textarea class="form-control" id="details" name="details" rows="5" cols="50" ></textarea><br>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                               
                            </div>

                            <button class="btn btn-primary" type="submit">Submit form</button>
                            <a class="btn btn-primary" onclick="window.location='{{ route('admin.event.list') }}'">Cancel</a>
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