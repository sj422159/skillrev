@extends('supervisor/layout')
@section('title','Reports')
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
  
<form action="{{url('supervisor/reports/sectionwise')}}" method="post">
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

<div class="card-body" style="background-color:#e6e6e6;margin-top:15px;">
<div class="table-responsive table ">
                          
    <table id="example1" class="display nowrap" style="width:100%;border:1px solid #000;background-color: #fff;">
                <thead>
                        <tr>
                          <th>Id</th>
                          <th>Profile Picture </th>
                          <th>Student Name </th>
                          <th>Training Name</th>
                          <th>Section</th>
                          <th>Action</th>
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
                          <td>{{$list->trainingname}}</td> 
                         	<td>{{$list->section}}</td>
                         		<td>
                            @if($list->preapprove!=0)
                            @if($list->prereport!="0")
                           <a href="{{url('supervisor/examreport')}}/{{$list->id}}/{{$list->prereport}}" class="btn btn-primary btn-sm">Pre</a>
                                 
                           @else
                              <a href="" class="btn btn-primary btn-sm disabled" style="margin-right: 4px" >PRE</a>
                           @endif
                           @else
                            <a href="" class="btn btn-primary btn-sm disabled" style="margin-right: 4px" >PRE</a>
                           @endif
                           
                           @if($list->studentassignmentid)
                           <a href="{{url('groupmanager/assignmentreport')}}/{{$list->studentassignmentid}}" class="btn btn-info btn-sm">Assignment</a> 
                           @else
                           <a href="" class="btn btn-info btn-sm disabled">Assignment</a> 
                           @endif


                            @if($list->postreport=="0")
                            <a href="" class="btn btn-success btn-sm disabled" style="margin-right: 4px" >POST</a>
                            @else
                              <a href="{{url('supervisor/examreport')}}/{{$list->id}}/{{$list->postreport}}" class="btn btn-success btn-sm">Post</a>
                            @endif	
                          </td>
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

  function sec(that){
          var classid = that.value;
          var sectionid=$('#class').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("supervisor/classby/section/{id}")}}',
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
              url:'{{url("supervisor/classby/section/{id}")}}',
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