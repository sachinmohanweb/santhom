@extends('layouts.simple.master')
@section('title', 'Family Members')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Family Members-Pending</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data Tables</li>
    <li class="breadcrumb-item active">Family Members Pending</li>
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
                                <h3 class="mb-3">Family members page-Pending</h3> 
                            </div>
                            
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="family_members_pending_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Family</th>
                                        <th>Relationship</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ajax sourced data Ends-->
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
         
            $('#family_members_pending_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.familymembers.list.datatable.pending') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    {  data: 'image', name: 'image'},     
                    { data: 'name', name: 'name' },
                    { data: 'dob', name: 'dob' },
                    { data: 'family_name', name: 'family_name' },
                    { data: 'relationship', name: 'relationship' },
                    { data: 'action', name: 'action', orderable: false},
                ],
                 columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                    { width: '10%', targets: 1 },
                    { width: '15%', targets: 2 },
                    { width: '15%', targets: 3 },
                    { width: '15%', targets: 4 ,searchable: false},
                    { width: '15%', targets: 5 },
                    { width: '25%', targets: 6 },
                ],
                order: [[2, 'asc']]
            });
        });
              

        function viewFunc(id){
            window.location.href = "{{ url('/showfamilymember_pending') }}"+'/' + id;
        }  
    </script>
@endsection
