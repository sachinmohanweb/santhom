@extends('layouts.simple.master')
@section('title', 'Daily Schedules')

@section('css')
@endsection

@section('style')
<style type="text/css">
  .pd_left_zero{
    padding-left: 0px;
  }
  .pd_right_15{
    padding-right: 15px;
  }
</style>
@endsection

@section('breadcrumb-title')
    <h3>Daily Schedules Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Daily Schedules Form</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="edit-profile">
      <div class="row">
          
      <form class="needs-validation" novalidate="" action="{{route('admin.daily.schedules.store')}}" 
          method="Post" enctype="multipart/form-data">
          @csrf
        <div class="col-xl-11">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Daily Schedule Details</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
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
              @if($errors->any())
                <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
             @endif
              <div class="row mb-2">
                <div class="profile-title">
                  <div class="media-body">
                    <div class="row">
                      <div class="col-md-4" id="special_day_options">
                        <label class="form-label">Date<span style="color:red">*</span></label>
                        <input class="form-control" type="date" placeholder="date" name="date" value="{{ old('date') }}" required>
                      </div>
                      <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Time<span style="color:red">*</span></label>
                          <div class="input-group clockpicker">
                            <input class="form-control" type="text" value="{{ old('time') }}" data-bs-original-title="" name="time" required  title="hh:mm:ss">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                      </div>

                      <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Venue <span style="color:red">*</span></label>
                          <input class="form-control" id="validationCustom02" type="text" value="{{ old('venue') }}" name='venue' required>
                          <div class="valid-feedback">Looks good!</div>
                      </div>
                    </div><br>

                    <div class="row">
                       <div class="col-md-5">
                          <label class="form-label" for="validationCustom02">Title <span style="color:red">*</span></label>
                          <input class="form-control" id="validationCustom02" type="text" value="{{ old('title') }}" name='title' required>
                          <div class="valid-feedback">Looks good!</div>
                      </div>
                      <div class="col-md-7">
                          <label class="form-label" for="validationCustom02">Other details</label>
                          <input class="form-control" id="validationCustom02" type="text" value="{{ old('details') }}" name='details'>
                          <div class="valid-feedback">Looks good!</div>
                      </div>  
                    </div><br>

                  </div>
                </div> 
                <div class="form-footer">
                  <button class="btn btn-primary">Save</button>

                  <a class="btn btn-primary" onclick="window.location='{{ route('admin.daily.schedules.list') }}'">Cancel</a>
                </div>
              </div>
          </div>
          </div>
        </div>
      </form>
       

      </div>
    </div>
  </div>
@endsection

@section('script')
<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection