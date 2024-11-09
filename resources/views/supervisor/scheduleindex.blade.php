@extends('supervisor/layout')
@section('title','Utilization')
@section('d','active')
@section('container')
<style type="text/css">
	th{
		font-size: 14px !important;
	}
	td{
		font-size: 12px !important;
	}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="container-fluid">
        
        

                    <div class="row">  
                        <div class="col-lg-12">
                          
                <h3 class="card-title"><b>Work - Schedule</b></h3>
           
                               
                      <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
      <thead style="background-color:#000;color:#fff">
         <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Class/Group</th>
            <th>Action</th>
            
         </tr>
      </thead>
      
        
       <tbody style="background-color:#fff">
           
            @foreach($faculties as $list)
             <tr>
             	<td>{{$list->fname}}</td>
             	<td><b>FACULTY</b></td>
                <td>{{$list->classid}}</td>
                <td></td>
             </tr>
            @endforeach
            
            @foreach($managers as $list)
             <tr>
             	<td>{{$list->mname}}</td>
             	<td><b>MANAGER</b></td>
                 <td>{{$list->classid}}</td>
                <td><a href="" class="btn btn-primary btn-sm">Assign</a></td>
             </tr>
            @endforeach
            
            @foreach($supervisor as $list)
             <tr>
             	<td>{{$list->supname}}</td>
             	<td><b>SUPERVISOR</b></td>
                <td>{{$list->groupid}}</td>
                <td><a href="" class="btn btn-primary btn-sm">Assign</a></td>
             </tr>
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