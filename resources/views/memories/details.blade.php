@extends('layouts.simple.master')
@section('title', 'Memories Details')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Memories Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item ">Memories Details</li>
@endsection

@section('content')
<div class="container-fluid">
   <div>
     <div class="row product-page-main p-0">
       <div class="col-xxl-12 box-col-6 order-xxl-0 order-1">
         <div class="card">
          @if($Memory)
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
                   <h3>{{$Memory->date}}</h3>
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
                  <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditmemoryModal">
                  Edit Memory details
                </a>

              </div>
            </div>

             <hr>

             <div class="row">
                <div class="col-md-9">

                   <table class="product-page-width"  style="border-collapse: separate;border-spacing: 20px;">
                     <tbody>
                       <tr>
                         <td> <b>Memory Type</b></td>
                         <td> <b>&nbsp;:&nbsp;</b></td>
                         <td>{{$Memory->memory_day_type_name}}
                         
                         </td>
                       </tr>
                       <tr>
                         <td> <b>Title  </b></td>
                          <td> <b> &nbsp;:&nbsp;</b></td>
                         <td class="txt-success">{{$Memory->title}}</td>
                       </tr>
                      <tr>
                         <td> <b>Note  </b></td>
                          <td> <b> &nbsp;:&nbsp;</b></td>
                         <td>{{$Memory->note1}}</td>
                       </tr>
                       <tr>
                         <td> <b>Other Details  </b></td>
                          <td> <b> &nbsp;:&nbsp;</b></td>
                         <td>{{$Memory->note2}}</td>
                       </tr>
                     </tbody>
                   </table>
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


@if($Memory)

 <div class="modal fade" id="EditmemoryModal" tabindex="-1" role="dialog" aria-labelledby="EditEventModalArea" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title">Memory Details</h5>
             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="needs-validation" novalidate="" action="{{route('admin.memories.update',['id'=>$Memory->id])}}" method="Post" enctype="multipart/form-data">
          <div class="modal-body">
              @csrf
              <div class="row mb-2">
                <div class="profile-title">
                  <div class="media-body">
                    <div class="row">
                      <div class="col-md-4">
                        <label class="form-label">Memory Type</label>
                        <select class="form-control" name="memory_type_id" id="memory_type_id" required>
                          <option value="">--Select--</option>
                          @foreach($MemoryType as $key=>$value)
                              @if($value->id==$Memory['memory_type_id'])
                                  <option value="{{$value->id}}" selected>{{$value->type_name}}</option>
                              @else
                                  <option value="{{$value->id}}">{{$value->type_name}}</option>
                              @endif
                          @endforeach
                        </select>  
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Date<span style="color:red">*</span></label>
                        <input class="form-control" type="date" placeholder="date" name="date" required
                        value="{{$Memory->date}}">
                      </div>
                       <div class="col-md-4 pd_left_zero">

                        <label class="form-label"> Note</label>
                        <input class="form-control" placeholder="details" name="note1" value="{{$Memory->note1}}">
                      </div>
                    </div><br>
                    <div class="row">

                      <div class="col-md-12">
                        <label class="form-label">Title<span style="color:red">*</span></label>
                        <textarea class="form-control" id="title" name="title" rows="5" required>{{$Memory->title}}</textarea ><br>
                        <div class="valid-feedback">Looks good!</div>
                      </div>
                    </div>

                    <div class="row">

                      <div class="col-md-12">
                        <label class="form-label">More details</label>
                        <textarea class="form-control" id="note2" name="note2" rows="5">{{$Memory->note2}}</textarea><br>
                        <div class="valid-feedback">Looks good!</div>
                      </div>
                    </div>

                  </div>
                </div>
              </div> 
 
              <div class="form-footer">
                <button class="btn btn-primary">Save</button>

                <a class="btn btn-primary" onclick="window.location='{{ route('admin.memories.list') }}'">Cancel</a>
              </div>
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
@endsection