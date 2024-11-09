<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Exam</title>
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
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
       <style type="text/css">
            
       </style>
</head>
<body>

<div  style="display:flex;padding:10px !important;margin-top: 20px;">
  <div style="width:300px;display:flex;flex-direction: column;"><h3 style="color:orangered;"><b>SKILL REVELATION</b></h3></div>
  <div  style="text-align:center;width: 600px;">
    <h3 style="font-weight: bold;">{{$name[0]->assesmentname}}</h3>
  </div>
  <div style="width:240px;text-align: right;">
    <h7>EMPLOYBILITY BENCHMARK STANDARD</h7>
  </div>
</div>
  <div Class="row" style="margin:0px">

<div class="col-2">
<div class="row" style="padding:20px;display: flex;align-items: center;justify-content: center;flex-direction: column;">
 <div class="widget-user-image" style="height:300px;width:180px">
                @foreach($studentimage as $list)
                <img class="img-circle elevation-2" src="{{asset('studentimages')}}/{{$list->image}}" alt="User Avatar">
                @endforeach
              </div>

</div>
</div>




<div class="col-6" style="padding:10px;padding-top: 20px;display: flex;align-items: center;flex-direction: column;">
    <h4>ASSESMENT-SWOT ANALYSIS</h4>
  <div class="row">
      <div style="width:240px;display:flex;align-items:center;flex-direction:column;border:5px solid #00000060;padding:5px ;margin: 3px;">
          <!-- <div>Confident-Correct</div> -->
          <div class="row" style="display:flex;align-items:center"><h3>{{$a}}%</h3>
          
           @if($a>70)
            <i class="fas fa-thumbs-up" style="font-size:40px;margin:5px;color:green;"></i>
           @elseif($a<70 && $a>30)
           <i class="fas fa-hand-point-up"  style="font-size:40px;margin:5px;color:blue;"></i>
           @elseif($a<30)
             <i class="fas fa-thumbs-down" style="font-size:40px;margin:5px;color:red;"></i>
           @endif

          </div>
          <div style="color:green"><b>STRENGTH</b></div>
      </div>
      
      <div style="width: 240px;display:flex;align-items:center;flex-direction:column;border:5px solid #00000060;padding:5px ;margin: 3px;">
         <!--  <div>Confident-Wrong</div> -->
          <div class="row" style="display:flex;align-items:center"><h3>{{$b}}%</h3>
           @if($b>60)
            <i class="fas fa-thumbs-down" style="font-size:40px;margin:5px;color:red;"></i>
           @elseif($b<60 && $b>30)
           <i class="fas fa-hand-point-up"  style="font-size:40px;margin:5px;color:blue;"></i>
           @elseif($b<30)
             <i class="fas fa-thumbs-up" style="font-size:40px;margin:5px;color:green;"></i>
           @endif
           </div>
          <div style="color:red;"><b>THREAT</b></div>
      </div>
     
     
  </div>
  <div class="row">
      
        <div style="width: 240px;display:flex;align-items:center;flex-direction:column;border:5px solid #00000060;padding:5px ;margin: 3px;">
       
          <!-- <div>Not Confident-Correct</div> -->
          <div class="row" style="display:flex;align-items:center"><h3>{{$c}}%</h3>
             @if($c>70)
            <i class="fas fa-thumbs-down"style="font-size:40px;margin:5px;color:red;"></i>
           @elseif($c<70 && $c>30)
           <i class="fas fa-hand-point-up" style="font-size:40px;margin:5px;color:blue;"></i>
           @elseif($c<30)
             <i class="fas fa-thumbs-up"style="font-size:40px;margin:5px;color:green;"></i>
           @endif
            </div>
          <div style="color:orange"><b>WEAKNESS</b></div>
      </div>

       <div style="width: 240px;display:flex;align-items:center;flex-direction:column;border:5px solid #00000060;padding:5px ;margin: 3px;">
         <!--  <div>Not Confident-Wrong</div> -->
          <div class="row" style="display:flex;align-items:center"><h3>{{$d}}%</h3>
          
            @if($d>70)
             <i class="fas fa-thumbs-up"style="font-size:40px;margin:5px;color:green;"></i>
           
           @elseif($d<70 && $d>30)
           <i class="fas fa-hand-point-up" style="font-size:40px;margin:5px;color:blue;"></i>
           @elseif($d<30)
             <i class="fas fa-thumbs-down"style="font-size:40px;margin:5px;color:red;"></i>
           @endif
           </div>
          <div style="color:blue"><b>OPPORTUNITY</b></div>
      </div>

  </div>
 
 
