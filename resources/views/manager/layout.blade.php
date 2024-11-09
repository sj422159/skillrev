<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
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




  <link rel="icon" href='{{asset("dashboard/img/AdminLTELogo.png")}}' sizes="32x32" type="image/png">
      <link href='{{asset("registerexamform/css/font-face.css")}}' rel="stylesheet" media="all">
      <link href='{{asset("registerexamform/vendor/font-awesome-4.7/css/font-awesome.min.css")}}' rel="stylesheet" media="all">
      <link href='{{asset("registerexamform/vendor/font-awesome-5/css/fontawesome-all.min.css")}}' rel="stylesheet" media="all">
      <link href='{{asset("registerexamform/vendor/mdi-font/css/material-design-iconic-font.min.css")}}' rel="stylesheet" media="all">
      <!-- Bootstrap CSS-->
      <link href='{{asset("registerexamform/vendor/bootstrap-4.1/bootstrap.min.css")}}' rel="stylesheet" media="all">
      <!-- Vendor CSS-->
      <link href='{{asset("registerexamform/vendor/animsition/animsition.min.css")}}' rel="stylesheet" media="all">
      <link href='{{asset("registerexamform/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css")}}' rel="stylesheet" media="all">
      <link href='{{asset("registerexamform/vendor/wow/animate.css")}}' rel="stylesheet" media="all">
      <link href='{{asset("registerexamform/vendor/css-hamburgers/hamburgers.min.css")}}' rel="stylesheet" media="all">
      <link href='{{asset("registerexamform/vendor/slick/slick.css")}}' rel="stylesheet" media="all">
      <link href='{{asset("registerexamform/vendor/select2/select2.min.css")}}' rel="stylesheet" media="all">
      <link href='{{asset("registerexamform/vendor/perfect-scrollbar/perfect-scrollbar.css")}}' rel="stylesheet" media="all">
      <!-- Main CSS-->
      <link href='{{asset("registerexamform/css/theme.css")}}' rel="stylesheet" media="all">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



    <style type="text/css">
    body
       {
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
      <li class="nav-item" style="position: absolute;top: 10px !important;left:20px!important;">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     <li class="nav-item dropdown dropdown-hover">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="nav-link dropdown-toggle" style="color:#fff !important">Account</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left:auto; right:10px;">
              <li><a href="{{url('manager/profile')}}" class="dropdown-item">Change Password </a></li>
              <li><a href="{{url('manager/logout')}}" class="dropdown-item">Logout</a></li>
            </ul>
          </li>     
            
     
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:rgba(116, 52, 16, 1);">
    <!-- Brand Logo -->
   <a href="#" class="brand-link">
     <img src='{{asset("assets/images/clg.png")}}' alt="John Doe" alt="AdminLTE Logo"  style="width:40px;height:40px" />
      <span class="brand-text font-weight-dark" style="color:white;"><?Php echo session()->get('MANAGER_Name'); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      

      <!-- SidebarSearch Form -->
    

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item menu-open">
            <a  href="{{url('manager/dashboard')}}" class="nav-link" class="@yield('dashboard_select')">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
               Dashboard
              </p>
            </a>
          </li>

            <li class="nav-item">
            <a  href="{{url('manager/timetable')}}" class="nav-link" class="@yield('dashboard_select')">
              <i class="nav-icon fas fa-bookmark"></i>
              <p>
               Schedule
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link @yield('manage_select')">
              <i class="nav-icon fas fa-bookmark"></i>
              <p>
                Student Mgmt
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="#" type="button" onclick="studentdetails()" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Upload Students</p>
                </a>
              </li>
              <?php
                    use Illuminate\Support\Facades\DB;
                    $sesid=session()->get('MANAGER_ID');
                    $mail=DB::table('students')->where('mid',$sesid)->where('tmails',0)->get();
                    $result['mail']=count($mail);
                    
                   
              ?>
              @if($result['mail']>0)
              <li class="nav-item">
                <a href="{{url('manager/mails/trigger')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Trigger Mails</p>
                </a>
              </li>
              @endif
              <li class="nav-item">
            <a  href="{{url('manager/promote/section/students')}}" class="nav-link" class="nav-link @yield('report_select')">
              <i class="far fa-circle nav-icon"></i>
              <p>
              Section Transfer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  href="{{url('manager/promote/class/students')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
               Class Promotion
              </p>
            </a>
          </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link @yield('manage_select')">
              <i class="nav-icon fas fa-bookmark"></i>
              <p>
                Training Mgmt
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{url('manager/trainingprogram')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Trainings</p>
                </a>
              </li>
            </ul>
        </li>


        <li class="nav-item">
            <a href="#" class="nav-link @yield('manage_select')">
              <i class="nav-icon fas fa-bookmark"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
            <a  href="{{url('manager/leave')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
               Leave
              </p>
            </a>
          </li>
              <li class="nav-item">
              <a  href="{{url('manager/schedulelist')}}" class="nav-link" class="@yield('dashboard_schedule')">
              <i class="far fa-circle nav-icon"></i>
              <p>
               Time Table
              </p>
              </a>
              </li>
            </ul>
        </li>


        <li class="nav-item">
            <a href="#" class="nav-link @yield('manage_select')">
              <i class="nav-icon fas fa-bookmark"></i>
              <p>
                Classteacher Activity
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
          <li class="nav-item">
            <a  href="{{url('manager/distribution/reports')}}" class="nav-link" class="nav-link @yield('report_select')">
              <i class="far fa-circle nav-icon"></i>
              <p>Distribution</p>
            </a>
          </li>
            </ul>
      </li>


        <li class="nav-item">
            <a href="#" class="nav-link @yield('manage_select')">
              <i class="nav-icon fas fa-bookmark"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-hands-helping nav-icon"></i>
              <p>
                Fees Payment 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" >
               <li class="nav-item">
            <a href="{{url('manager/fees/pending')}}" class="nav-link" class="@yield('Questions_select')">
              <i class="far fa-circle nav-icon"></i>
              <p>
               Last Year Pending 
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{url('manager/fees/index/students')}}" class="nav-link" class="@yield('Questions_select')">
              <i class="far fa-circle nav-icon"></i>
              <p>
               Current Year Payment
              </p>
            </a>
          </li>

            </ul>
        </li>
          <li class="nav-item">
            <a  href="{{url('manager/reports')}}" class="nav-link" >
              <i class="far fa-circle nav-icon"></i>
              <p>Academic Reports</p>
            </a>
          </li>
          <li class="nav-item">
                <a  href="{{url('manager/assignments')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                Assignment Reports
                </p>
                </a>
              </li>
          <li class="nav-item">
            <a  href="{{url('manager/attendance/view/months')}}" class="nav-link" class="nav-link @yield('report_select')">
              <i class="far fa-circle nav-icon"></i>
              <p>Attendance Reports</p>
            </a>
          </li>

          <li class="nav-item">
            <a  href="{{url('manager/competition/reports')}}" class="nav-link" class="nav-link @yield('report_select')">
              <i class="far fa-circle nav-icon"></i>
              <p>
               Competition Reports
              </p>
            </a>
        </li>

            </ul>
        </li>


        <li class="nav-item">
            <a href="#" class="nav-link @yield('manage_select')">
              <i class="nav-icon fas fa-bookmark"></i>
              <p>
                Analytics
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-hands-helping nav-icon"></i>
              <p>
                Fees Payment 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" >
               <li class="nav-item">
            <a href="{{url('manager/analytics/pendingfees')}}" class="nav-link" class="@yield('Questions_select')">
              <i class="far fa-circle nav-icon"></i>
              <p>
               Pending Fees
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{url('manager/analytics/currentfees')}}" class="nav-link" class="@yield('Questions_select')">
              <i class="far fa-circle nav-icon"></i>
              <p>
               Current Year Payment
              </p>
            </a>
          </li>

            </ul>
        </li>
          <li class="nav-item">
            <a  href="{{url('manager/analytics')}}" class="nav-link" >
              <i class="far fa-circle nav-icon"></i>
              <p>Academic Analytics</p>
            </a>
          </li>

          <li class="nav-item">
            <a  href="{{url('manager/analytic/assignment')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
               Assignment Analytics
              </p>
            </a>
        </li>

          <li class="nav-item">
            <a  href="{{url('manager/analytics/attendance')}}" class="nav-link" class="nav-link @yield('report_select')">
              <i class="far fa-circle nav-icon"></i>
              <p>Attendance Analytics</p>
            </a>
          </li>

          <li class="nav-item">
            <a  href="{{url('manager/analytics/competition')}}" class="nav-link" class="nav-link @yield('report_select')">
              <i class="far fa-circle nav-icon"></i>
              <p>
               Competition Analytics
              </p>
            </a>
        </li>

            </ul>
        </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
    <section class="content">
      <div class="container-fluid" style="padding:10px!important;">
    <!-- Content Header (Page header) -->
    @section('container')
    @show 
  </div>
  </section>
