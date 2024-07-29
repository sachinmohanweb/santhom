@extends('layouts.simple.master')
@section('title', 'Church Persons')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
    <h3>Church Personnel Details</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Church Personnel Details</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div>
            <div class="row product-page-main p-0">
                <div class="col-xxl-12 box-col-6 order-xxl-0 order-1">
                    <div class="card">
                    @if($VicarDetail)
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
                            <div class="row">
                                <div class="col-md-9">

                                    <div class="product-page-details">
                                        <h3>
                                            @if($VicarDetail->title)
                                                {{$VicarDetail->title}}.
                                            @endif
                                            {{$VicarDetail->name}}</h3>
                                    </div>

                                    <ul class="product-color">
                                        <li class="bg-primary"></li>
                                        <li class="bg-secondary"></li>
                                        <li class="bg-success"></li>
                                        <li class="bg-info"></li>
                                        <li class="bg-warning"></li>
                                    </ul>

                                </div>
                                <div class="col-md-3">         
                                    <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditFamilyModal">
                                        Edit Church Person  Details
                                    </a>

                                </div>

                                <hr>
                                <p>Family Name : {{$VicarDetail->family_name}}</p>
                                <hr>
                                <div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="product-page-width" style="border-collapse: separate;border-spacing: 10px;">
                                                <tbody>
                                                    <tr>
                                                        <td> <b>Date of Birth</b></td>
                                                        <td> <b>&nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->dob}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Designation  </b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->designation}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td> <b>Date og Joining  </b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->date_of_joining}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Date og Relieving  </b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->date_of_relieving}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Email</b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Mobile</b></td>
                                                        <td> <b> &nbsp;:&nbsp;</b></td>
                                                        <td class="txt-success">{{$VicarDetail->mobile}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            @if($VicarDetail->photo) 
                                                    <img src="{{asset($VicarDetail->photo)}} " width="100%">
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>



            @if($VicarDetail)

            <div class="modal fade" id="EditFamilyModal" tabindex="-1" role="dialog" aria-labelledby="EditFamilyModalArea" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 750px !important;"> 
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Church Personnel Details</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="needs-validation" novalidate="" action="{{route('admin.vicar.update',['id'=>$VicarDetail->id])}}" method="Post"  enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                                <div class="row g-3 mb-3">

                                    <div class="col-md-2">
                                        <label class="form-label">Title</label>
                                        <select class="form-control" name="title">
                                            <option value="">--Select--</option>
                                            @foreach($titles as $value)
                                                 @if($value==$VicarDetail->title)
                                                      <option value="{{$value}}" selected>{{$value}}</option>
                                                  @else
                                                      <option value="{{$value}}">{{$value}}</option>
                                                  @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom01">Name
                                        <span style="color:red">*</span></label>
                                        <input class="form-control" id="validationCustom01" type="text" 
                                        value="{{$VicarDetail['name'] }}" required="" name='name'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="validationCustom02">Family Name
                                        <span style="color:red">*</span></label>
                                        <input class="form-control" id="validationCustom02" type="text" value="{{$VicarDetail['family_name'] }}"  required="" name='family_name'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label" for="validationCustom02">Date of birth
                                        <span style="color:red">*</span></label>
                                        <input class="form-control" id="validationCustom02" type="date" value="{{$VicarDetail['dob'] }}"  required="" name='dob'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Designation
                                        <span style="color:red">*</span></label>
                                        <select class="form-control" name="designation" required>
                                            <option value="">--Select--</option>
                                            <option value="1" {{ $VicarDetail->designation === 'Vicar' ? 'selected' :'' }}>Vicar</option>
                                            <option value="2" {{ $VicarDetail->designation === 'Asst.Vicar' ? 'selected' :'' }}>Asst.Vicar</option>
                                            <option value="3" {{ $VicarDetail->designation === 'Sister' ? 'selected' :'' }}>Sister</option>
                                            <option value="4" {{ $VicarDetail->designation === 'Animator' ? 'selected' :'' }}>Animator</option>
                                            <option value="5" {{ $VicarDetail->designation === 'Deacon' ? 'selected' :'' }}>Deacon</option>
                                            <option value="6" {{ $VicarDetail->designation === 'Sacristan' ? 'selected' :'' }}>Sacristan</option>
                                        </select>  
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Date of Joining
                                        <span style="color:red">*</span></label>
                                        <input class="form-control" id="validationCustom02" type="date" value="{{$VicarDetail['date_of_joining'] }}"  required="" name='date_of_joining'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom02">Date of relieving</label>
                                        <input class="form-control" id="validationCustom02" type="date" value="{{$VicarDetail['date_of_relieving'] }}" name='date_of_relieving'>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="validationCustom03">Email
                                        <span style="color:red">*</span></label>
                                        <input class="form-control" id="validationCustom03" type="email" 
                                        required="" name="email" value="{{$VicarDetail['email'] }}">
                                        <div class="invalid-feedback">Please provide a valid email.</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="validationCustom03">mobile</label>
                                        <input class="form-control" id="validationCustom03" type="text" 
                                        name="mobile"value="{{$VicarDetail['mobile'] }}">
                                        <div class="invalid-feedback">Please provide a valid mobile.</div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label" for="validationCustom03">Image
                                        <span style="color:#95937f;font-size: 12px;">(400px W X 400px H)</span>
                                    </label>
                                        <input class="form-control" type="file"  name="image" id="ImageFile">
                                        <div class="invalid-feedback">Please provide a valid image.</div>
                                    </div>
                                    <!-- <div class="col-md-2" id="OldImage">
                                     <img class="img-fluid for-light" src="{{ asset($VicarDetail->photo) }}" alt="" style="max-width: 100% !important;">
                                  </div> -->
                                    <!-- <div class="col-md-2">
                                        <img class="img-fluid for-light" id="ImagePreview" style="max-width: 100% !important;">
                                    </div>
                                </div>  -->                
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.vicar.list') }}'">Close</button>
                                @if($VicarDetail->photo)
                                    <a class="btn btn-danger" id="deleteImage" table_id ="{{$VicarDetail->id}}">Delete Image</a>
                                @endif
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endif

        </div>
    </div>
    </div>

@endsection

@section('script')
<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/js/rating/jquery.barrating.js')}}"></script>
<script src="{{asset('assets/js/rating/rating-script.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/ecommerce.js')}}"></script>
<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
<script type="text/javascript">

  $('#deleteImage').click(function() {
      var table_id = $(this).attr('table_id');
      var type = 'vicars';
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