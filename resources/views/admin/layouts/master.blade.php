<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Admin Dashboard</title>
      <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css')}}">
      <link rel="stylesheet" href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css')}}">
      <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css')}}">
      <link rel="stylesheet" href="{{asset('css/vertical-layout-light/style.css')}}">
      <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
   </head>
   <body>
      <div class="container-scroller">         
         <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
               <div class="me-3">
                  <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                  <span class="icon-menu"></span>
                  </button>
               </div>
               <div>
                  <a class="navbar-brand brand-logo" href="#">
                  {{-- <img src="{{asset('images/logo.svg')}}" alt="logo" /> --}}
                  </a>
                  <a class="navbar-brand brand-logo-mini" href="#">
                  {{-- <img src="{{asset('images/logo-mini.svg')}}" alt="logo" /> --}}
                  </a>
               </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
               <ul class="navbar-nav">
                  <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                     <h1 class="welcome-text">Welcome, <span class="text-black fw-bold">{{Auth::user()->name ?? ""}}</span></h1>                     
                  </li>
               </ul>
               <ul class="navbar-nav ms-auto"> 
                  <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                     <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                     <img class="img-xs rounded-circle" src="{{asset('images/faces/face8.jpg')}}" alt="Profile image"> </a>
                     <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <div class="dropdown-header text-center">
                           <img class="img-md rounded-circle" src="{{asset('images/faces/face8.jpg')}}" alt="Profile image">
                           <p class="mb-1 mt-3 font-weight-semibold">{{Auth::user()->name ?? ""}}</p>
                           <p class="fw-light text-muted mb-0">{{Auth::user()->email ?? ""}}</p>
                        </div>
                        {{-- <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span class="badge badge-pill badge-danger">1</span></a> --}}
                        <a href="{{route('logout')}}" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
                     </div>
                  </li>
               </ul>
               <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
               <span class="mdi mdi-menu"></span>
               </button>
            </div>
         </nav>
         <!-- partial -->
         <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
               <ul class="nav">
                  <li class="nav-item">
                     <a class="nav-link" href="{{route('dashboard')}}">
                     <i class="mdi mdi-grid-large menu-icon"></i>
                     <span class="menu-title">Dashboard</span>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="{{route('plans.index')}}">
                     <i class="mdi mdi-grid-large menu-icon"></i>
                     <span class="menu-title">Plans</span>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="{{route('subscriptions.index')}}">
                     <i class="mdi mdi-grid-large menu-icon"></i>
                     <span class="menu-title">Subscriptions</span>
                     </a>
                  </li>
               </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                
                @yield('content')


               <!-- content-wrapper ends -->
               <!-- partial:../../partials/_footer.html -->
               <footer class="footer">
                  <div class="d-sm-flex justify-content-center justify-content-sm-between">
                      
                     <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © {{date('Y')}}. All rights reserved.</span>
                  </div>
               </footer>
               <!-- partial -->
            </div>
            <!-- main-panel ends -->
         </div>
         <!-- page-body-wrapper ends -->
      </div>
      <!-- container-scroller -->
      <!-- plugins:js -->
      <script src="{{ asset('vendors/js/vendor.bundle.base.js')}}"></script>
      <!-- endinject -->
      <!-- Plugin js for this page --> 
      <!-- End plugin js for this page -->
      <!-- inject:js -->  
      <script src="{{asset('js/template.js')}}"></script>
      <script src="{{asset('https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js')}}"></script>
       
      @stack('js')
   </body>
</html>