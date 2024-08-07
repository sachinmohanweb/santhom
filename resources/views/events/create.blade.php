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
    <li class="breadcrumb-item">Event Form</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Details</h5>
                        <span>This event form collects essential information about Event in our church.
                        </span>
                    </div>

                     @if($errors->any())
                        <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                     @endif
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="{{route('admin.event.store')}}" method="Post" enctype="multipart/form-data">
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
                                    <label class="form-label" for="validationCustom02">Time </label>

                                    <div class="input-group clockpicker">
                                    <input class="form-control" type="text" value="{{ old('time_value') }}" data-bs-original-title="" name="time_value" required  title="hh:mm:ss">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                                   
                                    <div class="invalid-feedback">Enter a valid time as HH:MM AM/PM</div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">Venue</label>
                                    <input class="form-control" id="validationCustom02" type="text" value="{{ old('venue') }}" name='venue'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                 <div class="col-md-8">
                                    <label class="form-label" for="validationCustom02">Media Link</label>
                                    <input class="form-control" id="validationCustom02" type="text" value="{{ old('link') }}" name='link'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                
                            </div>
                            <div class="row g-3">
                                
                                 <div class="col-md-8">
                                    <label class="form-label" for="validationCustom04">Details</label>
                                     <textarea class="form-control" id="details" name="details" rows="7" cols="50" ></textarea><br>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">

                                    <label class="form-label" for="validationCustom05" style="margin-top: 20px;">First Image
                                    <span style="color:#95937f;font-size: 12px;">(400px W X 300px H)</span>
                                    </label>
                                    <input class="form-control" type="file" 
                                         name="image" value="{{ old('image') }}" id="ImageFile">
                                    <div class="invalid-feedback">Please provide a valid zip.</div>

                                    <label class="form-label" for="validationCustom05" style="margin-top: 30px;">Second Image
                                    <span style="color:#95937f;font-size: 12px;">(400px W X 300px H)</span>
                                    </label>
                                    <input class="form-control" type="file" 
                                         name="image2" value="{{ old('image2') }}" id="ImageFile">
                                    <div class="invalid-feedback">Please provide a valid zip.</div>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Save</button>
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