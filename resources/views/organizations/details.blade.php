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
                 <h6 class="product-title">Organizations Officers</h6>
               </div>
               <div class="col-md-3">
                 <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('admin.family.member.create.family_id',['family_id' => $organization['id']])}}" data-bs-original-title="" title="">Add New officer</a>
              </div>
             </div>
             <div class="card-block row" style="margin: 10px;">
                    <div class="col-sm-8 col-lg-8 col-xl-8">
                      <div class="table-responsive">
                        <table class="table table-light">
                          <thead>
                            <tr>
                              <th scope="col">Id</th>
                              <th scope="col">Name</th>
                              <th scope="col">Position</th>
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

                              <td>{{$value->position}} </td>
                              
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
                          <label class="form-label" for="validationCustom02">Group Leader</label>
                          <input class="form-control" id="coordinator_edit" type="text" name='coordinator'>
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
                    $('#coordinator_edit').val(res.coordinator);
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
</script>
@endsection