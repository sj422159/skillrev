@extends('classteacher/layout')
@section('title','Completed Students')
@section('Dashboard_select','active')
@section('container')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="container-fluid">
        


            
               
              
                  <!-- /.tab-pane -->
                
                     <div class="row">
                            <div class="col-lg-12">
                                  <h3 class="card-title"><b>COMPLETED BATCH -  STUDENTS</b></h3>
           
                               
          

        <div class="table-responsive table" style="padding:20px">
        <table id="example2" class="display nowrap" style="width:100%   ">
        <thead>
         <tr>
            <th>Id</th>
            <th>Profile</th>
            <th>Student Name</th>
            <th>Training Name</th>
            <th>PRE Attempt</th>
            <th>PRE Status</th>
            <th>Post Attempt</th>
            <th>POST Status</th>
            <th>Reports </th>
           
         </tr>
      </thead>
      
        
       <tbody style="background-color:#fff">

               @php
                        $count=1;
                        @endphp
                        @foreach($appdata as $list)
                        <tr id="list">
                          <td>{{$count}}</td>
                          <td><img src="{{asset('studentimages')}}/{{$list->image}}" height="40px" width="40px" /></td>
                          <td>{{$list->sname}}</td>
                          <td>{{$list->trainingname}}</td> 
                          <td>{{$list->preattempt}}</td>
                          <td>
                              @if($list->manpreapprove!=0)
                               <button class="btn btn-success btn-sm">Approved</button>
                              @else
                                 @if($list->preresult=="FAIL")
                                <button class="btn btn-danger btn-sm">FAIL</button>
                              @else
                                 <button class="btn btn-success btn-sm">PASS</button>
                              @endif
                              @endif
                          </td>
                          <td>{{$list->postattempt}}</td>
                          <td>
                           @if($list->postgiven!=0)
                             
                             @if($list->manpostapprove!="1") 
                              @if($list->postresult=="FAIL")
                                <button class="btn btn-danger btn-sm">FAIL</button>
                              @else
                                 <button class="btn btn-success btn-sm">PASS</button>
                              @endif
                            @else
                              <button class="btn btn-success btn-sm">Approved</button>
                            @endif

                           @else
                           <button class="btn btn-warning btn-sm">Assesment Not Taken</button>
                           @endif
                          
                            
                          </td>
                           <td>
                           @if($list->postgiven!=0)
                                <a href="{{url('classteacher/examreport')}}/{{$list->id}}/{{$list->prereport}}" class="btn btn-primary btn-sm">Pre</a>
                                 <a href="{{url('classteacher/examreport')}}/{{$list->id}}/{{$list->postreport}}" class="btn btn-success btn-sm">Post</a>
                           @else
                           <button class="btn btn-secondary btn-sm">Not Applicable</button>
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
                  
                  <!-- /.tab-pane -->
                 
                  <!-- /.tab-pane -->
                
            
         
    
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