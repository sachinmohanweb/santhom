@extends('layouts.simple.master')
@section('title', 'Obituaries')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Obituary Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Forms</li>
    <li class="breadcrumb-item active">Obituary Form</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Details</h5>
                        <span>This form collects Obituaries details.
                        </span>
                    </div>

                     @if($errors->any())
                        <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                     @endif
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" 
                        action="{{route('admin.obituary.store')}}" method="Post" enctype="multipart/form-data">
                        	@csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom04">Name of the member</label>
                                     <select class="js-data-example-ajax form-select" id="member_id" name="member_id" required></select>
                                </div>
                                 <div class="col-md-3">
                                    <label class="form-label" for="validationCustom04">Date of death</label>
                                    <input class="form-control" id="validationCustom01" type="date" 
                                    value="{{ old('date_of_death') }}" required="" name='date_of_death'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                 <div class="col-md-3">
                                    <label class="form-label" for="validationCustom04">Display Till</label>
                                    <input class="form-control" id="validationCustom01" type="date" 
                                    value="{{ old('display_till_date') }}" required name='display_till_date'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                            </div>
                            <div class="row g-3 mb-3">
                                 <div class="col-md-4">
                                    <label class="form-label" for="validationCustom04">Date of Funeral</label>
                                    <input class="form-control" id="validationCustom01" type="date" 
                                    value="{{ old('funeral_date') }}" name='funeral_date'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                 <div class="col-md-4">
                                    <label class="form-label" for="validationCustom04">Time of funeral </label>
                                    <input class="form-control" id="validationCustom01" type="time" 
                                    value="{{ old('funeral_time') }}" name='funeral_time'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom05">Image</label>
                                    <input class="form-control" id="validationCustom05" type="file" 
                                         name="photo" value="{{ old('photo') }}">
                                    <div class="invalid-feedback">Please provide a valid zip.</div>
                                </div>
                               
                            </div>
                            <div class="row g-3">
                                
                                 <div class="col-md-12">
                                    <label class="form-label" for="validationCustom03">Note</label>
                                    <textarea class="form-control" id="note" name="notes" rows="5" cols="50"></textarea><br>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                
                               
                            </div>
                           
                            <button class="btn btn-primary" type="submit">Save</button>
                            <a class="btn btn-primary" onclick="window.location='{{ route('admin.obituary.list') }}'">Cancel</a>
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
        $('#member_id').select2({
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
                        page: 'obituary',
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
    </script>
@endsection