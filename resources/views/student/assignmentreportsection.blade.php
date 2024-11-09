@extends('student/layout')
@section('title','Assignments Reports')
@section('Dashboard_select','active')
@section('container')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="row">
          <div class="col-12">            
                       <div class="col-12">
            <!-- Custom Tabs --> 
                         <div class="card">
                          <div class="card-header bg-primary">
                            <h4 style="text-align:center;color:#fff">ASSIGNMENT</h4>
                          </div> 
              <!-- /.card-header -->
              <div class="card-body">
                
                         
                       <div class="row">
        <div class="col-12">
        
        <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
                  <thead>

                   
                   <tr  style="color:#fff !important;background-color: #000;text-transform: uppercase;">
                      
                      <th>Training Name</th>
                      <th>Result</th>
                      <th>Overall Grade</th>
                      <th>Question</th> 
                      <th>Answer</th> 
                      <th>Correct Answer</th> 
                  </tr>

                  </thead>
                  <tbody>
                    @foreach($data as $list)
                     <td>{{$list->trainingname}}</td>
                     <td>   @if($list->result=="Outstanding" || $list->result=="Excellent" || $list->result=="Very Good" || $list->result=="Good" || $list->result=="Average")
                       <span class="right badge badge-success">PASS</span>
                     @else
                         <span class="right badge badge-danger">FAIL</span>
                     @endif 
                   </td>
                     <td> @if($list->result=="Outstanding")
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

                     @endif </td>
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
                <!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
      
                
                <!-- /.tab-content -->
              
            <!-- ./card -->
          </div>
          <!-- /.col -->
      </div>
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