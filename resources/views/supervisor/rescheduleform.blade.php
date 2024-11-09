@extends('supervisor/layout')
@section('title','Schedule')
@section('d','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;"> FACULTY SCHEDULE CLASS</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('groupmanager/reschedule/day')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                   <div class="col-12 col-sm-4  mt-4 mt-sm-0">
                    <label for="jobrole">Day</label>
                    <input type="text" name="day" id="day" value="{{$data[0]->tdayid}}" class="form-control" disabled>
                  </div>

                  <input type="hidden" name="date" id="date" value="{{$data[0]->tdateid}}" class="form-control" disabled>
               
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class</label>
                 <input type="text" name="class" id="clas" value="{{$data[0]->categories}}" class="form-control" disabled>
                </div>
                @if($visible==1)
                 <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Section</label>
                  <input type="text" name="section" id="section" value="{{$data[0]->section}}" class="form-control" disabled>
                </div>
              @endif
              </div>
                <div class="form-row mt-4">
               
            
                 
                
               
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Period</label>
                    <input type="text" name="period" id="period" value="{{$data[0]->tperiodid}}" class="form-control" disabled>
                  </div>

                 <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Name</label>
                     <select name="fac" class="form-control" required="true" id="fac" onchange="getsub(this)">
                      <option value="">Select</option>
                      @foreach($facs as $list)
                       @if(in_array($list->id,$occupy))
                       @else
                       <option value="FACULTY**{{$list->id}}">{{$list->fname}}</option>
                       @endif
                      @endforeach
                      @foreach($managers as $list)
                       @if(in_array($list->id,$occupyman))
                       @else
                       <option value="MANAGER**{{$list->id}}">{{$list->mname}}</option>  
                       @endif
                      @endforeach
                      @foreach($supervisors as $list)
                       <option value="GROUPMANAGER**{{$list->id}}">{{$list->supname}}</option>  
                      @endforeach

                    </select>
                  </div>

                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Subject</label>
                    <select name="sub" class="form-control"required="true" id="sub" onchange="gettabledata(this)">
                    <option value="">Select</option>
                    </select>    
                  </div>

                  

                  </div>
                  <div class="col-12">
                       <div class="table-responsive table" style="padding:20px" style="width:100%">
           <table id="example1" class="display wrap" style="width:100%">
            <thead style="background-color:#000;color:#fff">
                <tr>
                    <th></th>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Class</th>
                    <th>Section</th>
                    <th>Period</th>
                    <th>Subject</th>
                   
                </tr>
                  </thead>
                    <tbody id="tabledata">
                    <tr>
                     <td colspan="7" style="text-align:center;">No PENDING CLASSES</td>
                    </tr>
                
                    </tbody>
                 </table></div>
                  </div>
                    <input type="hidden" name="id" value="{{$data[0]->id}}">
                    <input type="hidden" name="lid" value="{{$lid}}">
                    <input type="hidden" id="realclas" value="{{$data[0]->tclassid}}">
                    <input type="hidden" id="realsec" value="{{$data[0]->tsectionid}}">

                   
                </div>
                <div class="card-footer" align="center">
                    <button type="submit" class="btn btn-primary">Reschedule</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" defer></script>
<script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script>
</script> 
<script type="text/javascript">
function getsub(that){
    var a = that.value;
    var b = a.split("**");
    var portal = b[0];
    var profile = b[1];
    $('#sub').html('');
    $.ajax({
          url:'{{url("groupmanager/reschedule/getsubjects")}}',
          type:'GET',
          data:{portal:portal,profile:profile},
          dataType:"json",
          success:function(data){
          $('#sub').prop('disabled', false).append('<option value="">Select</option>');
          $.each(data, function(key,subjects){   
          $('#sub').prop('disabled', false).append('<option value="'+subjects.id+'" >'+subjects.domain+'</option>');             
          });
          }
    });
} 

function gettabledata(that){
    var day = document.getElementById('day').value;
    var date = document.getElementById('date').value;
    var clas = document.getElementById('realclas').value;
    var section = document.getElementById('realsec').value;
    var period = document.getElementById('period').value;

    var a = document.getElementById('fac').value;
    var b = a.split("**");
    var portal = b[0];
    var profile = b[1];

    var subject = that.value;
    
    $('#tabledata').html('');
    $.ajax({
          url:'{{url("groupmanager/reschedule/gettabledata")}}',
          type:'GET',
          data:{day:day,date:date,class:clas,section:section,period:period,portal:portal,profile:profile,subject:subject},
          dataType:"json",
          success:function(data){
         
           if(data.length==0){
             $('#tabledata').prop('disabled', false).append('<tr><td colspan="7" style="text-align:center;">No PENDING CLASSES</td></tr>');             
          
            
           }
          $.each(data, function(key,data){   
          $('#tabledata').prop('disabled', false).append('<tr><td><input type="radio" name="pid" value="'+data.id+'"/></td><td>'+data.tdateid+'</td><td>'+data.tdayid+'</td><td>'+data.categories+'</td><td>'+data.section+'</td><td>'+data.tperiodid+'</td><td>'+data.domain+'</td></tr>');             
          });
          }
    });

}       
</script>
@endsection