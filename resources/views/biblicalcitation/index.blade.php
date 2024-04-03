@extends('layouts.simple.master')
@section('title', 'Biblical Citations')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Biblical Citations</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Biblical Citations</li>
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
                                <h3 class="mb-3">Date-wise Biblical Citations</h3> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                 
                               <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('admin.biblical.citation.create')}}" data-bs-original-title="" title="">Add New Biblical Citation</a>

                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            
                            <div class="col-md-12">
                                <span>This page consists of Bible citations arranged date-wise</span>
                            </div>
                        </div> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="biblical_citation_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Date</th>
                                        <th>Reference</th>
                                        <th>Note</th>
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
         
            $('#biblical_citation_data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.biblical.citation.list.datatable') }}",
                columns: [
                    {  data: 'DT_RowIndex', name: 'Sl.No'},
                    { data: 'date', name: 'date' },
                    { data: 'reference', name: 'reference' },
                    { data: 'note1', name: 'note1' },
                    { data: 'action', name: 'action', orderable: false},
                ],
                 columnDefs: [
                    { width: '5%', targets: 0 ,orderable: false, searchable: false},
                    { width: '10%', targets: 1 },
                    { width: '15%', targets: 2 },
                    { width: '15%', targets: 3 },
                    { width: '15%', targets: 4 ,searchable: false},
                ],
                order: [[2, 'desc']]
            });
        });
              
        function deleteFunc(id){
            if (confirm("Are you sure? Delete this biblical citation?") == true) {
                var id = id;
                $.ajax({
                    type:"POST",
                    url: "{{ route('admin.biblical.citation.delete') }}",
                    data: { _token : "<?= csrf_token() ?>",
                            id     : id
                    },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#biblical_citation_data').dataTable();
                        if (res.status=='success'){
                            window.location.href ="{{ route('admin.biblical.citation.list') }}";
                        }else{
                            window.location.href ="{{ route('admin.biblical.citation.list') }}";
                            alert('Failed to delete biblical citation. Please try again later.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        alert('Failed to delete biblical citation. Please try again later.');
                    }
                });
            }
        }


        function viewFunc(id){
            window.location.href = "{{ url('/showbiblicalcitation') }}"+'/' + id;
        }  
    </script>
@endsection
