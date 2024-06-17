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
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom04">Family with Family head 
                                        <span style="color:red">*</span></label>
                                    
                                    <select class="js-data-example-ajax form-select" id="head_id" name="head_id" required></select>

                                    <div class="invalid-feedback" style="color:red">Please select a member.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">Payment Category
                                    <span style="color:red">*</span></label>
                                    <select class="js-data-example-ajax form-select" id="category_id" name="category_id" required>
                                    </select>
                                    <div class="invalid-feedback" style="color:red">Please select a payment category.</div>
                                </div>
                                 <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">Amount
                                    <span style="color:red">*</span></label>
                                    <input class="form-control" id="validationCustom01" type="number" 
                                    value="{{ old('amount') }}" required="" name='amount' style="padding: 0.625rem 0.75rem;!important">
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
        $('#head_id').select2({
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
                        head_member: 'yes',
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
        $('#category_id').select2({
            placeholder: "Select payment category",
            ajax: {

                url: "<?= url('get_payment_categorylist') ?>",
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