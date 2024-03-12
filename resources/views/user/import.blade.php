@extends('layouts.simple.master')
@section('title', 'Import Family & Members')

@section('css')
@endsection

@section('style')

<style type="text/css">

    .progress-bar {
        width: 75%;
        height: 20px;
        background-color: #f5f5f5;
        border-radius: 10px;
    }
    .progress {
        width: 0%;
        height: 100%;
        padding-top: 3%;
        background-color: #17c344;
        border-radius: 5px;
        transition: width 0.5s linear;
    }
    .custom-toast-top {
        top: 165px !important;
        right: 25px !important;
    }
    #toast-container > .toast-success {
        background-color: #4caf50 !important; 
    }
    #toast-container > .toast-error {
        background-color:#f44336 !important;
    }
</style>

@endsection

@section('breadcrumb-title')
    <h3>Import Family & Members</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Forms</li>
    <li class="breadcrumb-item active">Import Family & Members</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Please Note</h5>
                        <span>When importing data for families and family members via Excel, manual validation is essential. It's mandatory to thoroughly review the details for accuracy, ensuring error-free data for future use.
                        </span>
                    </div>

                     @if($errors->any())
                        <h6 style="color:red;padding: 20px 0px 0px 30px;">{{$errors->first()}}</h6>
                     @endif

                     @if (Session::has('success'))
                        <div id="success-message" class="alert alert-success">
                           <ul>
                              <li>{!! Session::get('success') !!}</li>
                           </ul>
                        </div>
                     @endif
                      @if (Session::has('error'))
                        <div id="error-message" class="alert alert-danger">
                           <ul>
                              <li>{!! Session::get('error') !!}</li>
                           </ul>
                        </div>
                     @endif
                        <div style="display: flex;justify-content: center;">
                            
                                <div class="progress-bar" style="margin-top: 50px;">
                                    <div class="progress" id="progress"></div>
                                </div>
                        </div>
                    <div class="card-body d-flex justify-content-center align-items-center" 
                            style="padding:55px 30px 100px 30px!important;">
                        <form class="needs-validation" novalidate="" action="{{route('admin.family.members.Import.store')}}" method="Post" id="import-form">
                        	@csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="validationCustom01">Excel Document</label>
                                    <input class="form-control" id="validationCustom01" type="file" required="" name='excel_file'>
                                </div>
                            </div> 
                            <div class="row g-3 mb-3">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit">Import</button>
                                    <a class="btn btn-primary" onclick="window.location='{{ route('admin.family.list') }}'">Cancel</a> 
                                </div> 
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>

<script type="text/javascript">

    toastr.options = {
        "progressBar": true,
        "positionClass" : "toast-top-right custom-toast-top",
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
    };

    $(document).ready(function(){

        $(".progress-bar").hide(); 
        var progressInterval;

        $('#import-form').submit(function(event) {
            event.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            progressInterval =setInterval(updateProgress, 100);

            $.ajax({
                type: "POST",
                url: url,
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {

                    clearInterval(progressInterval); // Stop polling

                    if(data[0].result=="Success"){
                        toastr.success("Successfully Imported.")
                    }else if(data[0].result=="Failed"){
                        toastr.error(data[0].message)
                    }else{
                        toastr.error("Failed")
                    }
                },
                error: function(xhr, status, error) {
                    
                    clearInterval(progressInterval);
                    var response = JSON.parse(xhr.responseText);
                    var errorMsg = response.errors;
                    toastr.error(errorMsg);
                }
            });

        });

        function updateProgress() {
            $.ajax({
                type: "Post",
                url: "{{ route('import.progress') }}",
                data:{ 
                   _token    : "<?= csrf_token() ?>",
                },
                success: function(data) {
                    $(".progress-bar").show(); 
                    $('.progress').css('width', data.progress + '%');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching progress status.");
                }
            });
        }
    });
    
</script>

@endsection