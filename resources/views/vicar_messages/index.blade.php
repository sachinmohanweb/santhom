@extends('layouts.simple.master')
@section('title', 'Vicar Messages')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Vicar Messages</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Vicar Messages</li>
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
                                <h3 class="mb-3">Vicar Messages page</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('admin.vicarmessages.create')}}" data-bs-original-title="" title="">Add Messages</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                          
                        </div> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="vicar_messages_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Image</th>
                                        <th>Subject</th>
                                        <th>Message </th>
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
         
            $('#vicar_messages_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.vicarmessages.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    {  data: 'image', name: 'image'},     
                    { data: 'subject', name: 'subject' },
                    { data: 'message_body', name: 'message_body' },
                    { data: 'action', name: 'action', orderable: false},
                ],
                 columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                ],
                order: [[0, 'asc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this vicars message?") == true) {
                var id = id;
                $.ajax({
                     type:"POST",
                    url: "{{ route('admin.vicarmessages.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#vicar_messages_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.vicarmessages.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.vicarmessages.list') }}";
                            alert('Failed to delete Vicar message. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete vicar message. Please try again later.');
                    }
                });
            }
        }


        function viewFunc(id){
            window.location.href = "{{ url('/show_vicarmessages') }}"+'/' + id;
        }  
    </script>
@endsection
