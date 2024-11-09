@extends('admin/layout')
@section('title','Competition Analytics')
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
  
<form action="{{url('admin/analytics/competition/fetch')}}" method="post">
    @csrf
    <div class="form-row">
          <div class="col-12 col-sm-4 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>SUPERVISOR</label>
            <select  class="form-control disabled" required  name="supervisor" id="clas" data-val="{{$competition}}" required onchange="sec(this)">
                <option value="">Select</option>
                @foreach($supervisors as $list)
                @if($sup==$list->id)
                <option selected value="{{$list->id}}">{{$list->supname}}</option>
                @else
                <option value="{{$list->id}}">{{$list->supname}}</option>
                 @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-4 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
            <label>COMPETITION</label>
            <select  class="form-control" required  name="competition" id="section" required > 
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
      @if(count($data)>0)
        <div class="col-12 col-sm-4 card">
          <h6 style="text-align:center;margin-top:10px;" id="day">COMPETITION</h6> 
          <canvas id="myChart" height="100%" width="100%"></canvas> 
          
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
var applied=<?php echo $applied ?>;
var notshortlisted=<?php echo $notshortlisted ?>;
var selected=<?php echo $selected ?>;
var completed=<?php echo $completed ?>;

var mychart=new Chart(ctx,{
  type: 'pie',
  data:  {
  labels: ['Applied','Not Shortlisted','Selected','Completed'],
  datasets: [{
    label: 'Competition',
    data: [applied,notshortlisted,selected,completed],
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

  function sec(that){
          var classid = that.value;
          var sectionid=$('#clas').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("admin/competition/bysupervisor/{id}")}}',
              type:'GET',
              data:{id:classid},
              dataType: "json",
              success:function(data)
              {
                 $('#section').prop('disabled', false).append('<option value="">Select</option>');
                
                 $.each(data, function(key,section)
                 {   

                   if(sectionid==section.id){
                       $('#section').prop('disabled', false).append('<option value="'+section.id+'" selected >'+section.competitionname+'</option>');
                   }else{
                        $('#section').prop('disabled', false).append('<option value="'+section.id+'">'+section.competitionname+'</option>');
                   }
                });
              }
          });
         }


       
          var classid = $('#clas').val();
          var sectionid=$('#clas').attr('data-val');
          var trainid=$('#section').attr('data-sec');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("admin/competition/bysupervisor/{id}")}}',
              type:'GET',
              data:{id:classid},
              dataType: "json",
              success:function(data)
              {
                 $('#section').prop('disabled', false).append('<option value="">Select</option>');
                 $.each(data, function(key,section)
                 {   
                   if(sectionid==section.id){
                       $('#section').prop('disabled', false).append('<option value="'+section.id+'" selected >'+section.competitionname+'</option>');
                   }else{
                        $('#section').prop('disabled', false).append('<option value="'+section.id+'">'+section.competitionname+'</option>');
                   }
                });
              }
          });

           
</script>

@endsection