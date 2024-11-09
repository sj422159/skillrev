@extends('student/layout')
@section('title','Food Menu')
@section('Dashboard_select','active')
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
         
        @if($exist)

        @else
         @php
          $stdate = date('d-m-Y', strtotime('Monday This week'));
           $enddate = date('d-m-Y', strtotime('sunday this week'));
         @endphp
         <div class="table-responsive table" style="padding:20px" style="width:100%">
              <div class="card-header">
                <h4 style="text-align:center;">FOOD SCHEDULE [ {{$stdate}} : {{$enddate}} ]</h4>
              </div>      
             <table id="example1" class="display wrap" style="width:100%">
                <thead>
                    <br>
                    <tr>
                        <th>Day</th>
                        <th>Breakfast</th>
                        <th>Lunch</th>
                        <th>Snacks</th>
                        <th>Dinner</th>
                        <th>Food Review</th>
                      
                    </tr>
                </thead>
                <tbody>
                    
                    
                     @for($i=1;$i<=7;$i++)
                      <tr>
                          <td>
                            @if($i==1)
                               MONDAY
                               @php
                               $dayname='monday this week';
                               $pastdate = date('d-m-Y', strtotime($dayname));
                               @endphp
                            @elseif($i==2)
                               TUESDAY
                               @php
                               $dayname='tuesday this week';
                               $pastdate = date('d-m-Y', strtotime($dayname));
                               @endphp
                            @elseif($i==3)
                               WEDNESDAY
                               @php
                               $dayname='wednesday this week';
                               $pastdate = date('d-m-Y', strtotime($dayname));
                               @endphp
                            @elseif($i==4)
                               THURSDAY
                               @php
                               $dayname='thursday this week';
                               $pastdate = date('d-m-Y', strtotime($dayname));
                               @endphp
                            @elseif($i==5)
                               FRIDAY
                               @php
                               $dayname='friday this week';
                               $pastdate = date('d-m-Y', strtotime($dayname));
                               @endphp
                            @elseif($i==6)
                                SATURDAY
                                @php
                                $dayname='saturday this week';
                                $pastdate = date('d-m-Y', strtotime($dayname));
                                @endphp
                            @else
                                SUNDAY
                                @php
                                $dayname='sunday this week';
                                $pastdate = date('d-m-Y', strtotime($dayname));
                                @endphp
                            @endif
                           </td>
                          </td>
                          <td>
                            @php $skip1=false; @endphp
                            @for($c=0;$c<$che;$c++)
                              @if($check[$c]['day']==$i && $check[$c]['cat']==1)
                                @php $skip1=true; @endphp 
                              @endif
                            @endfor
                            @if($skip1)
                              @if($pastdate<=$tommorowdate)
                                <button onclick="skipdata('{{$i}}',1)" class="btn btn-danger btn-sm">Skipped</button>
                              @else
                                <button disabled class="btn btn-primary btn-sm">NA</button>
                              @endif
                            @else
                              @if($pastdate<=$tommorowdate) 
                                <button onclick="getdata('{{$i}}',1)" class="btn btn-primary btn-sm">View</button>
                              @else
                                <button disabled class="btn btn-primary btn-sm">NA</button>
                              @endif
                            @endif
                          
                        </td>
                          <td>
                            @php $skip1=false; @endphp
                            @for($c=0;$c<$che;$c++)
                              @if($check[$c]['day']==$i && $check[$c]['cat']==2)
                                @php $skip1=true; @endphp 
                              @endif
                            @endfor
                            @if($skip1)
                               <button onclick="skipdata('{{$i}}',2)" class="btn btn-danger btn-sm">Skipped</button>
                            @else
                               <button onclick="getdata('{{$i}}',2)" class="btn btn-primary btn-sm">View</button>   
                            @endif
                        </td>

                           
                          <td>
                            @php $skip1=false; @endphp
                            @for($c=0;$c<$che;$c++)
                              @if($check[$c]['day']==$i && $check[$c]['cat']==4)
                                @php $skip1=true; @endphp 
                              @endif
                            @endfor
                            @if($skip1)
                               <button onclick="skipdata('{{$i}}',4)" class="btn btn-danger btn-sm">Skipped</button>
                            @else
                               <button onclick="getdata('{{$i}}',4)" class="btn btn-primary btn-sm">View</button>
                            @endif
                        </td>

                            
                          <td>
                            @php $skip1=false; @endphp
                            @for($c=0;$c<$che;$c++)
                              @if($check[$c]['day']==$i && $check[$c]['cat']==6)
                                @php $skip1=true; @endphp 
                              @endif
                            @endfor
                            @if($skip1)
                               <button onclick="skipdata('{{$i}}',6)" class="btn btn-danger btn-sm">Skipped</button>
                            @else
                               <button onclick="getdata('{{$i}}',6)" class="btn btn-primary btn-sm">View</button>
                            @endif
                        </td>
                        <td>
                          @php $skip1=false; @endphp
                            @for($c=0;$c<$feedbackche;$c++)
                              @if($feedbackcheck[$c]['day']==$i)
                                @php $skip1=true; @endphp 
                              @endif
                            @endfor
                            @if($skip1)
                                <button type="button" disabled class="btn btn-success btn-sm">Feedback</button>
                            @else
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalCenter" onclick="foo('{{$i}}')">Feedback</button>
                            @endif
                        </td>
                      </tr>
                     @endfor
                  
                  
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Please Rate The Food Service For The Whole Day</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{url('student/food/feedback')}}" method="post">
            @csrf
            <div class="row col-lg-12">
            <div class="form-group col-md-4">
                <label class="form-control">QUANTITY</label>
                <select class="form-control" name="quantity" required>
                    <option value="">Select</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="2">4</option>
                    <option value="3">5</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label class="form-control">QUALITY</label>
                <select class="form-control" name="quality" required>
                    <option value="">Select</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="2">4</option>
                    <option value="3">5</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label class="form-control">TASTE</label>
                <select class="form-control" name="taste" required>
                    <option value="">Select</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="2">4</option>
                    <option value="3">5</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="day" id="dayval" value="">
      </div>
      
         
      
      <div class="modal-footer">
        <div class="col-12" style="display:flex;justify-content: center;">
        <p style="font-weight: bold;">
          5 => <span>OUTSTANDING</span> ,   4 => <span>EXCELLENT</span> ,  3 => <span>VERY GOOD</span> ,<br>  2 => <span>GOOD</span> ,  1 => <span>AVERAGE</span>
        </p>
      </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit Feedback</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function foo(val){
        document.getElementById('dayval').value=val;
       // alert(val);
    }
    var hostel=<?php echo $hostelid ?>;
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
            url:'{{url("student/menu/getdata")}}',
            type:'GET',
            data:{day:day,cat:cat,hostel:hostel},
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
                    icon:"success",
                    buttons:[true,"Skip My Meal"],
                    dangerMode:true,
                    
                }).then((data1) => {
                      if (data1) {
                           window.location.href = "{{url('student/food/skip')}}/"+day+"/"+cat;
                        }else{
                         
                        }
                    });
            }
        });
    }

    function skipdata(day,cat){
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
            url:'{{url("student/menu/getdata")}}',
            type:'GET',
            data:{day:day,cat:cat,hostel:hostel},
            dataType: "json",
            success:function(data){
                var items=''; 
                $.each(data, function(key,section){   
                    items=items+" / "+section.fooditems;
                });
                items=items.substring(2,items.length);
                console.log(items);
                swal({
                    title: dayname+' - '+catname,
                    text:items,  
                    icon:"success",
                    buttons:[true,"I Have My Meal"],
                
                    
                }).then((data1) => {
                      if (data1) {
                           window.location.href = "{{url('student/food/undo/skip')}}/"+day+"/"+cat;
                        }else{
                      
                        }
                    });
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




<script>
  

</script>
<script type="text/javascript"> 
  $(document).ready(function() {
   // $('#example1').DataTable({
   //                      dom: 'Bfrtip',
   //                      buttons: [
   //                          'copy', 'csv', 'excel', 'pdf', 'print'
   //                      ]
   //                  });
} );
</script>

@endsection 