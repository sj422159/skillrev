@extends('admin/layout')
@section('title','Assignments Students')
@section('Dashboard_select','active')
@section('container')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="container-fluid">
        
        

                    <div class="row">  
                        <div class="col-lg-12">
                          
                <h3 class="card-title"><b>ATTENDED BATCH - STUDENTS - ASSIGNMENTS</b></h3>
           
                               
                      <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
      <thead style="background-color:#000;color:#fff">
         <tr>
            <th>Id</th>
            <th>Faculty Name</th>
            <th>Question</th>
            <th>Answer</th>
            <th>Evaluated Answer</th>
            <th>Status</th>
            <th>Score</th>
         </tr>
      </thead>
      
        
       <tbody style="background-color:#fff">

               @php
                        $count=1;
                        @endphp
                        @foreach($data as $list)
                        <tr id="list">
                          <td>{{$count}}</td>
                          <td>{{$list->fname}}</td>
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
                          <a href="#" class="btn btn-primary btn-sm" disabled>Not Submitted</a>
                          @elseif($list->status==2)
                          <a href="#" class="btn btn-primary btn-sm">Submitted</a>
                          @elseif($list->status==3)
                          <a href="#" class="btn btn-primary btn-sm">Corrected</a>
                          @elseif($list->status==4)
                          <a href="#" class="btn btn-primary btn-sm">Completed</a>
                          @endif
                          </td>
                          <td>
                                 @if($list->result=="Outstanding")
                       <span class="right badge badge-success">Outstanding</span>
                     @elseif($list->result=="Excellent")
                         <span class="right badge badge-success">Excellent</span>

                     @elseif($list->result=="Very Good")
                          <span class="right badge badge-primary">Very Good</span>
                     @elseif($list->result=="Good")
                           <span class="right badge badge-primary">Good</span>
                     @elseif($list->result=="Average")
                           <span class="right badge badge-warning">Average</span>
                     @else
                           <span class="right badge badge-warning">To Be Declared</span>

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