@extends('admin/layout')
@section('title','Add Periods')
@section('Dashboard_select','active')
@section('container')
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">


<div class="content">
<div class="col-12 col-lg-13 m-auto" style="margin-top: 30px !important;">
            <form class="multisteps-form__form" action="{{url('admin/periods/class/saveclass')}}" method="post" enctype="multipart/form-data">
              @csrf 
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">
                <div class="multisteps-form__content">
                
                <div class="form-row">
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="role">Type :</label>
                        <select id="group" required="true" type="text" class="form-control" name="cclasstypeid">
                          <option value="">Select</option>
                          @foreach($classtypes as $list)
                          @if($cclasstypeid==$list->id){
                          <option selected value="{{$list->id}}">{{$list->classtype}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->classtype}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="role">Class :</label>
                        <select id="group" required="true" type="text" class="form-control" name="cclassid" onchange="check(this)">
                          <option value="">Select</option>
                          @foreach($class as $list)
                          @if($cclassid==$list->id){
                          <option selected value="{{$list->id}}">{{$list->categories}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->categories}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="a">
                        <label for="role">Monday Mandatory:</label>
                        <input type="number" class="form-control days" id="jobrole" data-id="cmonopt" required="true" name="cmon" max="{{$cmax}}" value="{{$cmon}}" oninput="change(this)">
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="a">
                        <label for="role">Monday Optional :</label>
                        <input type="number" class="form-control days" id="cmonopt" readonly  required="true" name="cmonopt" max="{{$cmax}}" value="{{$cmonopt}}">
                       
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Tuesday Mandatory:</label>
                        <input type="number" class="form-control days" id="jobrole" data-id="ctueopt" required="true" name="ctues" max="{{$cmax}}" value="{{$ctues}}" oninput="change(this)">
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Tuesday Optional :</label>
                         <input type="number" class="form-control days" readonly  id="ctueopt" required="true" name="ctuesopt" max="{{$cmax}}" value="{{$ctuesopt}}">
                      
                    </div>
                </div>
                <div class="form-row mt-4"> 
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Wednesday Mandatory:</label>
                         <input type="number" class="form-control days" id="jobrole" data-id="cwednesopt" required="true" name="cwednes" max="{{$cmax}}" value="{{$cwednes}}" oninput="change(this)">
                       
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Wednesday Optional :</label>
                         <input type="number" class="form-control days"   readonly id="cwednesopt" required="true" name="cwednesopt" max="{{$cmax}}" value="{{$cwednesopt}}">
                       
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="a">
                        <label for="role">Thursday Mandatory:</label>
                         <input type="number" class="form-control days" id="jobrole" data-id="cthursopt" required="true" name="cthurs" max="{{$cmax}}" value="{{$cthurs}}" oninput="change(this)">
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="a">
                        <label for="role">Thursday Optional :</label>
                         <input type="number" class="form-control days" readonly  id="cthursopt" required="true" name="cthursopt" max="{{$cmax}}" value="{{$cthursopt}}">
                      
                    </div>
                </div>
                <div class="form-row mt-4">   
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Friday Mandatory:</label>
                         <input type="number" class="form-control days" id="jobrole" oninput="change(this)" data-id="cfriopt" required="true" name="cfri" max="{{$cmax}}" value="{{$cfri}}">
                       
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Friday Optional :</label>
                        <input type="number" class="form-control days" readonly id="cfriopt" required="true" name="cfriopt" max="{{$cmax}}" value="{{$cfriopt}}">
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Saturday Mandatory:</label>
                        <input type="number" class="form-control days" id="jobrole" oninput="change(this)" required="true" data-id="csaturopt" name="csatur" max="{{$cmax}}" value="{{$csatur}}">
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Saturday Optional :</label>
                         <input type="number" class="form-control days" readonly  id="csaturopt" required="true" name="csaturopt" max="{{$cmax}}" value="{{$csaturopt}}">
                    </div>
                </div>

                  <input type="hidden" name="id" value="{{$id}}">
                  <div class="button-row d-flex mt-4">
                    <input type="submit" class="btn-sm btn btn-success" value="Save"></input>
                    <a href="{{url('admin/periods/class')}}"><button type="button" class="btn-sm btn btn-danger" style="margin-left:10px !important;">Back</button></a>
                  </div>
                </div>
              </div>
              </form>
            </div> 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

  var limit=<?php echo $cmax; ?>

  function check(that){
      $.ajax({
              url:'{{url("admin/schedule/class/getmaxperiod")}}',
              type:'GET',
              data:{id:that.value},
              dataType: "json",
              success:function(data)
              {
                   limit=data[0]['cmaxperiod'];   
                  var days=document.getElementsByClassName('days');
                  for(var i=0;i<days.length;i++){
                    days[i].removeAttribute("max");
                    days[i].setAttribute("max",data[0]['cmaxperiod']);
                    days[i].value=0;
                  }
                    
                
              }
          });
  }

  function change(that){
     var id=that.getAttribute("data-id");
   
     document.getElementById(id).value=parseInt(limit)-parseInt(that.value)
  }


</script>                
 @endsection                 