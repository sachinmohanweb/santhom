@extends('layouts.simple.master')
@section('title', 'Family Members')

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
    <h3>Family Member Edit Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Forms</li>
    <li class="breadcrumb-item active">Family Member Form</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="edit-profile">
      <div class="row">
       @if($message)   
      <form class="needs-validation" novalidate="" action="{{route('admin.vikarmessages.update')}}" 
          method="Post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id" value="{{$message->id}}">
        <div class="col-xl-11">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Vikar Message</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
              @if($errors->any())
                <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
             @endif
            <div class="card-body">
              <div class="row mb-2">
                <div class="profile-title">
                  <div class="media-body">
                    <div class="row">
                      <div class="col-md-8">
                        <label class="form-label">Subject</label>
                        <input class="form-control" placeholder="Subject" name="subject" value="{{$message['subject']}}" required >
                      </div>
                      <div class="col-md-4 pd_left_zero">

                        <label class="form-label">Image</label>
                        <input class="form-control" type="file" name="image">
                      </div>
                      <div class="col-md-12">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message_body" rows="8" cols="50" required>{{$message['message_body']}}</textarea><br>
                      </div>
                    </div>

                  </div>
                </div>
              </div> 
              <div class="form-footer">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
                <a class="btn btn-primary btn-block" href="{{route('admin.vikarmessages.list')}}">Cancel</a>

              </div>

            </div>
          </div>
        </div>
      </form>
       @endif

      </div>
    </div>
  </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection