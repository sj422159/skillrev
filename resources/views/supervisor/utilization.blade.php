@extends('supervisor/layout')
@section('title','Utilization')
@section('d','active')
@section('container')
<style type="text/css">
	th{
		font-size: 12px !important;
	}
	td{
		font-size: 10px !important;
        text-align: center;
	}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="container-fluid">
        
        

                    <div class="row">  
                        <div class="col-lg-12">
                          
                <h3 class="card-title"><b>STAFF - UTILIZATION</b></h3>
           
                               
                      <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
      <thead style="background-color:#000;color:#fff">
         <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Total</th>
            <th>Action</th>
            
         </tr>
      </thead>
      
        
       <tbody style="background-color:#fff">
           
            @foreach($faculties as $list)
             <tr>
             	<td><a href="{{url('groupmanager/faculty/list')}}/{{$type}}/{{$list->id}}/0"><b>{{$list->fname}}</b></a></td>
             	<td><b>FACULTY</b></td>
                <td><b>{{$list->monday}}</b></td>
                <td><b>{{$list->tuesday}}</b></td>
                <td><b>{{$list->wednesday}}</b></td>
                <td><b>{{$list->thursday}}</b></td>
                <td><b>{{$list->friday}}</b></td>
                <td><b>{{$list->saturday}}</b></td>
                <td style="background-color:lavender;color:red;font-size: 14px !important"><b>{{(int)$list->monday+(int)$list->tuesday+(int)$list->wednesday+(int)$list->thursday+(int)$list->friday+(int)$list->saturday}}</b></td>
                <td><a href="{{url('groupmanager/faculty/schedule')}}/{{$list->id}}" class="btn btn-primary btn-sm">Schedule</a></td>
             </tr>
            @endforeach
            
            @foreach($managers as $list)
             <tr>
             	<td><b><a href="{{url('groupmanager/manager/list')}}/{{$type}}/{{$list->id}}/0"> {{$list->mname}}</a></b></td>
             	<td><b>MANAGER</b></td>
                <td><b>{{$list->monday}}</b></td>
                <td><b>{{$list->tuesday}}</b></td>
                <td><b>{{$list->wednesday}}</b></td>
                <td><b>{{$list->thursday}}</b></td>
                <td><b>{{$list->friday}}</b></td>
                <td><b>{{$list->saturday}}</b></td>
                <td style="background-color:lavender;color:red;font-size: 14px !important"><b>{{(int)$list->monday+(int)$list->tuesday+(int)$list->wednesday+(int)$list->thursday+(int)$list->friday+(int)$list->saturday}}</b></td>
                <td><a href="{{url('groupmanager/manager/schedule')}}/{{$list->id}}" class="btn btn-primary btn-sm">Schedule</a></td>
             </tr>
            @endforeach
            
            @foreach($supervisors as $list)
             <tr>
                <td><b><a href="{{url('groupmanager/own/list')}}/{{$type}}/{{$list->id}}/0"> {{$list->supname}}</a></b></td>
                <td><b>GROUP MANAGER</b></td>
                <td><b>{{$list->monday}}</b></td>
                <td><b>{{$list->tuesday}}</b></td>
                <td><b>{{$list->wednesday}}</b></td>
                <td><b>{{$list->thursday}}</b></td>
                <td><b>{{$list->friday}}</b></td>
                <td><b>{{$list->saturday}}</b></td>
                <td style="background-color:lavender;color:red;font-size: 14px !important"><b>{{(int)$list->monday+(int)$list->tuesday+(int)$list->wednesday+(int)$list->thursday+(int)$list->friday+(int)$list->saturday}}</b></td>
                <td><a href="{{url('groupmanager/own/schedule')}}/{{$list->id}}" class="btn btn-primary btn-sm">Schedule</a></td>
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