@extends('layouts.simple.master')
@section('title', 'Family')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Families-Pending</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data Tables</li>
    <li class="breadcrumb-item active">Families-Pending</li>
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
                                <h3 class="mb-3">Church Families Page-Pending</h3> 
                            </div>
                           
                        </div>
                        <div class="row" style="display:flex;">
                            
                        
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="family_pending_data" style="width:100%">
                                <thead>
                                    <tr>
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
         
            $('#family_pending_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.family.list.datatable.pending') }}",
                    type: "POST",
                    data: {
                        _token : "<?= csrf_token() ?>",
                    }
                },
                columns: [
                    { data: 'family_code', name: 'family_code' },
                    { data: 'family_name', name: 'family_name' },
                    { data: 'prayer_group', name: 'prayer_group' },
                    { data: 'address1', name: 'address1' },
                    { data: 'action', name: 'action', orderable: false,width:'25%'},
                ],
                order: [[0, 'asc']]
            });
        });
              
        function viewFunc(id){
            window.location.href = "{{ url('/showfamily_pending') }}"+'/' + id;
        }  
    </script>
@endsection
