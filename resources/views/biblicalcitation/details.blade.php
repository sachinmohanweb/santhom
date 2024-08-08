@extends('layouts.simple.master')
@section('title', 'Biblical Citation Details')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Biblical Citation Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Biblical Citation Details</li>
@endsection

@section('content')
<div class="container-fluid">
   <div>
     <div class="row product-page-main p-0">
       <div class="col-xxl-12 box-col-6 order-xxl-0 order-1">
         <div class="card">
          @if($BiblicalCitation)
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
                   <h3>{{date("d/m/Y", strtotime($BiblicalCitation->date))}}</h3>
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
                  <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" data-bs-toggle="modal" data-bs-target="#EditbiblecitationModal">
                  Edit Biblical Citation Details
                </a>

              </div>
            </div>

             <hr>

             <div class="row">
                <div class="col-md-9">

                   <table class="product-page-width"  style="border-collapse: separate;border-spacing: 20px;">
                     <tbody>
                       <tr>
                         <td> <b>Reference</b></td>
                         <td> <b>&nbsp;:&nbsp;</b></td>
                         <td>{{$BiblicalCitation->reference}}
                         
                         </td>
                       </tr>
                       <tr>
                         <td> <b>Note  </b></td>
                          <td> <b> &nbsp;:&nbsp;</b></td>
                         <td class="txt-success">{{$BiblicalCitation->note1}}</td>
                       </tr>
                      
                       <tr>
                         <td> <b>Other Details  </b></td>
                          <td> <b> &nbsp;:&nbsp;</b></td>
                         <td>{{$BiblicalCitation->note2}}</td>
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


@if($BiblicalCitation)

 <div class="modal fade" id="EditbiblecitationModal" tabindex="-1" role="dialog" aria-labelledby="EditEventModalArea" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px !important;"> 
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title">Biblical Citation Details</h5>
             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="needs-validation" novalidate="" action="{{route('admin.biblical.citation.update',['id'=>$BiblicalCitation->id])}}" method="Post" enctype="multipart/form-data">
          <div class="modal-body">
              @csrf

              <div class="row mb-2">
                <div class="profile-title">
                  <div class="media-body">
                    <div class="row">
                      <div class="col-md-4">
                        <label class="form-label">Date<span style="color:red">*</span></label>
                        <input class="form-control" type="date" placeholder="date" name="date" 
                            value="{{$BiblicalCitation->date}}" required>
                      </div>
                      <div class="col-md-4 pd_left_zero">

                        <label class="form-label">Note</label>
                        <input class="form-control" placeholder="Note" name="note1" value="{{$BiblicalCitation->note1}}" >
                      </div>
                       <div class="col-md-4 pd_left_zero">

                        <label class="form-label">Other details</label>
                        <input class="form-control" placeholder="Other details" name="note2" value="{{$BiblicalCitation->note2}}">
                      </div>
                    </div><br>
                    <div class="row">

                      <div class="col-md-12">
                        <label class="form-label">Reference<span style="color:red">*</span></label>
                        <textarea class="form-control" id="reference" name="reference" rows="5" required>{{$BiblicalCitation->reference}}"</textarea ><br>
                        <div class="valid-feedback">Looks good!</div>
                      </div>
                    </div>

                  </div>
                </div>
              </div> 
 
              <div class="form-footer">
                <button class="btn btn-primary">Save</button>

                <a class="btn btn-primary" onclick="window.location='{{ route('admin.biblical.citation.list') }}'">Cancel</a>
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