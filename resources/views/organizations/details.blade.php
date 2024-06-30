@extends('layouts.simple.master')
@section('title', 'Family')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Organization Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Organization Details</li>
@endsection

@section('content')
<div class="container-fluid">
   <div>
     <div class="row product-page-main p-0">
       <div class="col-xxl-12 box-col-6 order-xxl-0 order-1">
         <div class="card">
          @if($organization)
           <div class="card-body">
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
            <div class="row">
              <div class="col-md-9">

                 <div class="product-page-details">
                   <h3>{{$organization->organization_name}}</h3>
                 </div>
                 <ul class="product-color">
                   <li class="bg-primary"></li>
                   <li class="bg-secondary"></li>
                   <li class="bg-success"></li>
                   <li class="bg-info"></li>
                   <li class="bg-warning"></li>
                 </ul>
                
              </div>
              <div class="col-md-3">         
                  <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" 
                  onClick="editFunc({{ $organization['id'] }})">
                  Edit Organization Details
                </a>

              </div>
            </div>

             <hr>

             <div>
               <table class="product-page-width">
                 <tbody>
                   
                   <tr>
                     <td> <b>Coordinator  </b></td>
                      <td> <b> &nbsp;:&nbsp;</b></td>
                     <td>{{$organization->coordinator}}</td>
                   </tr>
                   <tr>
                     <td> <b>Coordinator's Phone  </b></td>
                      <td> <b> &nbsp;:&nbsp;</b></td>
                     <td>{{$organization->coordinator_phone_number}}</td>
                   </tr>
                  
                 </tbody>
               </table>
             </div>
             <hr>
             <div class="row">
               <div class="col-md-9">
                 <h6 class="product-title">Organization's Officers</h6>
               </div>
               <div class="col-md-3">
                 <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500"data-bs-original-title="" onClick="AddOfficerFunc()">Add New officer</a>
              </div>
             </div>
             <div class="card-block row" style="margin: 10px;">
                    <div class="col-sm-9 col-lg-9 col-xl-9">
                      <div class="table-responsive">
                        <table class="table table-light">
                          <thead>
                            <tr>
                              <th scope="col">Id</th>
                              <th scope="col">Name</th>
                              <th scope="col">Position</th>
                              <th scope="col">Phone</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>

                            @foreach($organization->officers as $key=>$value)
                            <tr>
                              <th scope="row">{{$key+1}}</th>
                              <td>
                                  {{$value->member_name}}
                              </td>
                              <td>{{$value->position}} </td>

                              <td>{{$value->officer_phone_number}} </td>
                              <td>
                                <a onClick="editOrgMemberFunc({{$value['id'] }})"  data-toggle="tooltip" 
                                data-original-title="View" class="edit btn btn-primary btn-sm view">
                                  <i class="fa fa-edit"></i>Edit
                                </a>

                                <a href="javascript:void(0);" id="delete-compnay" 
                                onClick="deleteFunc({{ $value['id'] }})" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger btn-sm">
                                  <i class="fa fa-trash"></i>Delete
                                </a>
                              </td>
                              
                            </tr>
                          @endforeach 
                           
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
             <hr>
           </div>
           @endif
         </div>
       </div>
     </div>
   </div>
 </div>


@if($organization)
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
                          <label class="form-label" for="validationCustom02">Coordinator</label>
                          <select class="js-data-example-ajax form-select coordinator_edit"  
                          id="coordinator_id_edit"  name="coordinator_id"></select>
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

@endif


<div class="modal fade" id="AddOrganizationOfficerModal" tabindex="-1" role="dialog" aria-labelledby="AddOrganizationOfficerModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Officer Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate="" action="{{route('admin.organization.officer.store')}}" method="Post">
                    <div class="modal-body">
                    @csrf

                    <input type="hidden" name="organization_id" value="{{$organization->id}}">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Member</label>
                          <select class="js-data-example-ajax form-select member_id"  name="member_id" required></select>
                          <div class="valid-feedback">Looks good!</div>
                          <div class="invalid-feedback" style="color:red">Please select a member</div>

                        </div>
                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Position</label>
                          <input class="form-control" id="coordinator_edit" type="text" name='position' required>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">officer's Phone</label>
                          <input class="form-control" type="text" 
                          name='officer_phone_number' id="officer_phone_number">
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="window.location='{{ route('admin.organizations.list') }}'">Close</button>
                        <button class="btn btn-success" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="EditOrganizationOfficerModal" tabindex="-1" role="dialog" aria-labelledby="AddOrganizationOfficerModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Officer Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" id="EditOrganizationOfficerForm" novalidate="" 
                        action="{{route('admin.organization.officer.update')}}" method="Post">
                    <div class="modal-body">
                    @csrf

                    <input type="hidden" name="organization_id" value="{{$organization->id}}">
                    <input type="hidden" name="org_ofc_id" id="org_ofc_id" value="">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Member</label>
                          <select class="js-data-example-ajax form-select member_id"  name="member_id" required
                          id="member_id_edit" ></select>
                          <div class="valid-feedback">Looks good!</div>
                          <div class="invalid-feedback" style="color:red">Please select a member</div>

                        </div>
                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Position</label>
                          <input class="form-control" id="position_edit" type="text" name='position' required>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">officer's Phone</label>
                          <input class="form-control" type="text" 
                          name='officer_phone_number' id="officer_phone_number_edit">
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
<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/js/rating/jquery.barrating.js')}}"></script>
<script src="{{asset('assets/js/rating/rating-script.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/ecommerce.js')}}"></script>
<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>

