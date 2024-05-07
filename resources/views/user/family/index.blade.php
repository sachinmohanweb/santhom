@extends('layouts.simple.master')
@section('title', 'Family')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Families</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item ">Families</li>
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
                                <h3 class="mb-3">Church Families Page</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('admin.family.create')}}" data-bs-original-title="" title="">Add New Family</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                        <div class="col-md-12">
                            <span>The hub for information and resources related to families within our church community</span>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="family_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Family code</th>
                                        <th>Family Name</th>
                                        <th>Prayer Group</th>
                                        <th>Address</th>
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
         
            $('#family_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.family.list.datatable') }}",
                    type: "POST",
                    data: {
                        _token : "<?= csrf_token() ?>",
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'family_code', name: 'family_code' },
                    { data: 'family_name', name: 'family_name' },
                    { data: 'prayer_group', name: 'prayer_group' },
                    { data: 'address1', name: 'address1' },
                    { data: 'action', name: 'action', orderable: false,width:'25%'},
                ],
                 columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                ],
                order: [[1, 'asc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this family?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.family.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#family_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.family.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.family.list') }}";
                            alert('Failed to delete family. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete family. Please try again later.');
                    }
                });
            }
        }


        function viewFunc(id){
            window.location.href = "{{ url('/showfamily') }}"+'/' + id;
        }  
    </script>
@endsection