</div>



<div class="col-4">

             
              <!-- /.card-header -->
             
                 <table class="table" style="border-radius:20px;border:3px solid #000">
                  <thead>
                    <tr>
                      <th>SWOT</th>
                      <th>> 70</th>
                      <th>70 - 30</th>
                      <th> < 30</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="color:green"><b>STRENGTH</b></td>
                      <td>
                        <i class="fas fa-thumbs-up"style="font-size:20px;margin:5px;color:green;"></i>
                      </td>
                      <td>
                        <i class="fas fa-hand-point-up" style="font-size:20px;margin:5px;color:blue;"></i>
                      </td>
                      <td>
                         <i class="fas fa-thumbs-down"style="font-size:20px;margin:5px;color:red;"></i>
                      </td>                   
                     
                    </tr>
                     <tr>
                      <td style="color:orange"><b>WEAKNESS</b></td>
                      <td>
                         <i class="fas fa-thumbs-down"style="font-size:20px;margin:5px;color:red;"></i>
                      </td>
                      <td>
                        <i class="fas fa-hand-point-up" style="font-size:20px;margin:5px;color:blue;"></i>
                      </td>
                      <td>
                        <i class="fas fa-thumbs-up"style="font-size:20px;margin:5px;color:green;"></i>
                      </td>                   
                     
                    </tr>
                     <tr>
                      <td style="color:blue"><b>OPPORTUNITY</b></td>
                      <td>
                        <i class="fas fa-thumbs-up"style="font-size:20px;margin:5px;color:green;"></i>
                      </td>
                      <td>
                        <i class="fas fa-hand-point-up" style="font-size:20px;margin:5px;color:blue;"></i>
                      </td>
                      <td>
                         <i class="fas fa-thumbs-down"style="font-size:20px;margin:5px;color:red;"></i>
                      </td>                   
                     
                    </tr>
                     <tr>
                      <td style="color:red"><b>THREAT</b></td>
                      <td>
                         <i class="fas fa-thumbs-down"style="font-size:20px;margin:5px;color:red;"></i>
                      </td>
                      <td>
                        <i class="fas fa-hand-point-up" style="font-size:20px;margin:5px;color:blue;"></i>
                      </td>
                      <td>
                        <i class="fas fa-thumbs-up"style="font-size:20px;margin:5px;color:green;"></i>
                      </td>                   
                     
                    </tr>
                   
                  </tbody>
                </table>
             
            
</div>
</div>


<div class="row col-12" >
          
       <div class="col-md-12">
            <div class="card card-outline card-primary collapsed-card">
              <div class="card-header">
                <h3 class="card-title" style="color:red;"><b>Remarks</b></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              If(<b style="color:red; font-weight: 500;">Strength</b>)% is HIGH (> 70%) .... <b style="color:blue;font-weight: 500;">It is considered GOOD</b> <br> If(<b style="color:red; font-weight: 500;">Weakness Opportunity & Threat</b>)% is HIGH (> 70%) .... <b style="color: blue;font-weight: 500;">It is considered POOR</b> <br>If(<b style="color:red; font-weight: 500;">Strength</b>)% is LOW (< 30%) .... <b style="color:blue;font-weight: 500;">It is considered POOR</b> <br>If(<b style="color:red; font-weight: 500;">Weakness Opportunity & Threat</b>)% is LOW (< 30%) .... <b style="color:blue;font-weight: 500;">It is considered GOOD</b><br> If(<b style="color:red; font-weight: 500;">Strength,Weakness Opportunity & Threat</b>)% is AVERAGE (>30% - <70%) .... <b style="color: blue;font-weight: 500;">It is considered as MEDIOCRE </b>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>  
          
        </div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


</script>

<!-- jQuery UI 1.11.4 -->
<script src='{{asset("dashboard/plugins/jquery-ui/jquery-ui.min.js")}}'></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
 
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




</body>
</html>
