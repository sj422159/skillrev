<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('page_title')</title>
  <link rel="icon" href='{{asset("dashboard/img/AdminLTELogo.png")}}' sizes="32x32" type="image/png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href='{{asset("dashboard/css/all.min1.css")}}'>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href='{{asset("dashboard/css/tempusdominus-bootstrap-4.min.css")}}'>
  <!-- iCheck -->
  <link rel="stylesheet" href='{{asset("dashboard/css/icheck-bootstrap.min.css")}}'>
  <!-- JQVMap -->
  <link rel="stylesheet" href='{{asset("dashboard/css/jqvmap.min.css")}}'>
  <!-- Theme style -->
  <link rel="stylesheet" href='{{asset("dashboard/css/adminlte.min.css")}}'>
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href='{{asset("dashboard/css/OverlayScrollbars.min.css")}}'>
  <!-- Daterange picker -->
  <link rel="stylesheet" href='{{asset("dashboard/css/daterangepicker.css")}}'>
  <!-- summernote -->
  <link rel="stylesheet" href='{{asset("dashboard/css/summernote-bs4.min.css")}}'>
  <link rel="stylesheet" href='{{asset("dashboard/dist/css/adminlte.min.css")}}'>
  <link rel="stylesheet" href='{{asset("dashboard/plugins/fontawesome-free/css/all.min1.css")}}'>
   <style type="text/css">
    body{
        overflow: scroll !important;
    overflow-x: hidden !important;
    }
     .nav-item a{
      color: #00000090 !important;
      transition: 0.4s;
    }
    .nav-item a:hover{
      color: #000 !important;
    }
     ul li a i{
        color:#fff !important;
    }
    ul li a p{
        color:#fff !important;
        font-size:15px !important;
    }
    .extra{
    background-color: rgba(255,255,255,.1) !important;
    color:#fff !important;
  }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-image: linear-gradient(to right, #743410,#c99b1c );">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item dropdown dropdown-hover">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="nav-link dropdown-toggle" style="color:#fff !important">Account</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left:auto; right:10px;">
              <li><a href="{{url('employee/marketingofficer/profile')}}" class="dropdown-item">Change Password </a></li>
              <li><a href="{{url('employee/marketingofficer/logout')}}" class="dropdown-item">Logout</a></li>
            </ul>
          </li>
    </ul>
  </nav>
  

  <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:rgba(116, 52, 16, 1);">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src='{{asset("dashboard/img/AdminLTELogo.png")}}' alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-dark" style="color:#fff;"><?Php echo session()->get('INTERNAL_MARKETINGOFFICER_Fname'); ?> <?php echo session()->get('MARKETINGOFFICER_Lname');  ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="display: none!important;">
        <div class="image">
          <img src='{{asset("dashboard/img/AdminLTELogo.png")}}' class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="" class="d-block">Deepak</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
    

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="{{url('employee/marketingofficer/dashboard')}}"  class="nav-link @yield('dashboard')">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          
          


         
  

         
          
           
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @section('container')
    @show 
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021-2030 <a href="">SkillRevealation</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src='{{asset("dashboard/plugins/jquery/jquery.min.js")}}'></script>
<!-- jQuery UI 1.11.4 -->
<script src='{{asset("dashboard/plugins/jquery-ui/jquery-ui.min.js")}}'></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src='{{asset("dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js")}}'></script>
<!-- ChartJS -->
<script src='{{asset("dashboard/plugins/chart.js/Chart.min.js")}}'></script>
<!-- Sparkline -->
<script src='{{asset("dashboard/plugins/sparklines/sparkline.js")}}'></script>
<!-- JQVMap -->
<script src='{{asset("dashboard/plugins/jqvmap/jquery.vmap.min.js")}}'></script>
<script src='{{asset("dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js")}}'></script>
<!-- jQuery Knob Chart -->
<script src='{{asset("dashboard/plugins/jquery-knob/jquery.knob.min.js")}}'></script>
<!-- daterangepicker -->

<script src='{{asset("dashboard/plugins/moment/moment.min.js")}}'></script>
<script src='{{asset("dashboard/plugins/daterangepicker/daterangepicker.js")}}'></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src='{{asset("dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}'></script>
<!-- Summernote -->
<script src='{{asset("dashboard/plugins/summernote/summernote-bs4.min.js")}}'></script>
<!-- overlayScrollbars -->
<script src='{{asset("dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}'></script>
<!-- AdminLTE App -->
<script src='{{asset("dashboard/js/adminlte.js")}}'></script>
<!-- AdminLTE for demo purposes -->
<script src='{{asset("dashboard/js/demo.js")}}'></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src='{{asset("dashboard/js/dashboard.js")}}'></script>
</body>
</html>