</div>
</div>

  <!-- /.content-wrapper -->
 

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    function studentdetails() {
    swal({
    title: "Important Note",
    text: "Please Re-verify the details in Excel template before uploading",
    icon: "info",
    buttons:["cancel","continue"],
    dangerMode:false,
    closeOnClickOutside: false,
    allowOutsideClick: false,
    allowEscapeKey: false,
    }) .then((willDelete) => {
     if (willDelete) {
        window.location = "/manager/upload/student"; 
      }else{
         
      }
  });
    }

</script>

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




<script src="{{asset('registerexamform/vendor/jquery-3.2.1.min.js')}}"></script>
      <!-- Bootstrap JS-->
      <script src="{{asset('registerexamform/vendor/bootstrap-4.1/popper.min.js')}}"></script>
      <script src="{{asset('registerexamform/vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
      <!-- Vendor JS       -->
      <script src="{{asset('registerexamform/vendor/slick/slick.min.js')}}"></script>
      <script src="{{asset('registerexamform/vendor/wow/wow.min.js')}}"></script>
      <script src="{{asset('registerexamform/vendor/animsition/animsition.min.js')}}"></script>
      <script src="{{asset('registerexamform/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
      <script src="{{asset('registerexamform/vendor/counter-up/jquery.waypoints.min.js')}}"></script>
      <script src="{{asset('registerexamform/vendor/counter-up/jquery.counterup.min.js')}}"></script>
      <script src="{{asset('registerexamform/vendor/circle-progress/circle-progress.min.js')}}"></script>
      <script src="{{asset('registerexamform/vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
      <script src="{{asset('registerexamform/vendor/chartjs/Chart.bundle.min.js')}}"></script>
      <script src="{{asset('registerexamform/vendor/select2/select2.min.js')}}"></script>
      <!-- Main JS-->
      <script src="{{asset('registerexamform/js/main.js')}}"></script>
      <script src="{{asset('dashboard/plugins/chart.js/Chart.min.js')}}"></script>
      



</body>
</html>
