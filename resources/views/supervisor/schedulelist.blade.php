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
                          
                <h3 class="card-title" style="text-transform: uppercase;"><b>{{$Name}} - {{$role}} - SCHEDULE</b></h3>
           
                               
                      <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
      <thead style="background-color:#000;color:#fff">
         <tr>
            <th>DAY</th>
            <th>CLASS</th>
            @if($stype==1)
            <th>SECTION</th>
            @endif
            <th>PERIOD</th>
            <th>SUBJECT</th>
             @if($stype==1)
            <th>ACTION</th>
            @endif
            
         </tr>
      </thead>
      
        
       <tbody style="background-color:#fff">
           
            @foreach($data as $list)
             <tr>
             	<td>{{$list->tdayid}}</td>
             	<td>{{$list->categories}}</td>
                 @if($stype==1)
                <td>{{$list->section}}</td>
                @endif
                <td>{{$list->tperiodid}}</td>
                <td>{{$list->domain}}</td>
                 @if($stype==1)

                @if($role=="FACULTY")
                <td>
                    <a href="{{url('groupmanager/schedule/edit')}}/{{$list->id}}" class="btn btn-primary btn-sm">Edit</a>
                    <a href="{{url('groupmanager/schedule/delete')}}/{{$list->id}}/{{$id}}" class="btn btn-danger btn-sm">Delete</a>
                </td>
                @endif
                @if($role=="MANAGER")
                <td>
                    <a href="{{url('groupmanager/manager/schedule/edit')}}/{{$list->id}}" class="btn btn-primary btn-sm">Edit</a>
                    <a href="{{url('groupmanager/manager/schedule/delete')}}/{{$list->id}}/{{$id}}" class="btn btn-danger btn-sm">Delete</a>
                </td>
                @endif
                @if($role=="GROUPMANAGER")
                <td>
                    <a href="{{url('groupmanager/own/schedule/edit')}}/{{$list->id}}" class="btn btn-primary btn-sm">Edit</a>
                    <a href="{{url('groupmanager/own/schedule/delete')}}/{{$list->id}}/{{$id}}" class="btn btn-danger btn-sm">Delete</a>
                </td>
                @endif
                @endif
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