<script type="text/javascript">
    function editFunc(id){
        $.ajax({
            type:"post",
            url: "{{ route('admin.get.organizations') }}",
            data: { _token : "<?= csrf_token() ?>",
                    id     : id
            },
            dataType: 'json',
            success: function(res){
                $('#organization_name_edit').attr('value', res.organization_name);

                if(res.coordinator_id){
                    var leaderId = res.coordinator_id;
                    var leaderName = res.coordinator;
                    var newOption = new Option(leaderName, leaderId, true, true);

                    $('#coordinator_id_edit').append(newOption).trigger('change');
                }
                $('#leader_phone_number_edit').val(res.leader_phone_number);

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

    $('.coordinator_edit').on('select2:select', function(e) {

            var selectedCoordinatorId = e.params.data.id;
            $.ajax({
                url: "<?= url('get_member_phone_number') ?>",
                method: 'post',
                data: {
                    _token: "<?= csrf_token() ?>",
                    member_id: selectedCoordinatorId
                },
                success: function(response) {
                    if(response.phone !== null){
                        $('#coordinator_phone_number_edit').val(response.phone);
                    }else{
                        $('#coordinator_phone_number_edit').attr('placeholder', 'Contact Number not available');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching coordinator's phone number:", error);
                }   
            });
        });

    function AddOfficerFunc(){
        
        $('#AddOrganizationOfficerModal').modal('show');
    }

    $('.member_id').select2({
        dropdownParent: $('#AddOrganizationOfficerModal'),
        placeholder: "Select Member",
        ajax: {

            url: "<?= url('get_family_members_list') ?>",
            dataType: 'json',
            method: 'post',
            delay: 250,

             data: function(data) {
                return {
                    _token    : "<?= csrf_token() ?>",
                    search_tag: data.term,
                    page: 'obituary',
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: { more: (params.page * 30) < data.total_count }
                };
            },
            cache: true
        }
    });

    $('.member_id').on('select2:select', function(e) {

        var selectedCoordinatorId = e.params.data.id;
        $.ajax({
            url: "<?= url('get_member_phone_number') ?>",
            method: 'post',
            data: {
                _token: "<?= csrf_token() ?>",
                member_id: selectedCoordinatorId
            },
            success: function(response) {
                if(response.phone !== null){
                    $('#officer_phone_number').val(response.phone);
                }else{
                    $('#officer_phone_number').attr('placeholder', 'Contact Number not available');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching coordinator's phone number:", error);
            }   
        });
    });

    $('.coordinator_edit').select2({
        dropdownParent: $('#EditOrganizationsModal'),
        placeholder: "Select coordinator",
        ajax: {

            url: "<?= url('get_family_members_list') ?>",
            dataType: 'json',
            method: 'post',
            delay: 250,

             data: function(data) {
                return {
                    _token    : "<?= csrf_token() ?>",
                    search_tag: data.term,
                    page: 'obituary',
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: { more: (params.page * 30) < data.total_count }
                };
            },
            cache: true
        }
    });

    $('#member_id_edit').select2({
        dropdownParent: $('#EditOrganizationOfficerModal'),
        placeholder: "Select coordinator",
        ajax: {

            url: "<?= url('get_family_members_list') ?>",
            dataType: 'json',
            method: 'post',
            delay: 250,

             data: function(data) {
                return {
                    _token    : "<?= csrf_token() ?>",
                    search_tag: data.term,
                    page: 'obituary',
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: { more: (params.page * 30) < data.total_count }
                };
            },
            cache: true
        }
    });

    $('#member_id_edit').on('select2:select', function(e) {

        var selectedCoordinatorId = e.params.data.id;
        $.ajax({
            url: "<?= url('get_member_phone_number') ?>",
            method: 'post',
            data: {
                _token: "<?= csrf_token() ?>",
                member_id: selectedCoordinatorId
            },
            success: function(response) {
                if(response.phone !== null){
                    $('#officer_phone_number_edit').val(response.phone);
                }else{
                    $('#officer_phone_number_edit').attr('placeholder', 'Contact Number not available');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching coordinator's phone number:", error);
            }   
        });
    });

    function deleteFunc(id){
      if (confirm("Are you sure? Delete this officer details?") == true) {
          var id = id;
          $.ajax({
              type:"POST",
              url: "{{ route('admin.organization.officer.delete') }}",
              data: { _token : "<?= csrf_token() ?>",
                      id     : id
              },
              dataType: 'json',
              success: function(res){
                  if (res.status=='success'){
                      window.location.href ="{{ route('admin.organizations.list') }}";
                  }else{
                      window.location.href ="{{ route('admin.organizations.list') }}";
                      alert('Failed to delete officer. Please try again later.');
                  }
              },
              error: function(xhr, status, error) {
                  console.error('AJAX request failed:', status, error);
                  alert('Failed to delete officer. Please try again later.');
              }
          });
      }
    }

    function editOrgMemberFunc(id){
        $.ajax({
            type:"post",
            url: "{{ route('admin.get.organization.officers') }}",
            data: { _token : "<?= csrf_token() ?>",
                    id     : id
            },
            dataType: 'json',
            success: function(res){
                $('#organization_name_edit').attr('value', res.organization_name);

                if(res.member_id){
                    var memberId = res.member_id;
                    var memberName = res.member_name;
                    var position = res.position;
                    var newOption = new Option(memberName, memberId, true, true);

                    $('#member_id_edit').append(newOption).trigger('change');
                }
                $('#position_edit').val(res.position);
                $('#officer_phone_number_edit').val(res.officer_phone_number);
                $('#org_ofc_id').val(id);


                $('#EditOrganizationOfficerModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed:', status, error);
                alert('Failed get data. Please try again later.');
            }
        });
    
    }
</script>
@endsection