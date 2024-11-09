@extends('supervisor/layout')
@section('title','Rescheduling')
@section('reports','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="container-fluid"> 
<form action="{{url('groupmanager/rescheduling/list/bysection')}}" method="post">
    @csrf
    <div class="form-row">
          <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>CLASS</label>
            <select  class="form-control disabled" required  name="class" id="class" data-val="{{$section}}" required onchange="sec(this)">
                <option value="">Select</option>
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
                <option value="">Select</option>
               
            </select>
        </div>
    
        
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
             <label>Action</label>
            <button type="submit" class="btn btn-success form-control">Fetch</button>
          </div>
        </div>
</form>          
<div class="card-header d-flex p-0 mt-4">
                <h3 class="card-title p-3">Class Rescheduling</h3>
                 
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Reschedule</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Rescheduled</a></li>
                </ul>
</div>
<div class="card-body" style="background-color:#e6e6e6;margin-top:15px;">
<div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                     <div class="row">
<div class="table-responsive table ">
                          
    <table id="example1" class="display nowrap" style="width:100%;border:1px solid #000;background-color: #fff;">
                <thead>
                        <tr>
            <th>Date</th>
            <th>Day</th>
            <th>Role</th>
            <th>Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Period</th>
            <th>Subject</th>
                        </tr>
                      </thead>
                      <tbody>
            @foreach($managerrescheduledata as $list)
             <tr>
                <td>{{$list->tdateid}}</td>
                <td>{{$list->tdayid}}</td>
                <td>{{$list->tportalid}}</td>
                <td>{{$list->mname}}</td>
                <td>{{$list->categories}}</td>
                <td>{{$list->section}}</td>
                <td>{{$list->tperiodid}}</td>
                <td>{{$list->dname}}</td>
            </tr>
            @endforeach
            @foreach($managerrescheduledataopt as $list)
             <tr>
                <td>{{$list->tdateid}}</td>
                <td>{{$list->tdayid}}</td>
                <td>{{$list->tportalid}}</td>
                <td>{{$list->mname}}</td>
                <td>{{$list->categories}}</td>
                <td style="color:red">NA</td>
                <td>{{$list->tperiodid}}</td>
                <td>{{$list->dname}}</td>
            </tr>
            @endforeach

            @foreach($facultyrescheduledata as $list)
            <tr>
                <td>{{$list->tdateid}}</td>
                <td>{{$list->tdayid}}</td>
                <td>{{$list->tportalid}}</td>
                <td>{{$list->fname}}</td>
                <td>{{$list->categories}}</td>
                <td>{{$list->section}}</td>
                <td>{{$list->tperiodid}}</td>
                <td>{{$list->dname}}</td>
            </tr>
            @endforeach
            @foreach($facultyrescheduledataopt as $list)
             <tr>
                <td>{{$list->tdateid}}</td>
                <td>{{$list->tdayid}}</td>
                <td>{{$list->tportalid}}</td>
                <td>{{$list->fname}}</td>
                <td>{{$list->categories}}</td>
                <td style="color:red">NA</td>
                <td>{{$list->tperiodid}}</td>
                <td>{{$list->dname}}</td>
            </tr>
            @endforeach
                              
                             
                         
                                                  
                        
                         
                       
                        
                      
                      </tbody>
                    </table>
                </div>
</div>
</div>

                  <div class="tab-pane" id="tab_2">
                     <div class="row">
<div class="table-responsive table ">
                          
    <table id="example2" class="display nowrap" style="width:100%;border:1px solid #000;background-color: #fff;">
                <thead>
                        <tr>
            <th>Date</th>
            <th>Day</th>
            <th>Role</th>
            <th>Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Period</th>
            <th>Subject</th>
            <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
            @foreach($managerrescheduleddata as $list)
             <tr>
                <td>{{$list->tdateid}}</td>
                <td>{{$list->tdayid}}</td>
                <td>{{$list->tportalid}}</td>
                <td>{{$list->mname}}</td>
                <td>{{$list->categories}}</td>
                <td>{{$list->section}}</td>
                <td>{{$list->tperiodid}}</td>
                <td>{{$list->dname}}</td>
                @if($list->completionstatus==0)
                <td><button type="button" class="btn btn-primary btn-sm">Ongoing</button>
                 <a href="{{url('groupmanager/reschedule/class/change/complete')}}/{{$list->id}}" class="btn btn-success btn-sm">Mark Complete</a>
                </td>

                @else
                <td><button type="button" class="btn btn-success btn-sm">Completed</button></td>
                @endif
            </tr>
            @endforeach
            @foreach($managerrescheduleddataopt as $list)
             <tr>
                <td>{{$list->tdateid}}</td>
                <td>{{$list->tdayid}}</td>
                <td>{{$list->tportalid}}</td>
                <td>{{$list->mname}}</td>
                <td>{{$list->categories}}</td>
                <td style="color:red">NA</td>
                <td>{{$list->tperiodid}}</td>
                <td>{{$list->dname}}</td>
                @if($list->completionstatus==0)
                <td><button type="button" class="btn btn-primary btn-sm">Ongoing</button>
                 <a href="{{url('groupmanager/reschedule/class/change/complete')}}/{{$list->id}}" class="btn btn-success btn-sm">Mark Complete</a>
                </td>
                @else
                <td><button type="button" class="btn btn-success btn-sm">Completed</button></td>
                @endif
            </tr>
            @endforeach

            @foreach($facultyrescheduleddata as $list)
            <tr>
                <td>{{$list->tdateid}}</td>
                <td>{{$list->tdayid}}</td>
                <td>{{$list->tportalid}}</td>
                <td>{{$list->fname}}</td>
                <td>{{$list->categories}}</td>
                <td>{{$list->section}}</td>
                <td>{{$list->tperiodid}}</td>
                <td>{{$list->dname}}</td>
                @if($list->completionstatus==0)
                <td><button type="button" class="btn btn-primary btn-sm">Ongoing</button>
                    <a href="{{url('groupmanager/reschedule/class/change/complete')}}/{{$list->id}}" class="btn btn-success btn-sm">Mark Complete</a>
                </td>
                @else
                <td><button type="button" class="btn btn-success btn-sm">Completed</button></td>
                @endif
            </tr>
            @endforeach
            @foreach($facultyrescheduleddataopt as $list)
             <tr>
                <td>{{$list->tdateid}}</td>
                <td>{{$list->tdayid}}</td>
                <td>{{$list->tportalid}}</td>
                <td>{{$list->fname}}</td>
                <td>{{$list->categories}}</td>
                <td style="color:red">NA</td>
                <td>{{$list->tperiodid}}</td>
                <td>{{$list->dname}}</td>
                @if($list->completionstatus==0)
                <td><button type="button" class="btn btn-primary btn-sm">Ongoing</button></td>
                @else
                <td><button type="button" class="btn btn-success btn-sm">Completed</button></td>
                @endif
            </tr>
            @endforeach
                              
                             
                         
                                                  
                        
                         
                       
                        
                      
                      </tbody>
                    </table>
                </div>
</div>
</div>
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
});

function sec(that){
    var classid = that.value;
          var sectionid=$('#class').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("groupmanager/rescheduling/classby/section/{id}")}}',
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
              url:'{{url("groupmanager/rescheduling/classby/section/{id}")}}',
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