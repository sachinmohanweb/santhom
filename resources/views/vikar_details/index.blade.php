@extends('layouts.simple.master')
@section('title', 'Vikars')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Vikars</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data Tables</li>
    <li class="breadcrumb-item active">Vikars</li>
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
                                <h3 class="mb-3">Church Vikars Page</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('admin.vikar.create')}}" data-bs-original-title="" title="">Add Vikar Details </a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                        <div class="col-md-12">
                            <span>The hub for information and resources related to vikars within our church community</span>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="vikars_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Name</th>
                                        <th>Family Name</th>
                                        <th>Designation</th>
                                        <th>Joining Date</th>
                                        <th>Relieving Date</th>
                                        <th>Email</th>
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
         
            $('#vikars_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.vikar.list.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'name', name: 'name', width: '10%' },
                    { data: 'family_name', name: 'family_name' , width: '10%'},
                    { data: 'designation', name: 'designation', width: '10%' },
                    { data: 'date_of_joining', name: 'date_of_joining', width: '10%' },
                    { data: 'date_of_relieving', name: 'date_of_relieving', width: '10%' },
                    { data: 'email', name: 'email', width: '10%' },
                    { data: 'action', name: 'action', orderable: false,width:'45%'},
                ],
                 columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                ],
                order: [[0, 'desc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this vikar details?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.vikar.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#vikars_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.vikar.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.vikar.list') }}";
                            alert('Failed to delete vikar details. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete vikar details. Please try again later.');
                    }
                });
            }
        }


        function viewFunc(id){
            window.location.href = "{{ url('/showvikar') }}"+'/' + id;
        }  
    </script>
@endsection
