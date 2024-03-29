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
                        <h5>Details</h5>
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
                                <div class="col-md-5">
                                    <label class="form-label" for="validationCustom01">title</label>
                                    <input class="form-control" id="validationCustom01" type="text" 
                                    value="{{ old('title') }}" required="" name='title'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="validationCustom04">Type</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">Choose...</option>
                                        <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>
                                        Trustee</option>
                                        <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Secretary</option>
                                        <option value="3" {{ old('type') == '3' ? 'selected' : '' }}>Prayer Group</option>
                                        <option value="4" {{ old('type') == '4' ? 'selected' : '' }}>Organization</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a valid type.</div>
                                </div>
                                <div class="col-md-4" id="group_org_div">
                                    <label class="form-label" for="validationCustom04">Group/Org.</label>
                                        <select class="js-data-example-ajax form-select" id="group_org_id" name="group_org_id"></select>
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
                           
                            <button class="btn btn-primary" type="submit">Save</button>
                            <a class="btn btn-primary" onclick="window.location='{{ route('admin.notification.list') }}'">Cancel</a>
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

            $('#group_org_div').hide();

            $('#type').change(function(){
                var selectedValue = $(this).val();
                if(selectedValue == '3' || selectedValue == '4') {
                    $('#group_org_div').show();
                } else {
                    $('#group_org_div').hide();
                }
            });
            $('#group_org_id').select2({
                placeholder: "Select group/org",
                ajax: {

                    url: "<?= url('get_group_org_list') ?>",
                    dataType: 'json',
                    method: 'post',
                    delay: 250,

                     data: function(data) {
                        return {
                            _token    : "<?= csrf_token() ?>",
                            search_tag: data.term,
                               type: $('#type').val(),
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