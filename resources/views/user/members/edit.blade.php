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
  .select2-container .select2-selection--single {
      height: 40px!important;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 20px !important;
  }
  .error_div{
        padding-left: 20px !important;
        color: red !important;
  }
</style>
@endsection

@section('breadcrumb-title')
    <h3>Family Member Edit Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Family Member Form</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="edit-profile">
      <div class="row">
          
      <form class="needs-validation" novalidate="" action="{{route('admin.family.member.update')}}" 
          method="Post" enctype="multipart/form-data">
          <input type="hidden" name="id" value="{{$familymember->id}}">
          @csrf
        <div class="col-xl-11">
          <div class="card">
            <div class="card-header">
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
              <h4 class="card-title mb-0">Member Profile</h4>
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
                      <div class="col-md-2">
                        <label class="form-label">Title</label>
                        <select class="form-control" name="title">
                            <option value="">--Select--</option>
                              @foreach($titles as $value)
                                  @if($value==$familymember->title)
                                      <option value="{{$value}}" selected>{{$value}}</option>
                                  @else
                                      <option value="{{$value}}">{{$value}}</option>
                                  @endif
                              @endforeach
                          </select>
                      </div>
                      <div class="col-md-5 pd_left_zero">

                        <label class="form-label">Name<span style="color:red">*</span></label>
                        <input class="form-control" placeholder="Your Name" name="name" required
                        value="{{$familymember->name}}">
                      </div>
                      <div class="col-md-5 pd_left_zero">
                        <label class="form-label">Nickname</label>
                        <input class="form-control" placeholder="Your Nickname" name="nickname" 
                        value="{{$familymember->nickname}}" >
                      </div>
                    </div>

                  </div>
                </div>
              </div> 
              <div class="row">
                <div class="col-md-5">
                  <label class="form-label">Family <span style="color:red">*</span></label>
                  <select class="form-control" name="family_id" required>
                    <option value="">--Select--</option>
                      @foreach($familys as $key=>$value)
                        <?php
                          if($value->family_head_name !== 'Null'){
                              $head = ' - '.$value->family_head_name;
                          }else{
                              $head = '';
                          }
                        ?>
                        @if($value->id==$familymember->family_id)
                          <option value="{{$value->id}}" selected>{{$value->family_name}}{{$head}}</option>
                        @else
                          <option value="{{$value->id}}">{{$value->family_name}}{{$head}}</option>
                        @endif
                      @endforeach
                  </select>                        
                </div>

                <div class="col-md-5 p-4">
                  <label class="form-label pd_right_15">Are you head of the family</label>
                  <div class="form-check form-check-inline radio radio-primary">
                    @if( $familymember->head_of_family == 1)
                    <input class="form-check-input" id="radioinline1" type="radio" name="head_of_family" value="1"  {{ $familymember->head_of_family == '1' ? 'checked' : '' }}>
                    <label class="form-check-label mb-0" for="radioinline1">Yes<span class="digits"></span></label>
                    @else
                     No
                    @endif
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Blood Group</label>
                      <select class="form-control" name="blood_group_id">
                        <option value="">--Select--</option>
                          @foreach($blood_groups as $key=>$value)
                            @if($value->id==$familymember->blood_group_id)
                              <option value="{{$value->id}}" selected>{{$value->blood_group_name}}</option>
                            @else
                              <option value="{{$value->id}}">{{$value->blood_group_name}}</option>
                            @endif
                          @endforeach
                      </select> 
                </div>

              </div>
              <div class="row">
                <div class="col-md-4">
                  <label class="form-label">Gender<span style="color:red">*</span></label>
                  <select class="form-control" name="gender" required>
                    <option value="">--Select--</option>
                    <option value="Male" {{ $familymember->gender === 'Male' ? 'selected' :'' }}>Male</option>
                    <option value="Female" {{ $familymember->gender === 'Female' ? 'selected' : '' }}>Female</option>
                  </select>  
                </div>

                <div class=" col-md-4 mb-3">
                  <label class="form-label">Date of birth <span style="color:red">*</span></label>
                  <input class="form-control digits" type="date"  data-bs-original-title="" title="" name="dob"  value="{{$familymember->dob}}" required>
                </div>
                <div class=" col-md-4 mb-3">
                  <label class="form-label">Date of baptism</label>
                  <input class="form-control digits" type="date"  data-bs-original-title="" title="" name="date_of_baptism" value="{{$familymember->date_of_baptism}}" >
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label class="form-label">Remark</label>
                  <select class="form-control" name="remark" id='remark'>
                    <option value="">--Select--</option>
                        <option value="1" {{ $familymember->remark == '1' ? 'selected' : '' }}>mariied within parish</option>
                  </select> 
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="validationCustom04">Married to</label>
                    <select class="js-data-example-ajax form-select" id="marr_memb_id" name="marr_memb_id">
                          @foreach($members as $member)
                            @if($familymember->marr_memb_id == $member->id)
                                  <option value="{{ $familymember->marr_memb_id }}" selected>
                                    {{ $member->name }}</option>
                            @else
                                  <option value="{{ $familymember->marr_memb_id }}">
                                    {{ $member->name }}</option>
                            @endif
                          @endforeach
                    </select>
                     <div class="invalid-feedback error_div">Please select a valid type.</div>
                </div>
                <div class="col-md-3 mb-3">
                   <label class="form-label">If married , date of marriage</label>
                  <input class="form-control digits" type="date" value="{{$familymember->date_of_marriage}}"  name="date_of_marriage">
                </div>

                <div class="col-md-3 mb-3">
                  <label class="form-label">Relation with Head of family <span style="color:red">*</span></label>
                  <select class="form-control" name="relationship_id" required>
                    <option value="">--Select--</option>
                      @foreach($relations as $key=>$value)
                          @if($value->id==$familymember->relationship_id)
                            <option value="{{$value->id}}" selected>{{$value->relation_name}}</option>
                          @else
                              <option value="{{$value->id}}">{{$value->relation_name}}</option>
                          @endif
                      @endforeach
                  </select>                        
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Qualification</label>
                    <input class="form-control" type="text" title="" placeholder="Qualification"
                    name="qualification" value="{{$familymember->qualification}}">

                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Occupation</label>
                    <input class="form-control" type="text" title="" placeholder="Occupation"     
                    name="occupation" value="{{$familymember->occupation}}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Comapany Name</label>
                    <input class="form-control" type="text" title="" placeholder="Comapany Name" name="company_name" value="{{$familymember->company_name}}">
                </div>
              </div> 
              <div class="row">

                <div class="col-md-4 mb-3">
                      <label class="form-label">Email</label>
                      <input class="form-control " type="email"  placeholder="Email" name="email" 
                      value="{{$familymember->email}}">
                  </div>
                  <div class="col-md-4 mb-3">
                      <label class="form-label">Mobile</label>
                      <input class="form-control digits" type="text" placeholder="mobile" name="mobile"
                       value="{{$familymember->mobile}}">
                  </div>
                  <div class="col-md-4 mb-3">
                      <label class="form-label">Alternate contact No.</label>
                      <input class="form-control digits" type="text" placeholder="Alternate contact No" name="alt_contact_no" value="{{$familymember->alt_contact_no}}">
                  </div>
              </div>
               <div class="row">

                <div class="col-md-4 mb-3">
                      <label class="form-label">Date of death</label>
                      <input class="form-control digits" type="date" data-bs-original-title="" title="" name="date_of_death" value="{{$familymember->date_of_death}}">
                  </div>
                  <div class="col-md-4 mb-3">
                      <label class="form-label">Image</label>
                      <input class="form-control" type="file"  id="ImageFile" name="image">
                  </div>
                  <div class="col-md-4 mb-3" id="OldImage">
                     <img class="img-fluid for-light" src="{{ asset($familymember->image) }}" alt="" style="max-width: 40% !important;">
                  </div>
                  <div class="col-md-4 mb-3" style="width:150px">
                     <img class="img-fluid for-light" id="ImagePreview" style="max-width: 100% !important;">
                  </div>
              </div>  
              <div class="form-footer">
                <button class="btn btn-primary">Update</button>
                <a class="btn btn-primary" onclick="window.location='{{route('admin.family.member.show_details', ['id' => $familymember->id])}}}'">Cancel</a>
              @if($familymember->image)
                <a class="btn btn-danger" id="deleteImage" table_id ="{{$familymember->id}}" >Delete Image</a>
              @endif
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
    <script type="text/javascript">
      $('#deleteImage').click(function() {

          var table_id = $(this).attr('table_id');
          var type = 'members';
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
      $('#marr_memb_id').select2({
            placeholder: "Select member",
            ajax: {

                url: "<?= url('get_family_members_list') ?>",
                dataType: 'json',
                method: 'post',
                delay: 250,

                 data: function(data) {
                    return {
                        _token    : "<?= csrf_token() ?>",
                        search_tag: data.term,
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.results,
                        pagination: { more: (params.page * 30) < data.total_count }
                    };
                },
                cache: true
            }
        });

      $('#remark').change(function() {

          if($(this).val() === "1") {
              $('#marr_memb_id').prop('required', true);
          }else{
            $('#marr_memb_id').prop('required', false);
          }
      });
    </script>
@endsection