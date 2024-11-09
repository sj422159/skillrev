@extends('student/layout')
@section('title','Attendance Analytics')
@section('reports','active')
@section('container')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<style type="">
    
select,option,label,button{
    font-size: 12px !important;
}
th{
  font-size: 14px !important;
}
td{
  font-size: 12px !important;
}
</style>


<div class="row col-12" style="margin-top:20px;display: flex;justify-content: center;">
      <div class="col-12 col-sm-4"></div>
      @if($present>0 || $absent>0)
        <div class="col-12 col-sm-4 card">
          <h6 style="text-align:center;margin-top:10px;" id="day">Total Attendance</h6> 
          <span style="color:blue;text-align: center;font-weight: bold;text-transform: uppercase;font-size: 10px;" id="text">Complete Year</span>
          <canvas id="myChart" height="100%" width="100%"></canvas>  
           <select class="form-control" style="margin:10px !important" onchange="reload(this)">
            <option value="">Select Month</option>
          @foreach($months as $list)
          <option value="{{$list['val']}}">{{$list['month']}}</option>
          @endforeach
          </select>     
        </div>
      @endif
      <div class="col-12 col-sm-4"></div>      
</div>

<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"  defer></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
<script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script src="{{asset('assets/js/chart.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">


var ctx=document.getElementById("myChart").getContext("2d");
var colors=[];
for(let i=0;i<8;i++){
      colors.push('#'+Math.floor(Math.random()*16777215).toString(16));
}
var present=<?php echo $present ?>;
var absent=<?php echo $absent ?>;

var mychart=new Chart(ctx,{
  type: 'pie',
  data:  {
  labels: ['Present','Absent'],
  datasets: [{
    label: 'Attendance Analytics',
    data: [present,absent],
    backgroundColor:colors,
    hoverOffset: 4
  }]
},
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        
      }
    }
  },

    });
   


</script>
<script type="text/javascript">


function  reload(that) {
    var val=that.value;
    var mon="";
    if(val=="04"){
     mon="April";
    }else if(val=="05"){
      mon="May";
    }else if(val=="06"){
      mon="June";
    }else if(val=="07"){
       mon="July";
    }else if(val=="08"){
      mon="August";
    }else if(val=="09"){
       mon="September"
    }else if(val=="10"){
      mon="October";
    }else if(val=="11"){
      mon="November";
    }else if(val=="12"){
      mon="December";
    }else if(val=="01"){
       mon="January";
    }else if(val=="02"){
       mon="Feburary";
    }else{
       mon="March"
    }
        $.ajax({
              url:'{{url("student/analytics/attendance/monthwise")}}',
              type:'GET',
              data:{val:val},
              dataType: "json",
              success:function(sdata){
              mychart.data.labels=["Present","Absent"]; 
              mychart.data.datasets[0].data=[sdata[0],sdata[1]];
              mychart.update();
              document.getElementById("text").innerHTML=mon; 
              }
        }); 
         
}

           
</script>

@endsection