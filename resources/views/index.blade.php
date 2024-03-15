@extends('layouts.authentication.master')
@section('title', 'Login')

@section('css')
@endsection

@section('style')
<style type="text/css">
    .login_img{
        max-width:35% !important;
    }
    .logo{
        margin-bottom: 0px !important;
    }
    .login-card {
         min-height: 100vh  !important;
         display: flex  !important;
         align-items: center  !important;
         justify-content: center  !important;
         margin: 0 auto  !important;
         background: url("https://santhom.intellyze.in/public/assets/images/login/login_bg.jpg") !important;
         background-position: center  !important;
         padding: 30px 12px  !important;
      }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
   <div class="row m-0">
      <div class="col-12 p-0">
         <div class="login-card" style="ba">
            <div>
               <div class="login-main" style="background: url('../images/login/login_bg.jpg') !important;">
               <div><a class="logo" href="">
                  <img class="img-fluid for-light login_img" src="{{asset('assets/images/logo/logo.svg')}}" alt="looginpage" width="100%">
                  <img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo.svg')}}" alt="looginpage" width="100%"></a>
               </div>
                  <form class="theme-form" action="{{ route('admin.login') }}" method="Post">
                     @csrf
                     <h4 class="text-center">Welcome Admin</h4>
                     <p class="text-center">Please enter your login details</p>

                     @if (Session::has('success'))
                        <div class="alert alert-success">
                           <ul>
                              <li>{!! \Session::get('success') !!}</li>
                           </ul>
                        </div>
                     @endif

                     @if(session('error'))
                         <div class="alert alert-danger">
                             {{ session('error') }}
                         </div>
                     @endif

                     @if($errors->any())
                        <h6 style="color:red">{{$errors->first()}}</h6>
                     @endif
                     
                     <div class="form-group">
                        <label class="col-form-label">Email Address</label>
                        <input class="form-control" type="email" required="" placeholder="Test@gmail.com" name="email">
                     </div>
                     <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <input class="form-control" type="password" name="password" required="" placeholder="*********">
                        <div class="show-hide">
                           <span class="show">
                           </span></div>
                     </div>
                     <div class="form-group mb-0">
                        <div class="checkbox p-0">
                           <input id="checkbox1" type="checkbox" name="remember_password">
                           <label class="text-muted" for="checkbox1">Remember password</label>
                        </div>
                        <a class="link" href="">Forgot password?</a>
                        <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                     </div>
                     
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection