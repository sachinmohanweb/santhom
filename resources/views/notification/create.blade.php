@extends('layouts.simple.master')
@section('title', 'Notification')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Notification Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Forms</li>
    <li class="breadcrumb-item active">Notification Form</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Custom styles</h5>
                        <span>This form collects Notification details.
                        </span>
                    </div>

                     @if($errors->any())
                        <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                     @endif
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" 
                        action="{{route('admin.notification.store')}}" method="Post" enctype="multipart/form-data">
                        	@csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom01">title</label>
                                    <input class="form-control" id="validationCustom01" type="text" 
                                    value="{{ old('title') }}" required="" name='title'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom04">Type</label>
                                    <select class="form-select" id="validationCustom04" name="type">
                                        <option value="">Choose...</option>
                                        <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>
                                        Trustee</option>
                                        <option value="2" {{ old('type') == '1' ? 'selected' : '' }}>Secretary</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a valid type.</div>
                                </div>

                               
                            </div>
                            <div class="row g-3">
                                
                                 <div class="col-md-12">
                                    <label class="form-label" for="validationCustom03">Content</label>
                                    <textarea class="form-control" id="content" name="content" rows="6" cols="50" required></textarea><br>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                
                                
                               
                            </div>
                           
                            <button class="btn btn-primary" type="submit">Submit form</button>
                            <a class="btn btn-primary" onclick="window.location='{{ route('admin.news_announcement.list') }}'">Cancel</a>
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