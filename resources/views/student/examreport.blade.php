@extends('student/layout')
@section('title','Reports')
@section('Dashboard_select','active')
@section('container')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="container-fluid">
        


                    <div class="row">  
                        <div class="col-lg-12">
                    
                               
                      <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
      <thead style="background-color:#000;color:#fff">
         <tr>
            <th>Id</th>
            <th>Training Name</th>
            <th>Reports</th>
         </tr>
      </thead>
      
        
       <tbody style="background-color:#fff">

               @php
                        $count=1;
                        @endphp
                        @foreach($data as $list)
                        <tr id="list">
                          <td>{{$count}}</td>
                          <td>{{$list->trainingname}}</td> 
                          <td>
                            @if($list->preapprove!=0)
                            @if($list->prereport!="0")
                           <a href="{{url('exam/sectionreport')}}/{{$list->id}}/{{$list->prereport}}/" class="btn btn-primary btn-sm" style="margin-right: 4px">PRE</a>
                           @else
                              <a href="" class="btn btn-primary btn-sm disabled" style="margin-right: 4px" >PRE</a>
                           @endif
                           @else
                            <a href="" class="btn btn-primary btn-sm disabled" style="margin-right: 4px" >PRE</a>
                           @endif


                           @if($list->studentassignmentid)
                           <a href="{{url('student/assignmentreport')}}/{{$list->studentassignmentid}}" class="btn btn-info btn-sm">Assignment</a> 
                           @else
                           <a href="" class="btn btn-info btn-sm disabled">Assignment</a> 
                           @endif


                            @if($list->postreport=="0")
                            <a href="" class="btn btn-success btn-sm disabled" style="margin-right: 4px" >POST</a>
                            @else
                              <a href="{{url('exam/sectionreport')}}/{{$list->id}}/{{$list->postreport}}/" class="btn btn-success btn-sm" style="margin-right: 4px">POST</a>
                            @endif	
                          </td>
                          

                        </tr>  
                           @php
                           $count+=1
                           @endphp
                           @endforeach  
               

           
      </tbody>
   </table>
                                </div>
                            </div>
                           
                        
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                 
                  <!-- /.tab-pane -->
                 
                  <!-- /.tab-pane -->
               



<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"  defer></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>   
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
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
    $('#example2').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
} );
</script>


@endsection