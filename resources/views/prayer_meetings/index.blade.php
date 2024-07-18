@extends('layouts.simple.master')
@section('title', 'Prayer Groups')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Prayer Meetings</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Prayer Meetings</li>
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
                                <h3 class="mb-3">Prayer Meetings</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('admin.prayermeetings.create')}}" >Add New Prayer Meeting</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                        <div class="col-md-12">
                            <span>Information related to Prayer meetings within our church community</span>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="prayer_meeting_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Group Name</th>
                                        <th>Family</th>
                                        <th>Family Head</th>
                                        <th>Date</th>
                                        <th>Time</th>
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

@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>

    <script>
        $(document).ready( function () {+32.

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
         
            $('#prayer_meeting_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.prayermeetings.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'group_name', name: 'group_name' },
                    { data: 'family', name: 'family' },
                    { data: 'family_head', name: 'family_head' },
                    { data: 'date', name: 'date' },
                    { data: 'time', name: 'time' },
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
            if (confirm("Are you sure? Delete this prayer meeting?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.prayermeetings.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.prayermeetings.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.prayermeetings.list') }}";
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

            window.location.href = '/editprayermeetings/' + id;
            s
        }  
    </script>
@endsection
