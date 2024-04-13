@extends('layouts.simple.master')
@section('title', 'Bible Verse')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Bible Verse</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Bible Verse</li>
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
                                <h3 class="mb-3">Bible Verse</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#AddBibleVerseModal" >Add New Bible Verse</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                        <div class="col-md-12">
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="bible_verse_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Date</th>
                                        <th>Ref</th>
                                        <th>Bible Verse</th>
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

    <div class="modal fade" id="AddBibleVerseModal" tabindex="-1" role="dialog" aria-labelledby="AddBibleVerseModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bible Verse Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate="" action="{{route('admin.bibleverse.store')}}" method="Post">
                    <div class="modal-body">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                          <label class="form-label" for="validationCustom01">Reference</label>
                          <input class="form-control" id="reference" type="text" 
                          required="" name='ref'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Date</label>
                          <input class="form-control" type="date" placeholder="date" name="date" required>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-md-12">
                          <label class="form-label" for="validationCustom02">Bible Verse</label>
                           <textarea class="form-control" id="verse" name="verse" rows="8" cols="50" required></textarea><br>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.bibleverse.list') }}'">Close</button>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="EditBibleVerseModal" tabindex="-1" role="dialog" aria-labelledby="EditBibleVerseModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bible Verse Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" id="EditBibleVerseForm" novalidate="" method="Post">
                    <div class="modal-body">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                          <label class="form-label" for="validationCustom01">Reference</label>
                          <input class="form-control" id="reference_edit" type="text" 
                          required="" name='ref'>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Date</label>
                          <input class="form-control" type="date" placeholder="date" id="date_edit" 
                          name="date" required>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-12">
                          <label class="form-label" for="validationCustom02">Bible Verse</label>
                           <textarea class="form-control" id="verse_edit" name="verse" rows="8" cols="50" required></textarea><br>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.bibleverse.list') }}'">Close</button>
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
         
            $('#bible_verse_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.bibleverse.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'date', name: 'date' },
                    { data: 'ref', name: 'ref' },
                    { data: 'verse', name: 'verse' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false,width:'25%'},
                ],
                columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                    { width: '15%', targets: 1},
                ],
                order: [[1, 'asc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this Bible verse?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.bibleverse.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#bible_verse_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.bibleverse.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.bibleverse.list') }}";
                            alert('Failed to delete Bible verse. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete Bible verse. Please try again later.');
                    }
                });
            }
        }


        function EditFunc(id){
            $.ajax({
                type:"post",
                url: "{{ route('admin.get.bibleverse') }}",
                data: { _token : "<?= csrf_token() ?>",
                        id     : id
                },
                dataType: 'json',
                success: function(res){
                    $('#reference_edit').attr('value', res.ref);
                    $('#verse_edit').val(res.verse);
                    $('#date_edit').val(res.date);
                    $('#EditBibleVerseForm').attr('action', "{{ url('updatebibleverse') }}/" + id);


                    $('#EditBibleVerseModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    alert('Failed get data. Please try again later.');
                }
            });
        
        }  
    </script>
@endsection
