@extends('admin/layout')
@section('title','Analytics')
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
  
<form action="{{url('admin/analytics/fetch')}}" method="post">
    @csrf
    <div class="form-row">
          <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>CLASS</label>
            <select  class="form-control disabled" required  name="class" id="class" data-val="{{$section}}" required onchange="sec(this)">
                <option value="">Select Class</option>
                @foreach($class as $list)
                @if($cl==$list->id)
                <option selected value="{{$list->id}}">{{$list->categories}}</option>
                @else
                <option value="{{$list->id}}">{{$list->categories}}</option>
                 @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>SECTION</label>
            <select  class="form-control" required  name="section" id="section" required >
                <option value="">Select Section</option>
               
            </select>
        </div>
       <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>TRAINING NAME</label>
            <select  class="form-control" required  name="training" required >
                <option value="">Select Training</option>
                @foreach($train as $list)
                @if($tri==$list->id)
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
       @if(count($presec)>0)
        <div class="col-12 col-sm-5 card" style="margin:10px">
          <h6 style="text-align:center;margin: 10px">{{$jname}}</h6>
          <canvas id="myChart" height="100%" width="100%"></canvas> 
          <select class="form-control" style="margin:10px !important" onchange="reload(this)">
            <option value="">SELECT SECTION</option>
            @php
            $re=1;
            @endphp
            @foreach($presec as $list)
            <option value="{{$list->sectionname}}//{{$re}}">{{$list->sectionname}}</option>
            @php
            $re++;
            @endphp
            @endforeach
          </select>  
        </div>
      @endif
      @if(count($postsec)>0)
      <div class="col-12 col-sm-5 card" style="margin:10px">
        <h6 style="text-align:center;margin: 10px">{{$jname}}</h6>
          <canvas id="myChart1" height="100%" width="100%"></canvas> 
          <select class="form-control" style="margin:10px !important" onchange="reload1(this)">
            <option value="">SELECT SECTION</option>
            @php
            $fe=1;
            @endphp
            @foreach($postsec as $list)
            <option value="{{$list->sectionname}}//{{$re}}">{{$list->sectionname}}</option>
            @php
            $fe++;
            @endphp
            @endforeach
          </select>
         
      </div>
       @endif
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
var cpass=<?php echo $cpass ?>;
var cfail=<?php echo $cfail ?>;
var capprove=<?php echo $capprove ?>;
var mychart=new Chart(ctx,{
  type: 'pie',
  data:  {
  labels: ['Pass','Fail','Approved'],
  datasets: [{
    label: 'PERFORMANCE',
    data: [cpass,cfail,capprove],
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
        text: 'PRE '
      }
    }
  },

    });

    

function  reload(that) {
    var ans=that.value;
    var train=<?php echo $train; ?>;
     var sectionid=<?php echo $section; ?>;
    $.ajax({
              url:'{{url("admin/analytic/data/pre")}}',
              type:'GET',
              data:{id:ans,train:train,section:sectionid},
              dataType: "json",
               success:function(sdata)
              {
                mychart.data.labels[0] = "Very Poor";
                mychart.data.labels[1] = "Poor";
                mychart.data.labels[2] = "To Improve";
                mychart.data.labels[3] = "Average";
                mychart.data.labels[4] = "Good";
                mychart.data.labels[5] = "Very Good";
                mychart.data.labels[6] = "Excellent";
                mychart.data.labels[7] = "Outstanding";
               
                mychart.options.plugins.title.text = sdata['name'];

                mychart.data.datasets[0].data[0] = sdata[0];
                mychart.data.datasets[0].data[1] = sdata[1];
                mychart.data.datasets[0].data[2] = sdata[2];
                mychart.data.datasets[0].data[3] = sdata[3];
                mychart.data.datasets[0].data[4] = sdata[4];
                mychart.data.datasets[0].data[5] = sdata[5];
                mychart.data.datasets[0].data[6] = sdata[6];
                mychart.data.datasets[0].data[7] = sdata[7];
                 
                mychart.update();
                

                  } 

              });
         
}
</script>
<script type="text/javascript">
var ctx1=document.getElementById("myChart1").getContext("2d");
var colors1=[];
for(let i=0;i<8;i++){
      colors1.push('#'+Math.floor(Math.random()*16777215).toString(16));
}
var fpass=<?php echo $fpass ?>;
var ffail=<?php echo $ffail ?>;
var fapprove=<?php echo $fapprove ?>;
var mychart1=new Chart(ctx1,{
  type: 'pie',
  data:  {
  labels: [
    'PASS',
    'FAIL','Approved'
    
  ],
  datasets: [{
    label: '',
    data: [fpass,ffail,fapprove],
    backgroundColor:colors1 ,
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
        text: 'POST'
      }
    }
  },

    });
    

function  reload1(that) {
    var ans=that.value;
    var train=<?php echo $train; ?>;
     var sectionid=<?php echo $section; ?>;
    $.ajax({
              url:'{{url("admin/analytic/data/post")}}',
              type:'GET',
              data:{id:ans,train:train,section:sectionid},
              dataType: "json",
               success:function(sdata)
              {
                mychart1.data.labels[0] = "Very Poor";
                mychart1.data.labels[1] = "Poor";
                mychart1.data.labels[2] = "To Improve";
                mychart1.data.labels[3] = "Average";
                mychart1.data.labels[4] = "Good";
                mychart1.data.labels[5] = "Very Good";
                mychart1.data.labels[6] = "Excellent";
                mychart1.data.labels[7] = "Outstanding";
               
                mychart1.options.plugins.title.text = sdata['name'];

                mychart1.data.datasets[0].data[0] = sdata[0];
                mychart1.data.datasets[0].data[1] = sdata[1];
                mychart1.data.datasets[0].data[2] = sdata[2];
                mychart1.data.datasets[0].data[3] = sdata[3];
                mychart1.data.datasets[0].data[4] = sdata[4];
                mychart1.data.datasets[0].data[5] = sdata[5];
                mychart1.data.datasets[0].data[6] = sdata[6];
                mychart1.data.datasets[0].data[7] = sdata[7];
                 
                mychart1.update();
                

                  } 

              });
         
}
</script>

<script type="text/javascript">

  function sec(that){
          var classid = that.value;
          var sectionid=$('#class').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("admin/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                   if(sectionid==section.id){
                       $('#section').prop('disabled', false).append('<option value="'+section.id+'" selected >'+section.section+'</option>');
                   }else{
                        $('#section').prop('disabled', false).append('<option value="'+section.id+'">'+section.section+'</option>');
                   }
                });
              }
          });
         }

          var classid = $('#class').val();
          var sectionid=$('#class').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("admin/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                   if(sectionid==section.id){
                       $('#section').prop('disabled', false).append('<option value="'+section.id+'" selected >'+section.section+'</option>');
                   }else{
                        $('#section').prop('disabled', false).append('<option value="'+section.id+'">'+section.section+'</option>');
                   }
                });
              }
          });

</script>

@endsection