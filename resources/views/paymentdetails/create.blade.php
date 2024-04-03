@extends('layouts.simple.master')
@section('title', 'Payment Details')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Payment Details Form</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Payment Details Form</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Details</h5>
                        <span>This form collects Payment details.
                        </span>
                    </div>

                     @if($errors->any())
                        <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                     @endif
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" 
                        action="{{route('admin.paymentdetails.store')}}" method="Post" enctype="multipart/form-data">
                        	@csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom04">Member</label>
                                    
                                    <select class="js-data-example-ajax form-select" id="member_id" name="member_id" required></select>

                                    <div class="invalid-feedback">Please select a valid type.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom01">Purpose</label>
                                    <input class="form-control" id="validationCustom01" type="text" 
                                    value="{{ old('purpose') }}" required="" name='purpose'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            </div>
                            <div class="row g-3">
                                 <div class="col-md-6">
                                    <label class="form-label" for="validationCustom01">Date</label>
                                    <input class="form-control" id="validationCustom01" type="date" 
                                    value="{{ old('date') }}" required="" name='date'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label" for="validationCustom01">Amount</label>
                                    <input class="form-control" id="validationCustom01" type="text" 
                                    value="{{ old('amount') }}" required="" name='amount'>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            </div><br>
                           
                            <button class="btn btn-primary" type="submit">Save</button>
                            <a class="btn btn-primary" onclick="window.location='{{ route('admin.paymentdetails.list') }}'">Cancel</a>
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