@extends('layouts.simple.master')
@section('title', 'Vicar message')

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
    <h3>Vicar message Edit Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Vicar message Form</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="edit-profile">
      <div class="row">
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
       @if($message)   
      <form class="needs-validation" novalidate="" action="{{route('admin.vicarmessages.update')}}" 
          method="Post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id" value="{{$message->id}}">
        <div class="col-xl-11">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Vicar Message</h4>
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
                      <div class="col-md-6">
                        <label class="form-label">Subject</label>
                        <input class="form-control" placeholder="Subject" name="subject" value="{{$message['subject']}}" required >
                      </div>
                      <div class="col-md-4 pd_left_zero">

                        <label class="form-label">Image
                            <span style="color:#95937f;font-size: 12px;">(400px W X 300px H)</span>
                        </label>
                        <input class="form-control" type="file" name="image" id="ImageFile">
                      </div>
                      <div class="col-md-2 mb-3 mt-3" id="OldImage">
                         <img class="img-fluid for-light" src="{{ asset($message->image) }}" alt="" style="max-width: 50% !important;">
                      </div>
                      <div class="col-md-2 mb-3" style="width:150px">
                        <!-- <img class="img-fluid for-light" id="ImagePreview" style="max-width: 100% !important;"> -->
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
                <button type="submit" class="btn btn-primary">Update</button>
                 @if($message->image)
                    <a class="btn btn-danger" id="deleteImage" table_id ="{{$message->id}}">Delete Image</a>
                @endif
                <a class="btn btn-primary" href="{{route('admin.vicarmessages.list')}}">Cancel</a>

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
    <script type="text/javascript">
      $('#deleteImage').click(function() {

          var table_id = $(this).attr('table_id');
          var type = 'vicar_messages';
          var deleteUrl = '{{url("/deleteImage")}}'
          var csrfToken = '{{csrf_token()}}' ;

          $.ajax({
              url: deleteUrl,
              method: 'POST',
              contentType: 'application/json',
              data: JSON.stringify({ type: type, table_id: table_id,_token: csrfToken}),
              success: function(response) {
                location.reload();            
              },
              error: function(xhr, status, error) {
                location.reload();
              }
          });
      });
    </script>
@endsection