@extends('manager/layout')
@section('title','Assignments')
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
  
<form action="{{url('manager/assignments/trainingwise')}}" method="post">
    @csrf
    <div class="form-row">
          <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>CLASS</label>
            <select  class="form-control disabled" required disabled  id="class"  required >
                
                @foreach($class as $list)
                @if($cl==$list->id)
                <option selected value="{{$list->id}}">{{$list->categories}}</option>
               @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>SECTION</label>
            <select  class="form-control" required  name="section" required >
                <option value="">Select Section</option>
                @foreach($sec as $list)
                @if($section==$list->id)
                <option selected value="{{$list->id}}">{{$list->section}}</option>
                @else
                <option value="{{$list->id}}">{{$list->section}}</option>
                @endif
                @endforeach
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
        <input type="hidden" name="class" value="{{$cl}}">

       

        
        
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
             <label>Action</label>
            <button type="submit" class="btn btn-success form-control">Fetch Report</button>
          </div>
        </div>
</form>          
</div>

<div class="card-body" style="background-color:#e6e6e6;margin-top:15px;">
<div class="table-responsive table ">
                          
    <table id="example1" class="display nowrap" style="width:100%;border:1px solid #000;background-color: #fff;">
                <thead>
                        <tr>
                          <th>Id</th>
                          <th>Profile Picture </th>
                          <th>Student Name </th>
                          <th>Training Type</th>
                          <th>Training Name</th>
                          <th>Question</th>
                          <th>Answer</th>
                          <th>Evaluated Answer</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      	@php
                      	$count=1;
                      	@endphp
                      	@foreach($data as $list)
                        <tr>
                        <td><b>{{$count}}</b></td>
                        <td><img src="{{asset('studentimages')}}/{{$list->image}}" height="40px" width="40px" /></td>
                        <td>{{$list->sname}} {{$list->slname}}</td>
                        <td>{{$list->type}}</td> 
                        <td>{{$list->trainingname}}</td> 

                <td><a href="{{url('assignmentcontent/question')}}/{{$data[0]->questioncontent}}"target="_blank">View</a></td>
                @if($list->status==2 || $list->status==3 || $list->status==4)
                <td><a href="{{url('assignmentcontent/answer')}}/{{$data[0]->answercontent}}" target="_blank">View</a></td>
                @else
                <td><a href="#">Pending</a></td>
                @endif

                @if($list->status==3 || $list->status==4)
                <td> <a href="{{url('assignmentcontent/correctanswer')}}/{{$data[0]->correctanswercontent}}" target="_blank">View</a></td>
                @else
                <td><a href="#">Pending</a></td>
                @endif
                
               

                        <td>
                        @if($list->status==1)
                        <a href="#">Assigned</a>
                        @elseif($list->status==2)
                        <a href="#">Submitted</a>
                        @elseif($list->status==3)
                        <a href="#">Corrected</a>
                        @elseif($list->status==4)
                        <a href="#">Completed</a>
                        @endif
                        </td>
                        </tr>
                        @php
                        $count++;
                        @endphp
                      	@endforeach
                      </tbody>
                    </table>
                </div>
</div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

  
  <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"  defer></script>
    <script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>


    
 <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
    <script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>

<script type="text/javascript"> 
  $(document).ready(function() {
   $('#example1').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
} );

  </script>

@endsection