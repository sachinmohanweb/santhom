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
    <h3>Family Member Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Family Member Form</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="edit-profile">
      <div class="row">
          
      <form class="needs-validation" novalidate="" action="{{route('admin.family.member.store')}}" 
          method="Post" enctype="multipart/form-data">
          @csrf
        <div class="col-xl-11">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Member Profile</h4>
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
                      <div class="col-md-2">
                        <label class="form-label">Title</label>
                          <select class="form-control" name="title">
                            <option value="">--Select--</option>
                              @foreach($titles as $value)
                                <option value="{{$value}}">{{$value}}</option>
                              @endforeach
                          </select>                       </div>
                      <div class="col-md-5 pd_left_zero">

                        <label class="form-label">Name<span style="color:red">*</span></label>
                        <input class="form-control" placeholder="Your Name" name="name" required>
                      </div>
                      <div class="col-md-5 pd_left_zero">
                        <label class="form-label">Nickname</label>
                        <input class="form-control" placeholder="Your Nickname" name="nickname">
                      </div>
                    </div>

                  </div>
                </div>
              </div> 
              <div class="row">
                <div class="col-md-5">
                  <label class="form-label">Family <span style="color:red">*</span></label>
                  <select class="form-control" name="family_id" id="family_id" required>
                    <option value="">--Select--</option>
                    @foreach($familys as $key=>$value)
                        <?php
                          if($value->family_head_name !== 'Null'){
                              $head = ' - '.$value->family_head_name;
                          }else{
                              $head = '';
                          }
                        ?>

                        @if(($family_id) && ($family_id==$value->id))
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
                    <input class="form-check-input" id="radioinline1" type="radio" name="head_of_family" value="1" data-bs-original-title="" title="">
                    <label class="form-check-label mb-0" for="radioinline1" id="head_of_family_lable">Yes
                    </label>
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Blood Group</label>
                      <select class="form-control" name="blood_group_id">
                        <option value="">--Select--</option>
                          @foreach($blood_groups as $key=>$value)
                            <option value="{{$value->id}}">{{$value->blood_group_name}}</option>
                          @endforeach
                      </select> 
                </div>

              </div>
              <div class="row">
                <div class="col-md-4">
                  <label class="form-label">Gender<span style="color:red">*</span></label>
                  <select class="form-control" name="gender" required>
                    <option value="">--Select--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>  
                </div>

                <div class=" col-md-4 mb-3">
                  <label class="form-label">Date of birth <span style="color:red">*</span></label>
                  <input class="form-control digits" type="date" value="" data-bs-original-title="" title="" name="dob" required>
                </div>
                <div class=" col-md-4 mb-3">
                  <label class="form-label">Date of baptism</label>
                  <input class="form-control digits" type="date" value="" data-bs-original-title="" title="" name="date_of_baptism">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label">Marital Status</label>
                  <select class="form-control" name="marital_status_id">
                    <option value="">--Select--</option>
                      @foreach($marital_statuses as $key=>$value)
                        <option value="{{$value->id}}">{{$value->marital_status_name}}</option>
                      @endforeach
                  </select> 
                </div>
                <div class="col-md-4 mb-3">
                   <label class="form-label">If married , date of marriage</label>
                  <input class="form-control digits" type="date" value="" data-bs-original-title="" title="" name="date_of_marriage">
                </div>

                <div class="col-md-4 mb-3">
                  <label class="form-label">Relation with Head of family <span style="color:red">*</span></label>
                  <select class="form-control" name="relationship_id" id="relationship_id" required>
                    <option value="">--Select--</option>
                      @foreach($relations as $key=>$value)
                        <option value="{{$value->id}}">{{$value->relation_name}}</option>
                      @endforeach
                  </select>                        
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Qualification</label>
                    <input class="form-control" type="text" title="" placeholder="Qualification" name="qualification">

                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Occupation</label>
                    <input class="form-control" type="text" title="" placeholder="Occupation" name="occupation">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Comapany Name</label>
                    <input class="form-control" type="text" title="" placeholder="Comapany Name" name="company_name">
                </div>
              </div> 
              <div class="row">

                <div class="col-md-4 mb-3">
                      <label class="form-label">Email</label>
                      <input class="form-control " type="email"  placeholder="Email" name="email">
                  </div>
                  <div class="col-md-4 mb-3">
                      <label class="form-label">Mobile</label>
                      <input class="form-control digits" type="text" placeholder="mobile" name="mobile">
                  </div>
                  <div class="col-md-4 mb-3">
                      <label class="form-label">Alternate contact No.</label>
                      <input class="form-control digits" type="text" placeholder="Alternate contact No" name="alt_contact_no">
                  </div>
              </div>
               <div class="row">

                <div class="col-md-4 mb-3">
                      <label class="form-label">Date of death</label>
                      <input class="form-control digits" type="date" value="" data-bs-original-title="" title="" name="date_of_death">
                  </div>
                  <div class="col-md-4 mb-3">
                      <label class="form-label">Image</label>
                      <input class="form-control" type="file"  name="image" id="ImageFile">
                  </div>
                  <div class="col-md-4 mb-3" style="width:150px">
                     <img class="img-fluid for-light" id="ImagePreview" style="max-width: 100% !important;">
                  </div>
              </div>  
              <div class="form-footer">
                <button class="btn btn-primary">Save</button>
                <a class="btn btn-primary" onclick="window.location='{{ route('admin.family.members.list') }}'">Cancel</a>
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

  $(document).ready(function() {
      function checkFamilyHeadUpdated(family_id){
        $.ajax({
            url: '<?= url('check_famiy_head_updated') ?>',
            type: 'post',
            data: {
                _token: "<?= csrf_token() ?>",
                family_id:family_id
            },
            dataType: 'JSON',
            success: function (data) {
                if(data.count == 1) {
                    $('#radioinline1').prop('disabled', true);
                    var alreadySelectedSpan = $('<span>', {
                        class: 'alreadyselected',
                        text: ' already selected',
                        css: {
                            color: 'red'
                        }
                    });
                    $('.alreadyselected').hide();
                    $('#head_of_family_lable').after(alreadySelectedSpan);
                    $('#relationship_id option[value="1"]').hide();

                }else{

                    $('.alreadyselected').hide();
                    $('#radioinline1').prop('disabled', false);
                    $('#relationship_id option[value="1"]').show();

                }
            }
        });   
      }

      var selectedValue = $('#family_id').val();
      if(selectedValue){
        checkFamilyHeadUpdated(selectedValue);
      }

      $('#family_id').on('change', function() {
        var selectedValue = $(this).val();
          checkFamilyHeadUpdated(selectedValue);
      });
  });

</script>
@endsection