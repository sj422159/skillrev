<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Question</title>
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
  ::backdrop {
    z-index:0;  
    background-color: white !important;
}
.swal-button--cancel{
  background-color: crimson;
  color: #fff;
}
.swal-button--cancel:hover{
  background-color: crimson;
  color: #fff;
}
.swal-button--cancel:focus{
  background-color: crimson;
  color: #fff;
}
.swal-button--cancel:not([disabled]):hover {
    background-color: crimson;
     color: #fff;
}

html, *:fullscreen, *:-webkit-full-screen, *:-moz-full-screen {
    background-color: white !important;
    z-index:1;
}
.popup-link{
  display:flex;
  flex-wrap:wrap;
}

.popup-link a{
    background: #333;
    color: #fff;
    padding: 10px 30px;
    border-radius: 5px;
    font-size:17px;
    cursor:pointer;
    margin:20px;
    text-decoration:none;
}

.popup-container {
    visibility: hidden;
    opacity: 0;
    transition: all 0.3s ease-in-out;
    transform: scale(1.3);
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(21, 17, 17, 0.61);
    display: flex;
    align-items: center;
}
.popup-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
}
.popup-content p{
    font-size: 17px;
    padding: 10px;
    line-height: 20px;
}
.popup-content a.close{
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    background: none;
    padding: 0;
    margin: 0;
    text-decoration:none;
}

.popup-content a.close:hover{
  color:#333;
}

.popup-content span:hover,
.popup-content span:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.popup-container:target{
  visibility: visible;
  opacity: 1;
  transform: scale(1);
}

.popup-container h3{
  margin:10px;
}
/*End popup styles*/

/* Additional styles */
.popup-style-2{
  transform: scale(0.3);
  
}

.popup-style-2:target{
  transform: scale(1);
}

.popup-style-3{
  left:100%;
  
}

.popup-style-3:target{
  left:0;
}

.popup-style-4{
  transform: rotate(180deg);
}

.popup-style-4:target{
  transform: rotate(0deg);
}

.popup-style-5{
  top:100%;
  
}

.popup-style-5:target{
  top:0;
}

.popup-style-6{
  transform: scale(15.3);
  
}

.popup-style-6:target{
 transform: scale(1);
 }

.popup-style-7{
  transform: skewY(180deg);
   transition: all 0.7s ease-in-out;
}

.popup-style-7:target{
 transform: skewY(0deg);

 }
 pre{
            overflow-x: auto;
            white-space: pre-wrap;
            white-space: -moz-pre-wrap;
            white-space: -pre-wrap;
            white-space: -o-pre-wrap;
            word-wrap: break-word;
            color: #000000;
            font-weight: bold;
            font-family: Arial, sans-serif;

 }
 
 label,#questions{
   color: #000;
   font-family: Arial, sans-serif;
 }
</style>
</head>
<body id="screen" onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">


<div  style="display:flex;padding:10px !important;margin-top: 20px;">
	<div style="width:300px;display:flex;flex-direction: column;"><h3>EBS</h3><h7 style="color:orangered;"><b>SKILL REVELATION</b></h7></div>
	<div  style="text-align:center;width: 600px;">
		<h3 style="font-weight: bold;">SECTION NAME</h3>
	</div>
	<div style="width:240px;text-align: right;">
		<h3 style="color:red;font-weight:bolder" id="time">
			60:00
		</h3>
	</div>
