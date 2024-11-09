@extends('supervisor/layout')
@section('title','Completed Batch')
@section('Dashboard_select','active')
@section('container')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="container-fluid">
        


             <div class="row" >
          <div class="col-12">
            <!-- Custom Tabs -->
           
            <div class="card" style="margin-top:20px">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Completed Students</h3>
                 
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Not Approved</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Approved</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">  
                        <div class="col-lg-12">
                
                               
                      <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
      <thead>
          <tr>
            <th>Id</th>
            <th>Training Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Total Students</th>
            <th>View Students</th>
            
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
                          <td>{{$list->categories}}</td>
                           <td>{{$list->section}}</td>
                          <td>{{$list->stucount}}</td>
                         <td><a href="{{url('supervisor/completed/students')}}/{{$list->id}}/" class="btn btn-primary btn-sm">View</a></td>
                         
                          
                          

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
                  <div class="tab-pane" id="tab_2">
                     <div class="row">
                            <div class="col-lg-12">
                               
          

        <div class="table-responsive table" style="padding:20px">
        <table id="example2" class="display nowrap" style="width:100%   ">
        <thead>
         <tr>
             <th>Id</th>
            <th>Training Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Total Students</th>
            <th>View Students</th>
            
         </tr>
      </thead>
      
        
       <tbody style="background-color:#fff">

               @php
                        $count=1;
                        @endphp
                        @foreach($appdata as $list)
                        <tr id="list">
                          <td>{{$count}}</td>
                        
                          <td>{{$list->trainingname}}</td> 
                            <td>{{$list->categories}}</td>
                           <td>{{$list->section}}</td>
                          <td>{{$list->stucount}}</td>
                          
                            <td><a href="{{url('supervisor/completed/students/approved')}}/{{$list->id}}/" class="btn btn-primary btn-sm">View</a></td>  
                         
                         
                          
                           
                          

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
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
        </div>
         
    
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