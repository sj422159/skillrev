@extends('manager/layout')
@section('title','Fees Analytics')
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
  
<form action="{{url('manager/analytics/currentfees/fetch')}}" method="post">
    @csrf
    <div class="form-row">
          <div class="col-12 col-sm-4 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>CLASS</label>
            <select  class="form-control disabled" required  name="class" id="clas" data-val="{{$section}}" required readonly>
                @foreach($class as $list)
                <option selected value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-4 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
            <label>SECTION</label>
            <select  class="form-control" required  name="section" id="section" required > 
              @foreach($sections as $list)
                @if($section==$list->id)
                <option selected value="{{$list->id}}">{{$list->section}}</option>
                @else
                <option value="{{$list->id}}">{{$list->section}}</option>
                @endif
              @endforeach
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
      <div class="col-12 col-sm-3"></div>
      @if(count($data)>0)
        <div class="col-12 col-sm-6 card">
          <h6 style="text-align:center;margin-top:10px;" id="day">ACADEMIC FEES</h6> 
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
      <div class="col-12 col-sm-3"></div>      
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
var january=<?php echo $January ?>;
var february=<?php echo $February ?>;
var march=<?php echo $March ?>;
var april=<?php echo $April ?>;
var may=<?php echo $May ?>;
var june=<?php echo $June ?>;
var july=<?php echo $July ?>;
var august=<?php echo $August ?>;
var september=<?php echo $September ?>;
var october=<?php echo $October ?>;
var november=<?php echo $November ?>;
var december=<?php echo $December ?>;

var mychart=new Chart(ctx,{
  type: 'pie',
  data:  {
  labels: ['April','May',"June",'July','August','September','October','November','December','January','Feburary','March'],
  datasets: [{
    label: 'Pending Fees',
    data: [april,may,june,july,august,september,october,november,december,january,february,march],
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
   // alert(val);
     var cl=<?php echo $cl; ?>;
    var section=<?php echo $section; ?>;
    var da='';
    var mon="";
    if(val=="feeaprpay"){
     da=april;
     mon="April";
    }else if(val=="feemaypay"){
      da=may;
      mon="May";
    }else if(val=="feejunpay"){
      da=june;
      mon="June";
    }else if(val=="feejulpay"){
       da=july;
       mon="July";
    }else if(val=="feeaugpay"){
      da=august;
      mon="August";
    }else if(val=="feeseppay"){
       da=september;
       mon="September"
    }else if(val=="feeoctpay"){
      da=october;
      mon="October";
    }else if(val=="feenovpay"){
      da=november;
      mon="November";
    }else if(val=="feedecpay"){
      da=december;
      mon="December";
    }else if(val=="feejanpay"){
       da=january;
       mon="January";
    }else if(val=="feefebpay"){
       da=february;
       mon="Feburary";
    }else{
       da=march;
       mon="March"
    }
  

  

        $.ajax({
              url:'{{url("manager/analytic/currentfees/monthwise")}}',
              type:'GET',
              data:{val:val,cl:cl,section:section,da:da},
              dataType: "json",
            
              success:function(sdata){

                mychart.data.labels=["Paid","Not Paid"];
               
                mychart.data.datasets[0].data=[sdata[0],sdata[1]];
                mychart.update();
                document.getElementById("text").innerHTML=mon; 
              }

              });

 
   
  
         
}

           
</script>

@endsection