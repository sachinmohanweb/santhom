@extends('layouts.simple.master')
@section('title', 'Organizations')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Organizations</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data Tables</li>
    <li class="breadcrumb-item active">Organizations</li>
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

                            @if($errors->any())
                                <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                            @endif
                         
                            <div class="col-md-9">
                                <h3 class="mb-3">Church Organizations</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#AddOrganizationModal" >Add New Organization</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                        <div class="col-md-12">
                            <span>Collects information and resources related to Organizations within our church community</span>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="organizations_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Organization Name</th>
                                        <th>Coordinator</th>
                                        <th>Number</th>
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

    <div class="modal fade" id="AddOrganizationModal" tabindex="-1" role="dialog" aria-labelledby="AddPrayerGroupModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Organization Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate="" action="{{route('admin.organizations.store')}}" method="Post">
                    <div class="modal-body">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Organization Name</label>
                          <input class="form-control" id="organization_name" type="text" 
                          required="" name='organization_name'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Coordinator</label>
                          <input class="form-control" id="coordinator" type="text" name='coordinator'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Coordinator's Phone</label>
                          <input class="form-control" id="coordinator_phone_number" type="text" name='coordinator_phone_number'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.organizations.list') }}'">Close</button>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="EditOrganizationsModal" tabindex="-1" role="dialog" aria-labelledby="EditOrganizationsModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Organizations Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" id="EditOrganizationsForm" novalidate="" method="Post">
                    <div class="modal-body">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Group Name</label>
                          <input class="form-control" id="organization_name_edit" type="text" 
                          required="" name='organization_name'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Group Leader</label>
                          <input class="form-control" id="coordinator_edit" type="text" name='coordinator'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Leader's Phone</label>
                          <input class="form-control" id="coordinator_phone_number_edit" type="text" 
                          name='coordinator_phone_number'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.organizations.list') }}'">Close</button>
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>

    <script>
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
         
            $('#organizations_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.organizations.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'organization_name', name: 'organization_name' },
                    { data: 'coordinator', name: 'coordinator' },
                    { data: 'coordinator_phone_number', name: 'coordinator_phone_number' },
                    { data: 'action', name: 'action', orderable: false,width:'25%'},
                ],
                columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                    { width: '10%', targets: 1 },
                    { width: '15%', targets: 2 },
                    { width: '15%', targets: 3 },
                    { width: '15%', targets: 4 },
                ],
                order: [[0, 'desc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this organization?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.organizations.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#prayer_group_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.organizations.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.organizations.list') }}";
                            alert('Failed to delete organization. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete organization. Please try again later.');
                    }
                });
            }
        }


        function EditFunc(id){
            $.ajax({
                type:"post",
                url: "{{ route('admin.get.organizations') }}",
                data: { _token : "<?= csrf_token() ?>",
                        id     : id
                },
                dataType: 'json',
                success: function(res){
                    $('#organization_name_edit').attr('value', res.organization_name);
                    $('#coordinator_edit').val(res.coordinator);
                    $('#coordinator_phone_number_edit').val(res.coordinator_phone_number);
                    $('#EditOrganizationsForm').attr('action', "{{ url('updateorganizations') }}/" + id);


                    $('#EditOrganizationsModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    alert('Failed get data. Please try again later.');
                }
            });
        
        }  
    </script>
@endsection
