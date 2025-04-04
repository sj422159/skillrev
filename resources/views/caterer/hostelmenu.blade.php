@extends('caterer/layout')
@section('title','Hostel Items')
@section('Profile','active')
@section('container')

<style type="text/css">
    td,a,button{
        font-size: 12px;
        word-wrap: break-word !important;
    }
    th{
        font-size: 14px;

    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="row">
   <div class="col-md-12">
         
      
       
         <div class="table-responsive table" style="padding:20px" style="width:100%">
                          
                                      <table id="example1" class="display wrap" style="width:100%">
                <thead>
                    <br>
                    <tr>
                        <th>Day</th>
                        <th>Breakfast</th>
                        <th>Lunch</th>
                        <th>Snacks</th>
                        <th>Dinner</th>
                      
                    </tr>
                </thead>
                <tbody>        
                    @for($i=1;$i<=7;$i++)
                        <tr>
                        <td>
                            @if($i==1)
                              MONDAY
                            @elseif($i==2)
                              TUESDAY
                            @elseif($i==3)
                              WEDNESDAY
                            @elseif($i==4)
                              THURSDAY
                            @elseif($i==5)
                              FRIDAY
                            @elseif($i==6)
                              SATURDAY
                            @else
                              SUNDAY
                            @endif
                        </td>
                        <td>
                            @if($check[$i][0]==1)
                                <button onclick="getdata('{{$i}}',1)" class="btn btn-success btn-sm">View</button>
                            @else
                                <button class="btn btn-danger btn-sm">View</button>
                            @endif
                        </td>
                        <td>
                            @if($check[$i][1]==1)
                                <button onclick="getdata('{{$i}}',2)" class="btn btn-success btn-sm">View</button>
                            @else
                                <button class="btn btn-danger btn-sm">View</button>
                            @endif
                        </td>
                        <td>
                            @if($check[$i][2]==1)
                                <button onclick="getdata('{{$i}}',4)" class="btn btn-success btn-sm">View</button>
                            @else
                                <button class="btn btn-danger btn-sm">View</button>
                            @endif
                        </td>
                        <td>
                            @if($check[$i][3]==1)
                                <button onclick="getdata('{{$i}}',6)" class="btn btn-success btn-sm">View</button>
                            @else
                                <button class="btn btn-danger btn-sm">View</button>
                            @endif
                        </td>
                        </tr>
                    @endfor        
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function getdata(day,cat){
    var dayname='';
    var catname='';
    if(day==1){
      dayname="Monday";  
    }else if(day==2){
      dayname="Tuesday"; 
    }else if(day==3){
      dayname="Wednesday"; 
    }else if(day==4){
      dayname="Thursday"; 
    }else if(day==5){
      dayname="Friday"; 
    }else if(day==6){
      dayname="Saturday"; 
    }else {
      dayname="Sunday"; 
    }

    if(cat==1){
      catname="Breakfast";  
    }else if(cat==2){
      catname="Lunch"; 
    }else if(cat==4){
      catname="Snacks"; 
    }else{
       catname="Dinner"; 
    }
  
        $.ajax({
            url:'{{url("vendor/caterer/menu/getdata")}}',
            type:'GET',
            data:{day:day,cat:cat},
            dataType: "json",
            success:function(data){
                var items=''; 
                $.each(data, function(key,section){   
                    items=items+" / "+section.fooditems;
                });
                items=items.substring(2,items.length);
               // console.log(items);
                swal({
                    title: dayname+' - '+catname,
                    text:items,  
                    icon: "success",
                    buttons:"ok",
                })
            }
        });
    }
   
</script>


<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"  defer></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
<script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
@endsection