@extends('layouts.simple.master')
@section('title', 'Payment Categories')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Payment Categories</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Payment Categories</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Ajax sourced data  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <div class="row" style="display:flex;">

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
                         
                            <div class="col-md-9">
                                <h3 class="mb-3">Payment Categories </h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                                <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#AddPaymentCategoryModal" >Add Payment Category</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="payment_category_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Category</th>
                                        <th>Action</th>

                                       
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AddPaymentCategoryModal" tabindex="-1" role="dialog" aria-labelledby="AddBibleVerseModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment Category</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate="" action="{{route('admin.paymentcategories.store')}}" method="Post">
                    <div class="modal-body">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                          <label class="form-label" for="validationCustom01">Category Name</label>
                          <input class="form-control" id="name" type="text" 
                          required="" name='name'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.paymentcategories.list') }}'">Close</button>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
         
            $('#payment_category_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.paymentcategories.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'category', name: 'category' },
                    { data: 'action', name: 'action', orderable: false,width:'25%'},
                ],
                columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                ],
                order: [[0, 'desc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this Payment category?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.paymentcategories.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#payment_category_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.paymentcategories.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.paymentcategories.list') }}";
                            alert('Failed to delete Payment categories. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete Payment categories. Please try again later.');
                    }
                });
            }
        }  
    </script>
@endsection
