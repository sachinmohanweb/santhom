@extends('layouts.simple.master')
@section('title', 'Memories')

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
    <h3>Memories Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Forms</li>
    <li class="breadcrumb-item active">Memories Form</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="edit-profile">
      <div class="row">
          
      <form class="needs-validation" novalidate="" action="{{route('admin.memories.store')}}" 
          method="Post" enctype="multipart/form-data">
          @csrf
        <div class="col-xl-11">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Memories Details</h4>
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
                      <div class="col-md-4">
                        <label class="form-label">Memory Type</label>
                        <select class="form-control" name="memory_type_id" id="memory_type_id" required>
                          <option value="">--Select--</option>
                          @foreach($MemoryType as $key=>$value)
                                <option value="{{$value->id}}">{{$value->type_name}}</option>
                          @endforeach
                        </select>  
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Date<span style="color:red">*</span></label>
                        <input class="form-control" type="date" placeholder="date" name="date" required>
                      </div>
                       <div class="col-md-4 pd_left_zero">

                        <label class="form-label"> Note</label>
                        <input class="form-control" placeholder="details" name="note1">
                      </div>
                    </div><br>
                    <div class="row">

                      <div class="col-md-12">
                        <label class="form-label">Title<span style="color:red">*</span></label>
                        <textarea class="form-control" id="title" name="title" rows="5" required></textarea ><br>
                        <div class="valid-feedback">Looks good!</div>
                      </div>
                    </div>

                    <div class="row">

                      <div class="col-md-12">
                        <label class="form-label">More details</label>
                        <textarea class="form-control" id="note2" name="note2" rows="5"></textarea ><br>
                        <div class="valid-feedback">Looks good!</div>
                      </div>
                    </div>

                  </div>
                </div>
              </div> 
 
              <div class="form-footer">
                <button class="btn btn-primary btn-block">Save</button>

                <a class="btn btn-primary" onclick="window.location='{{ route('admin.memories.list') }}'">Cancel</a>
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