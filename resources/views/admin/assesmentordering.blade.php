@extends('admin/layout')
@section('title','Assesment Ordering')
@section('Dashboard_select','active')
@section('container')
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  input{
    background-color: #00000020;
    padding: 6px;

  }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
 <div class="row">
          <div class="col-12">
            <div class="card">
       <div class="card-body table-responsive p-0 col-11" style="margin-left:30px !important">
        <form method="post" action="{{url('admin/assesment/sectioncreation')}}" >
          @csrf
          <input type="hidden" name="ass_id" value="{{$id}}">
                <table id="simpleTable1" class="table table-bordered table-striped">
      <thead>
         <br>
         <tr>
            <th>Module</th>
            <th>Chapter</th>
            <th>No Of Questions</th>
            <th>Difficulty Level</th>
            <th>Timing (In Minutes)</th>
         </tr>
      </thead>
      <tbody  id='sortable'>

              @if($count==0)
                @php
                 $sc=0;
                @endphp
               @foreach($skill_arr as $key )
                 
                 <tr >
                  <td>
                    {{$subs[$sc]}}
                  </td>

                  <td> {{$key}}<input type="hidden" name="skr[]" value='{{$skillid[$sc]}}'></td>
                 <td><input type="number" name="noquestions[]" value="" required="true" class="form-control"></td>
                  <td><select  required="true" class="form-control" name="level[]">
                    <option>Select</option>
                    @foreach($levels as $list)
                    <option  value="{{$list->level}}">{{$list->level}}</option>
                    @endforeach
                  </select></td>
                  <td><input  required="true" class="form-control" type="number" name="time[]" value=""></td>
                 
                 </tr>
                  @php
                 $sc+=1;
                @endphp
                @endforeach  
              @else
                @php
                $count=0;
                @endphp
                @foreach($skill_arr as $key )
                <tr><td>{{$subs[$count]}}</td>
                 <td>{{$skillatt[$count]}}<input type="hidden" name="skr[]" value='{{$skillid[$count]}}'></td>
                 <td><input type="number"  required="true" class="form-control" name="noquestions[]" value="{{$questions3[$count]}}"></td>
                  <td><select  required="true" class="form-control" name="level[]">
                    <option>Select</option>
                    @foreach($levels as $list)
                    @if($level3[$count]==$list->level){
                      <option selected value="{{$list->level}}">{{$list->level}}</option>
                    }
                    @else{
                    <option  value="{{$list->level}}">{{$list->level}}</option>
                    }
                    @endif
                    @endforeach
                  </select></td>
                  <td><input type="number"  required="true" class="form-control" name="time[]" value="{{$time3[$count]}}" oninput="totaltime(this)"></td>
                  @php
                  $count++;
                  @endphp
                 </tr>
                @endforeach  
          
              @endif

              <tr>
                  <td>Total</td>
                  <td></td>
                  <td><input type="number" name="totalquestion" placeholder="Total Questions" value="{{$totalquestions}}"  required="true" class="form-control"></td>
                  <td></td>
                  <td><input type="number" name="sectionduration" id="time" placeholder="Total Minutes" value="{{$sectionduration}}" required="true" class="form-control"></td>
              </tr>

             
                
             
       
      </tbody>

   </table>

  <div class="col-12 col-sm-3 mt-4 mt-sm-0" style="margin-top:20px !important;">
      <label for="TypeOfEduId">Pass Percentage :</label>
      <input type="number" max="100" class="form-control" placeholder="Enter" value="{{$pass}}" name="pass">
  </div> 
     

    <input type="hidden" name="sectionid" value="{{$sectionid}}" >
    <input type="hidden" name="sectionname" value="{{$sectionname}}" >
    <input type="hidden" name="skillset" value="{{$skillset}}" >
    <input type="hidden" name="subskillset" value="{{$subskillset}}" >
    <input type="hidden" name="skillgroup" value="{{$skillgroup}}" >
   
    <button type="submit" class="btn btn-primary mt-4" style="margin-bottom:20px !important;">Submit</button>
 </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
   <script type="text/javascript">
     function totaltime(that){
      //alert("h");
        var x=that.value;
        var y=document.getElementById("time").value;

        var z=parseInt(x)+parseInt(y);
        
        document.getElementById("time").value=z;

     }
   </script>     

@endsection