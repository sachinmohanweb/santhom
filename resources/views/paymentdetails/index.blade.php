@extends('layouts.simple.master')
@section('title', 'Payment Details')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Payment Details</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Payment Details</li>
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
                                <h3 class="mb-3">Payment Details </h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('admin.paymentdetails.create')}}" data-bs-original-title="" title="">Add Payment Details</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                        <div class="col-md-12">
                            @if($date_value)
                            <span>Payment Details :  <strong style="color:green">{{$date_value['date']}}</strong>
                            </span>
                            @endif
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="payment_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Family</th>
                                        <th>Head of family</th>
                                        <th>category</th>
                                        <th>Amount</th>
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
         
            $('#payment_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.paymentdetails.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'family', name: 'families.family_name' },
                    { data: 'head_of_family', name: 'family_members.name' },
                    { data: 'category', name: 'payment_categories.name' },
                    { data: 'amount', name: 'amount' },
                    { data: 'action', name: 'action', orderable: false,width:'25%'},
                ],
                columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                ],
                order: [[0, 'desc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this Payment_details?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.paymentdetails.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#payment_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.paymentdetails.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.paymentdetails.list') }}";
                            alert('Failed to delete Payment details. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete Payment details. Please try again later.');
                    }
                });
            }
        }

        function viewFunc(id){
            window.location.href = "{{ url('/showpaymentdetails') }}"+'/' + id;
        }  
    </script>
@endsection
