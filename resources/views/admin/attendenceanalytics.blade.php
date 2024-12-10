@extends('admin/layout')
@section('title','Attendence Analytics')
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
  
<form action="{{url('admin/analytics/attendance/fetch')}}" method="post">
    @csrf
    <div class="form-row">
          <div class="col-12 col-sm-4 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
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
        <div class="col-12 col-sm-4 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>SECTION</label>
            <select  class="form-control" required  name="section" id="section" required > 
            </select>
        </div>

       

        
        
        <div class="col-12 col-sm-4 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
             <label>Action</label>
            <button type="submit" class="btn btn-success form-control">Fetch Report</button>
          </div>
        </div>
</form>          
</div>

<div class="row col-12" style="margin-top:20px;display: flex;justify-content: center;">
      <div class="col-12 col-sm-4"></div>
      @if($day>0)
        <div class="col-12 col-sm-4 card">
          <h6 style="text-align:center;margin-top:10px;" id="day">Total Days Attendance Taken : {{$day}}</h6> 
          <canvas id="myChart" height="100%" width="100%"></canvas> 
          <select class="form-control" style="margin:10px !important" onchange="reload(this)">
            <option value="">SELECT MONTH</option>        
            @foreach($months as $list)
            <option value="{{$list['id']}}">{{$list['mon']}}</option>
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
var present=<?php echo $present ?>;
var absent=<?php echo $absent ?>;
var mychart=new Chart(ctx,{
  type: 'pie',
  data:  {
  labels: ['Present','Absent'],
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
        text: 'Attendance'
      }
    }
  },

    });
   

function  reload(that) {
    var month=that.value;
    var cl=<?php echo $cl; ?>;
    var section=<?php echo $section; ?>;
    $.ajax({
              url:'{{url("admin/analytic/attendance/fetch/datewise")}}',
              type:'GET',
              data:{month:month,cl:cl,section:section},
              dataType: "json",
              success:function(sdata){
                mychart.data.labels[0] = "Present";
                mychart.data.labels[1] = "Absent";
                mychart.data.datasets[0].data[0] = sdata[0];
                mychart.data.datasets[0].data[1] = sdata[1]; 
                mychart.update(); 
                document.getElementById('day').innerHTML="Total Days Attendance Taken : "+sdata[3];
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
                 $('#section').prop('disabled', false).append('<option value="">Select</option>');
                
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
                 $('#section').prop('disabled', false).append('<option value="">Select</option>');
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