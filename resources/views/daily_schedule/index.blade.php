@extends('layouts.simple.master')
@section('title', 'Daily Schedules')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Daily Schedules</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Daily Schedules</li>
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
                                <h3 class="mb-3">Daily Schedules</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('admin.daily.schedules.create')}}" data-bs-original-title="" title="">Add Daily Schedule</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                            <div class="col-md-12">
                                <span>This page consists date-wise upcoming Church activities</span>
                            </div>
                        </div> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="daily_schedule_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Date</th>
                                        <th>Details</th>
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
         
            $('#daily_schedule_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.daily.schedules.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'date', name: 'date' },
                    { data: 'details', name: 'details' },
                    { data: 'action', name: 'action', orderable: false},
                ],
                 columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                    { width: '20%', targets: 1 },
                    { width: '50%', targets: 2 },
                    { width: '25%', targets: 3 ,searchable: false},
                ],
                order: [[1, 'Asc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this daily schedule?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.daily.schedules.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#daily_schedule_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.daily.schedules.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.daily.schedules.list') }}";
                            alert('Failed to delete daily schedule. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete daily schedule. Please try again later.');
                    }
                });
            }
        }


        function viewFunc(id){
            window.location.href = "{{ url('/showdailyschedule') }}"+'/' + id;
        }  
    </script>
@endsection
