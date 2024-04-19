@extends('layouts.simple.master')
@section('title', 'Prayer Groups')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Prayer Groups</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Prayer Groups</li>
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
                                <h3 class="mb-3">Church Prayer Groups</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#AddPrayerGroupModal" >Add New Prayer Group</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                        <div class="col-md-12">
                            <span>Collects information related to Prayer Groups within our church community</span>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="prayer_group_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Group Name</th>
                                        <th>Leader</th>
                                        <th>Leader's Phone</th>
                                        <th>Coordinator</th>
                                        <th>Coordinator's Phone</th>
                                        <th>Status</th>
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

    <div class="modal fade" id="AddPrayerGroupModal" tabindex="-1" role="dialog" aria-labelledby="AddPrayerGroupModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Prayer Group Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate="" action="{{route('admin.prayergroupr.store')}}" method="Post">
                    <div class="modal-body">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                          <label class="form-label" for="validationCustom01">Group Name</label>
                          <input class="form-control" id="group_name" type="text" 
                          required="" name='group_name'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">Group Leader</label>
                          <input class="form-control" id="leader" type="text" name='leader'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">Leader's Phone</label>
                          <input class="form-control" id="leader_phone_number" type="text" name='leader_phone_number'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">Group Coordinator</label>
                          <input class="form-control" id="coordinator_name" type="text" 
                          name='coordinator_name'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">Coordinator's Phone</label>
                          <input class="form-control" id="coordinator_phone" type="text" 
                          name='coordinator_phone'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.prayergroup.list') }}'">Close</button>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="EditPrayerGroupModal" tabindex="-1" role="dialog" aria-labelledby="EditPrayerGroupModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Prayer Group Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" id="EditPrayerGroupForm" novalidate="" method="Post">
                    <div class="modal-body">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                          <label class="form-label" for="validationCustom01">Group Name</label>
                          <input class="form-control" id="group_name_edit" type="text" 
                          required="" name='group_name'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">Group Leader</label>
                          <input class="form-control" id="leader_edit" type="text" name='leader'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">Leader's Phone</label>
                          <input class="form-control" id="leader_phone_number_edit" type="text" 
                          name='leader_phone_number'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">Group Coordinator</label>
                          <input class="form-control" id="coordinator_name_edit" type="text" name='coordinator_name'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">coordinator's Phone</label>
                          <input class="form-control" id="coordinator_phone_edit" type="text" 
                          name='coordinator_phone'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.prayergroup.list') }}'">Close</button>
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
         
            $('#prayer_group_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.prayergroup.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'group_name', name: 'group_name' },
                    { data: 'leader', name: 'leader' },
                    { data: 'leader_phone_number', name: 'leader_phone_number' },
                    { data: 'coordinator_name', name: 'coordinator_name' },
                    { data: 'coordinator_phone', name: 'coordinator_phone' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false,width:'25%'},
                ],
                columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                    { width: '10%', targets: 1 },
                    { width: '15%', targets: 2 },
                    { width: '15%', targets: 3 },
                    { width: '15%', targets: 4 },
                    { width: '15%', targets: 5 },
                    { width: '15%', targets: 6 ,searchable: false},
                    { width: '15%', targets: 7 },
                ],
                order: [[0, 'desc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this prayer group?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.prayergroup.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#prayer_group_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.prayergroup.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.prayergroup.list') }}";
                            alert('Failed to delete prayergroup. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete prayer group. Please try again later.');
                    }
                });
            }
        }


        function EditFunc(id){
            $.ajax({
                type:"post",
                url: "{{ route('admin.get.prayergroup') }}",
                data: { _token : "<?= csrf_token() ?>",
                        id     : id
                },
                dataType: 'json',
                success: function(res){
                    $('#group_name_edit').attr('value', res.group_name);
                    $('#leader_edit').val(res.leader);
                    $('#leader_phone_number_edit').val(res.leader_phone_number);
                    $('#coordinator_name_edit').val(res.coordinator_name);
                    $('#coordinator_phone_edit').val(res.coordinator_phone);
                    $('#EditPrayerGroupForm').attr('action', "{{ url('updateprayergroup') }}/" + id);


                    $('#EditPrayerGroupModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    alert('Failed get data. Please try again later.');
                }
            });
        
        }  
    </script>
@endsection
