
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Application">
    <meta name="keywords" content="Application">
    <meta name="author" content="PIXINVENT">
    <title>Clinic Online - Versi 1.00</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('baru/images/favicon.png') }}">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('baru/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('baru/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('baru/css/bootstrap-icons.css') }}">  
    

    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
        <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
            <br/>
            <div class="content-body">
                <section class="row flexbox-container px-1 py-1">
                    <div class="col-lg-12 col-12 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-lg mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block  text-center align-self-center px-1 py-0">
                                    <img src="{{ asset('baru/images/logologin.png') }}" class="img-fluid" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-lg mb-0 px-2">
                                        <div class="d-flex justify-content-center mt-2">
                                            <img src="{{ asset('baru/images/logo3.png') }}" class="" alt="branding logo">
                                        </div>
                                        <div class="card-header pb-1 mt-1">
                                            
                                            <div class="d-flex justify-content-center mt-2">
                                           
                                                <h2 class='mb-0 success text-bold-600 font-large-1' align="center">Clinic Online</h2>
                                            </div>
                                        </div>
                                        <p class="px-2"></p>
                                        <div class="card-content mb-3">
                                            <div class="card-body pt-1">
                                                    <form method="POST" action="{{ route('login') }}" id="id-form" class="form-btn-disabled">
                                                    @csrf
                                                    <fieldset class="col-12 form-label-group form-group position-relative has-icon-left">
                                                        <div class="col-12 form-check-inline">

                                                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Nomer KTA" autofocus autocomplete="off">

                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror

                                                        </div>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user success"></i>
                                                        </div>
                                                        <label for="user-name">Username</label>
                                                        <div>
                                                                                                                    </div>
                                                    </fieldset>

                                                    <fieldset class="col-12 form-label-group position-relative has-icon-left">
                                                        <div class="col-12 form-check-inline" id="show_hide_password">                                                      
                                                            <input id="password" type="password" placeholder="Password"  class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                            <div class="input-group-append">
                                                            <a href="" class="btn btn-outline-secondary"><i class="bi-eye-slash" aria-hidden="true" fa-lg></i></a>
                                                            </div>
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror                                                       
                                                       
                                                        </div>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock success"></i>
                                                        </div>
                                                        <label for="user-password">Password</label>
                                                    </fieldset>

                                                    <div class="form-group d-flex justify-content-between align-items-center">
                                                        <div class="text-left">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-success">
                                                                    <input type="checkbox" class="form-checkbox" id="form-checkbox">
                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span class="">Remember Password</span>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="text-right"><a class="reset_pass" href="#">Forgot Password?</a></div>
                                                    </div>
                                                    <button type="submit" id="" class="btn-disabled btn btn-success float-left btn-inline mb-50 col-sm-auto">Login</button></button>                                                    
                                                </form>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('baru/js/jquery-3.5.1.slim.min.js') }}" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="{{ asset('baru/js/bootstrap.bundle.min.js') }}" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_password input').attr("type") == "text"){
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass( "bi bi-eye-slash" );
                    $('#show_hide_password i').removeClass( "bi bi-eye" );
                }else if($('#show_hide_password input').attr("type") == "password"){
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass( "bi bi-eye-slash" );
                    $('#show_hide_password i').addClass( "bi bi-eye" );
                }
            });
            });
        </script>
    </body>
    <script src="{{ asset('baru/js/login.js') }}"></script>
    <script src="{{ asset('baru/js/global.js') }}"></script>
     <script src="{{ asset('baru/js/api.js') }}"></script>

   
</body>
<!-- END: Body-->

</html>

@endsection
