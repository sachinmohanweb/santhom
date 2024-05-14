@extends('layouts.simple.master')
@section('title', 'Memories')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Memories</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Memories</li>
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
                                <h3 class="mb-3">Date-wise Memories</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('admin.memories.create')}}" data-bs-original-title="" title="">Add New Memories</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                            <div class="col-md-12">
                                <span>This page consists date-wise memories related to Historical Days,Ancestral Days,Remembrance Days</span>
                            </div>
                        </div> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="memories_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>title</th>
                                        <th>Date</th>
                                        <th>Type</th>
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
         
            $('#memories_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.memories.list.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'title', name: 'title' },
                    { data: 'date', name: 'date' },
                    { data: 'memory_day_type_name', name: 'memory_day_type_name' },
                    { data: 'action', name: 'action', orderable: false},
                ],
                 columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                    { width: '10%', targets: 1 },
                    { width: '15%', targets: 2,searchable: false },
                    { width: '15%', targets: 3 ,searchable: false,orderable: false,},
                    { width: '15%', targets: 4 ,searchable: false},
                ],
                order: [[2, 'desc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this memory?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.memories.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#memories_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.memories.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.memories.list') }}";
                            alert('Failed to delete memory. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete memory. Please try again later.');
                    }
                });
            }
        }


        function viewFunc(id){
            window.location.href = "{{ url('/showmemory') }}"+'/' + id;
        }  
    </script>
@endsection
