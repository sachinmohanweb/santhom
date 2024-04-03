@extends('layouts.simple.master')
@section('title', 'Downloads')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Downloads</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data Tables</li>
    <li class="breadcrumb-item active">Downloads</li>
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
                                <h3 class="mb-3">Downloads</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#AddDownloadModal" >Add New File</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                        <div class="col-md-12">
                            <span>This is the page where the admin can upload PDF files, images, and magazines related to the church </span>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="downloalod_files_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>File</th>
                                        <th>Details</th>
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

    <div class="modal fade" id="AddDownloadModal" tabindex="-1" role="dialog" aria-labelledby="AddDownloadModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">File Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate="" action="{{route('admin.download.store')}}" method="Post" enctype="multipart/form-data">
                    <div class="modal-body">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom01">Title</label>
                          <input class="form-control" id="title" type="text" 
                          required="" name='title'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">file</label>
                          <input class="form-control" id="coordinator" type="file" name='file' required>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-12">
                          <label class="form-label" for="validationCustom02">details</label>
                          <input class="form-control" id="coordinator_phone_number" type="text"
                           name='details'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.download.list') }}'">Close</button>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="EditDownloadModal" tabindex="-1" role="dialog" aria-labelledby="EditDownloadModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">File Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" id="EditDownloadForm" novalidate="" method="Post" enctype="multipart/form-data">
                    <div class="modal-body">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom01">Title</label>
                          <input class="form-control" id="title_edit" type="text" 
                          required="" name='title'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom02">file</label>
                          <input class="form-control" id="file_edit" type="file" name='file'>
                          <div class="valid-feedback" >Looks good!</div>
                          <div class="" id="filediv">Looks good!</div>
                        </div>

                        <div class="col-md-12">
                          <label class="form-label" for="validationCustom02">details</label>
                          <input class="form-control" id="details_edit" type="text"
                           name='details'>
                        <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.download.list') }}'">Close</button>
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
         
            $('#downloalod_files_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.download.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'title', name: 'title' },
                    { data: 'type', name: 'type' },
                    { data: 'file', name: 'file' },
                    { data: 'details', name: 'details' },
                    { data: 'action', name: 'action', orderable: false,width:'25%'},
                ],
                columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                    { width: '10%', targets: 1 },
                    { width: '15%', targets: 2 },
                    { width: '15%', targets: 3 },
                    { width: '15%', targets: 4 },
                    { width: '15%', targets: 5 },
                ],
                order: [[0, 'desc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this file?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.download.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#downloalod_files_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.download.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.download.list') }}";
                            alert('Failed to delete organization. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete file. Please try again later.');
                    }
                });
            }
        }


        function EditFunc(id){
            $.ajax({
                type:"post",
                url: "{{ route('admin.get.download') }}",
                data: { _token : "<?= csrf_token() ?>",
                        id     : id
                },
                dataType: 'json',
                success: function(res){
                    $('#title_edit').attr('value', res.title);
                    var fullPath = res.file;
                    var fileName = fullPath.replace(/^.*[\\\/]/, '');

                    $('#filediv').text(fileName);
                    $('#details_edit').val(res.details);
                    $('#EditDownloadForm').attr('action', "{{ url('updatedownload') }}/" + id);


                    $('#EditDownloadModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    alert('Failed get data. Please try again later.');
                }
            });
        
        }  
    </script>
@endsection
