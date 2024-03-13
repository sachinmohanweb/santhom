@extends('layouts.simple.master')
@section('title', 'Family Members')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
  <style type="text/css">
    .p_l_5 {
      padding-left: 10px !important;
    }
  </style>
@endsection

@section('breadcrumb-title')
<h3>Family Members Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Family</li>
<li class="breadcrumb-item active">Family Members Details</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="edit-profile">
    <div class="row">

       @if($familymember)
        <div class="col-xl-4">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Member Profile</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                  <div class="profile-title">
                    <div class="media">      
                      @if($familymember->image) 
                        <img class="img-70 rounded-circle" alt="" src="{{ asset($familymember->image) }}">
                      @else

                      <?php
                          $nameWords = explode(' ', $familymember->name);
                          $nameLetters = '';

                          foreach ($nameWords as $word) {
                              $nameLetters .= substr($word, 0, 1);
                              if(strlen($nameLetters) >= 2) {
                                  break;
                              }
                          }

                          if(strlen($nameLetters) == 1) {
                              $nameLetters = substr($familymember->name, 0, 2);
                          }

                          $backgroundColors = ['#ff7f0e', '#2ca02c', '#1f77b4', '#d62728', '#9467bd'];
                          $backgroundColor = $backgroundColors[array_rand($backgroundColors)];

                        ?>
                         
                        <div class="img-70 rounded-circle text-center" style="height: 70px; width: 70px; background-color: #7366ff ; color: white; line-height: 70px; font-size: 24px;">{{$nameLetters}}</div>

                      @endif

                      <div class="media-body">
                        <h5 class="mb-1">{{ $familymember->name}}</h5>
                        <p>{{ $familymember->occupation ? $familymember->occupation : 'occupation-nill' }} </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Family</label>
                    <a href="{{ route('admin.family.show_details', ['id' => $familymember->family_id]) }}"><p><h6>{{ $familymember->family->family_name }} </h6></p></a>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Family head</label>
                    <p><h6>-- <h6></p>
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Date of birth</label>
                    <p><b>{{ $familymember->dob }}</b> </p>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Gender</label>
                    <p><b>{{ $familymember->gender }}</b> </p>
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Relation</label>
                    <p><b>{{ $familymember->relationship->relation_name }}</b> </p>
                  </div>
                   <div class="mb-3 col-md-6">
                    <label class="form-label">Marital Status</label>
                    @if($familymember->maritalstatus)
                    <p><b>{{ $familymember->maritalstatus->marital_status_name }}</b> </p>
                    @else
                    <p><b>Nill</b> </p>

                    @endif
                  </div>
                </div>
              </div>
          </div>
        </div>

        <div class="col-xl-8">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Other Details</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Name Title</label>
                    <p class="p_l_5"><b>{{$familymember->title ? $familymember->title : 'N/A' }} </b> </p>

                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Nickname </label>
                    <p class="p_l_5"><b>{{ $familymember->nickname ? $familymember->nickname : 'N/A' }}</b> </p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Date_of_baptism</label>
                    <p class="p_l_5"><b>{{ $familymember->date_of_baptism ? $familymember->date_of_baptism : 'N/A'}} </b> </p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Blood Group</label>
                    <p class="p_l_5"><b>{{ $familymember->bloodgroup ? $familymember->bloodgroup->blood_group_name : 'N/A'}} </b> </p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Head of the family</label>
                    <p class="p_l_5"><b>{{ $familymember->family ? $familymember->family->head_of_family : 'N/A'}} </b> </p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Date of marriage</label>
                    <p class="p_l_5"><b>{{ $familymember->dob ? $familymember->dob : 'N/A'}} </b> </p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Qualification</label>
                    <p class="p_l_5"><b>{{ $familymember->qualification ? $familymember->qualification : 'N/A'}} </b> </p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Occupation</label>
                    <p class="p_l_5"><b>{{ $familymember->occupation ? $familymember->occupation : 'N/A'}} </b> </p>
                    
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div>
                    <label class="form-label">Company name</label>
                    <p class="p_l_5"><b>{{ $familymember->company_name ? $familymember->company_name : 'N/A'}} </b> </p>
                    
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <p class="p_l_5"><b>{{ $familymember->email ? $familymember->email : 'N/A'}} </b> </p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Mobile</label>
                    <p class="p_l_5"><b>{{ $familymember->mobile ? $familymember->mobile : 'N/A'}} </b> </p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="mb-3">
                      <label class="form-label">Alternat Mobile</label>
                      <p class="p_l_5"><b>{{ $familymember->alt_contact_no ? $familymember->alt_contact_no : 'N/A'}} </b> </p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Date of death</label>
                    <p class="p_l_5"><b>{{ $familymember->date_of_death ? $familymember->date_of_death : 'N/A'}} </b> </p>
                  </div>
                </div>
              <div class="card-footer text-end" style="padding:17px !important">

                <form method="post" action="{{route('admin.family.member.approve')}}">
                      @csrf
                     <input type="hidden" name="member_id" value="{{$familymember->id}}">
                     <button class="purchase-btn btn btn-primary btn-hover-effect f-w-500" type="submit">Approve
                     </button>
                </form> 

              </div>
              </div>
            </div>
              </div>
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
@endsection