</div>
<div class="row col-12" style="margin-top: 30px;height:85vh;margin-top: 0px;">
	<div class="col-9" id="questions" style="wimargin:0px;padding: 20px;padding-left: 30px;height: 100%;overflow:scroll;">
		

   @if($data[0]->qtype=="MCQ")
    <p><pre><b>Q) </b>{{$data[0]->qtext}}</pre></p><br>
    <div style="margin-left: 30px;">
    a) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
    <label for="html" style="margin-left:10px">{{$data[0]->choice1}}</label><br>
    b) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
    <label for="css" style="margin-left:10px">{{$data[0]->choice2}}</label><br>
    c) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
    <label for="javascript" style="margin-left:10px">{{$data[0]->choice3}}</label><br>
    d) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
    <label for="javascript" style="margin-left:10px">{{$data[0]->choice4}}</label>
   </div>
   @else
        @if($data[0]->choice1image!=null)
             <p><pre><b>Q)</b>{{$data[0]->qtext}}</pre></p><br>
              <img src="{{asset('questionbankimages')}}/{{$data[0]->qimage}}" width="90%">
                 <div style="margin-left: 30px;"><br><br>
                 a) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
                 <label for="html" style="margin-left:10px">{{$data[0]->choice1}}</label><br>
                 <img src="{{asset('questionbankimages')}}/{{$data[0]->choice1image}}" height="200px" width="300px"><br><br>&nbsp &nbsp
                 b) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
                 <label for="css" style="margin-left:10px">{{$data[0]->choice2}}</label><br>
                 <img src="{{asset('questionbankimages')}}/{{$data[0]->choice2image}}" height="200px" width="300px"><br><br>&nbsp &nbsp
                 c) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
                 <label for="javascript" style="margin-left:10px">{{$data[0]->choice3}}</label><br>
                 <img src="{{asset('questionbankimages')}}/{{$data[0]->choice3image}}" height="200px" width="300px"><br><br>&nbsp &nbsp
                 d) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
                 <label for="javascript" style="margin-left:10px">{{$data[0]->choice4}}</label><br>
                 <img src="{{asset('questionbankimages')}}/{{$data[0]->choice4image}}" height="200px" width="300px"><br><br>&nbsp &nbsp
                </div>
        @else 
              <p><pre><b>Q) </b>{{$data[0]->qtext}}</pre></p><br>
                <img src="{{asset('questionbankimages')}}/{{$data[0]->qimage}}"  width="90%" >
                 <div style="margin-left: 30px;"><br><br>
                 a) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
                 <label for="html" style="margin-left:10px">{{$data[0]->choice1}}</label><br>
                 b) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
                 <label for="css" style="margin-left:10px">{{$data[0]->choice2}}</label><br>
                 c) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
                 <label for="javascript" style="margin-left:10px">{{$data[0]->choice3}}</label><br>
                 d) &nbsp &nbsp<input type="radio" id="option" name="fav_language" value="">
                 <label for="javascript" style="margin-left:10px">{{$data[0]->choice4}}</label>
                </div>

        @endif



   @endif


















	</div>
	<div  class="col-3" style="margin:0px;padding:10px;font-size: 10px;" >
		 @for($i=1;$i<=25;$i++)
           <button class="btn btn-secondary" id="q{{$i}}"  data-count="{{$i-1}}" style="margin:2px;width:40px">{{$i}}</button>
      @endfor
      <div>
        <div style="display: flex;justify-content: space-between;margin-top: 20px;">
        <div class="" style="width:90px">
            <div class="info-box bg-secondary" style="display:flex;flex-direction: column;align-items: center;">
             
                <img src="{{asset('mainexam/3.png')}}" style="width:40px;height:40px"></img>
                <span class="info-box-number" id="noano" style="font-size:20px"></span>

              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="" style="width:90px">
            <div class="info-box bg-warning" style="display:flex;flex-direction: column;align-items: center;">
               <img src="{{asset('mainexam/1.png')}}" style="width:40px;height:40px"></img>
                <span class="info-box-number"  id="nono" style="font-size:20px"></span>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="" style="width:90px">
            <div class="info-box bg-success" style="display:flex;flex-direction: column;align-items: center;">
               <img src="{{asset('mainexam/2.png')}}" style="width:40px;height:40px"></img>
                <span class="info-box-number" id="conno" style="font-size:20px"></span>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
   
    </div>
    <div class="col-12" style="display:flex;align-items: center;;justify-content: flex-end;flex-direction: column;padding:5px;">
          
            <div class="" style="width:300px">
            <div class="info-box bg-secondary" style="display:flex;flex-direction:row;align-items: center;font-size: 18px;justify-content: space-evenly;">
             
             <div>
                   <input type="checkbox" name="con" id="con" checked style="height: 20px;width:20px;"><b> ARE YOU CONFIDENT</b>
                 </div>
                 <img src="{{asset('mainexam/question.png')}}" style="width:30px;height:30px">
            </div>
         
            
                 </div>
           <div>
          <div style="display: flex !important;">        
        
          <button class="btn btn-primary btn-sm" onclick="goFullscreen()">GO FULLSCREEN</button>
          </div>
       
        </div>
        </div>
	</div>
</div>

        
				
			</div>









<!--popup1-->

</body>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
  

//Full Screen
 function goFullscreen() {
            // Must be called as a result of user interaction to work
            mf = document.getElementById("screen");
            mf.webkitRequestFullscreen();
            mf.style.display="";
        }


</script>
 <script type="text/javascript">
$(document).bind('webkitfullscreenchange mozfullscreenchange fullscreenchange MSFullscreenChange', function() {
var isFullScreen = document.fullScreen ||
    document.mozFullScreen ||
    document.webkitIsFullScreen || (document.msFullscreenElement != null);
if (isFullScreen) {
  //  console.log('fullScreen!');
    
} else {
  
  

}
});

function submit(){
  document.getElementById('sub').click();
}

//Esc Logic 

$(document).on(
      'keydown', function(event) {
        if (event.key == "Escape") {
            alert('Esc key pressed.');
        }
    });
  </script>

<script>
 

















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
