@extends('layouts.simple.master')
@section('title', 'News/Announcement')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Prayer Meeting Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Prayer Meeting Form</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Details</h5>
                        <span>This form collects Prayer Meeting details.
                        </span>
                    </div>

                     @if($errors->any())
                        <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                     @endif
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" 
                        action="{{route('admin.prayermeetings.update',['id'=>$PrayerMeeting->id])}}" method="Post" enctype="multipart/form-data">
                        	@csrf
                            <div class="row g-3 mb-3">

                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom04">Prayer Group<span style="color:red">*</span>
                                    </label>
                                    <select class="form-select" id="prayer_group_id" required name="prayer_group_id">
                                        <option value="">Choose...</option>
                                        @foreach($prayer_groups as $key=>$value)
                                        <option value="{{$value->id}}" {{ old('prayer_group_id') == '1' ? 'selected' : '' }}>{{$value->group_name}}</option>

                                            @if($value->id==$PrayerMeeting['prayer_group_id'])
                                              <option value="{{$value->id}}" selected>{{$value->group_name}}</option>
                                            @else
                                              <option value="{{$value->id}}">{{$value->group_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom04">Family <span style="color:red">*</span></label>
                                    <select class="form-select family_id" id="validationCustom02" name="family_id" required>
                                        <option value="">--Select--</option>
                                          @foreach($familys as $key=>$value)
                                            <?php
                                              if($value->family_head_name !== 'Null'){
                                                  $head = ' - '.$value->family_head_name;
                                              }else{
                                                  $head = '';
                                              }
                                            ?>
                                            @if($value->id==$PrayerMeeting['family_id'])
                                              <option value="{{$value->id}}" selected>{{$value->family_name}}{{$head}}</option>
                                            @else
                                              <option value="{{$value->id}}">{{$value->family_name}}{{$head}}</option>
                                            @endif
                                          @endforeach
                                    </select> 
                                    <div class="invalid-feedback">Please select a family.</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom02">Date<span style="color:red">*</span> </label>
                                    <input class="form-control" id="validationCustom02" type="date" value="{{ $PrayerMeeting['date'] }}"  required="" name='date'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                 <div class="col-md-6">
                                    <label class="form-label" for="validationCustom02">Time<span style="color:red">*</span> </label>
                                    <?php
                                        $PrayerMeeting['time'] = \Carbon\Carbon::createFromFormat('H:i:s', $PrayerMeeting['time'])->format('H:i');
                                    ?>
                                    <div class="input-group clockpicker">
                                        <input class="form-control" type="text" value="{{ $PrayerMeeting['time'] }}" data-bs-original-title="" name="time" required  title="24 Hours As hh:mm">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                          
                            <button class="btn btn-primary" type="submit">Save</button>
                            <a class="btn btn-primary" onclick="window.location='{{ route('admin.prayermeetings.list') }}'">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('.family_id').select2({
                placeholder: "Select family",
                ajax: {

                    url: "<?= url('get_family_list') ?>",
                    dataType: 'json',
                    method: 'post',
                    delay: 250,

                     data: function(data) {
                        return {
                            _token    : "<?= csrf_token() ?>",
                            search_tag: data.term,
                               prayer_group_id: $('#prayer_group_id').val(),
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
        });
    </script>
@endsection