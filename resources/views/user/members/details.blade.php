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
<li class="breadcrumb-item">Family Members Details</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="edit-profile">
    <div class="row">

      @if(Session::has('success'))
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

       @if($familymember)
        <div class="col-xl-4">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Member Profile</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
                <div class="row">
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
                        <p>{{ $familymember->occupation ? $familymember->occupation : 'occupation-nil' }} </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3 col-md-12">
                    <label class="form-label" style="margin-bottom: 0px;">Family</label>
                    <a href="{{ route('admin.family.show_details', ['id' => $familymember->family_id]) }}">
                      <h6>{{ $familymember->family->family_name }} </h6>
                    </a>
                  </div>
                  <div class="mb-3 col-md-12">
                    <label class="form-label">Family head</label>
                  @if($familymember->FamilyHead() !== 'Null')
                      <a href="{{ route('admin.family.member.show_details', ['id' => $familymember->FamilyHead()->id]) }}">
                      <h6>{{$familymember->FamilyHead()->name}}<h6>
                  @else
                      <br><span style="color:red;font-size:12px">Not updated</span>
                  @endif
                    </a>
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Date of Birth</label>
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
                </div>
              </div>
          </div>
        </div>

        <div class="col-xl-8">
          <form class="card">
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
                    <label class="form-label">Date of Baptism</label>
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
                    <label class="form-label">Date of Marriage</label>
                    <p class="p_l_5"><b>{{ $familymember->date_of_marriage ? $familymember->date_of_marriage : 'N/A'}} </b> </p>
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
                      <label class="form-label">Alternate Mobile</label>
                      <p class="p_l_5"><b>{{ $familymember->alt_contact_no ? $familymember->alt_contact_no : 'N/A'}} </b> </p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    @if($familymember->date_of_death)
                    <label class="form-label">Date Of death</label>
                    <p class="p_l_5"><b>{{ $familymember->date_of_death }}</b> </p>
                    @endif
                  </div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="mb-3">
                    @if($familymember->MarriedTo())
                        <label class="form-label">Married To</label>
                        <p class="p_l_5"><b>
                            <a href="{{ route('admin.family.member.show_details', 
                            ['id' => $familymember->MarriedTo()->id]) }}">{{ $familymember->MarriedTo()->name}}
                            </a>
                        @if($familymember->remark == 1)
                            |
                            <a href="{{ route('admin.family.show_details', 
                            ['id' => $familymember->MarriedTo()->family_id]) }}">{{ $familymember->MarriedTo()->family_name}}
                            </a>
                        @endif
                            </b> 
                          </p>
                    @endif
                  </div>
                </div>
              <div class="card-footer text-end" style="padding:17px !important">
                @if($familymember->user_type==1)
                <a href="{{route('admin.family.member.edit', ['id' => $familymember->id])}}"><button class="btn btn-primary" type="button" >Edit Details</button></a>
                @endif
              </div>
              </div>
            </div>
              </div>
            </div>
          </form>
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