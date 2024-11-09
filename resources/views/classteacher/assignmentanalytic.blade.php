@extends('classteacher/layout')
@section('title','Assignment Analytics')
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

<div class="col-12" style="margin:10px;background-color: #fff;padding:5px;margin-top:0px;padding-top: 10px;">
  
<form action="{{url('classteacher/analytics/assignment/fetch')}}" method="post">
    @csrf
    <div class="form-row">
          <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>CLASS</label>
            <select  class="form-control disabled" required  name="class" id="clas" required readonly>
                @foreach($class as $list)
                <option selected value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" readonly>
            <label>SECTION</label>
            <select  class="form-control" required  name="section" id="section" required readonly> 
              @foreach($sections as $list)
                <option selected value="{{$list->id}}">{{$list->section}}</option>
              @endforeach 
            </select>
        </div>
         <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>Training</label>
            <select  class="form-control" required  name="training" id="train" required >
              <option value="">Select</option>
               @foreach($trainings as $list)
                @if($train==$list->id)
                <option selected value="{{$list->id}}">{{$list->trainingname}}</option>
                @else
                <option value="{{$list->id}}">{{$list->trainingname}}</option>
                @endif
                @endforeach 
            </select>
        </div>

       

        
        
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
             <label>Action</label>
            <button type="submit" class="btn btn-success form-control">Fetch Report</button>
          </div>
        </div>
</form>          
</div>

<div class="row col-12" style="margin-top:20px;display: flex;justify-content: center;">
      <div class="col-12 col-sm-4"></div>
      @if(count($data)>0)
        <div class="col-12 col-sm-4 card">
          <h6 style="text-align:center;margin-top:10px;" id="day">ASSIGNMENT</h6> 
          <canvas id="myChart" height="100%" width="100%"></canvas> 
          <select class="form-control" style="margin:10px !important" onchange="reload(this)">
            <option value="">Select</option>
          @foreach($select as $list)
          <option value="{{$list['id']}}">{{$list['data']}}</option>
          @endforeach
          </select>  
        </div>
      @endif
      <div class="col-12 col-sm-4"></div>
      
  </div>



<script>
function yesnoChecked(that) {
    if (that.value != " ") {
        document.getElementById('getjobroles').click();     
    } 
  }
</script>
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
var present=<?php echo $completed ?>;
var absent=<?php echo $notcompleted ?>;
var name="<?php echo $Name ?>";
var mychart=new Chart(ctx,{
  type: 'pie',
  data:  {
  labels: ['Completed','Not Completed'],
  datasets: [{
    label: 'PERFORMANCE',
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
        text: name,
      }
    }
  },

    });
   

function  reload(that) {
    var type=that.value;
     var cl=<?php echo $cl; ?>;
    var section=<?php echo $section; ?>;
    var train=<?php echo $train ;?>;
    var assignment=<?php echo $assignment;?>;

    if(type==1){

        $.ajax({
              url:'{{url("classteacher/analytic/assignment/notcompleted")}}',
              type:'GET',
              data:{assignment:assignment},
              dataType: "json",
              success:function(sdata){
                mychart.data.labels[0] = "Assigned";
                mychart.data.labels[1] = "Submitted";
                mychart.data.labels[2] = "Corrected";
                mychart.data.labels[3] = "Completed";
                mychart.data.datasets[0].data[0] = sdata[0];
                mychart.data.datasets[0].data[1] = sdata[1]; 
                mychart.data.datasets[0].data[2] = sdata[2];
                mychart.data.datasets[0].data[3] = sdata[3]; 
                mychart.update(); 
               
              } 

              });

    }else{


        $.ajax({
              url:'{{url("classteacher/analytic/assignment/completed")}}',
              type:'GET',
              data:{assignment:assignment},
              dataType: "json",
              success:function(sdata){
                mychart.data.labels[0] = "Outstanding";
                mychart.data.labels[1] = "Excellent";
                mychart.data.labels[2] = "Very Good";
                mychart.data.labels[3] = "Good";
                 mychart.data.labels[4] = "Average";
                mychart.data.datasets[0].data[0] = sdata[0];
                mychart.data.datasets[0].data[1] = sdata[1]; 
                mychart.data.datasets[0].data[2] = sdata[2];
                mychart.data.datasets[0].data[3] = sdata[3];
                 mychart.data.datasets[0].data[4] = sdata[4];
                   mychart.update(); 
              } 

              });

    }
   
  
         
}       
</script>

@endsection