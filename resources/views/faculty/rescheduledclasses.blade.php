@extends('faculty/layout')
@section('title','Rescheduled Classes')
@section('Dashboard_select','active')
@section('container')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="container-fluid">
        
        

                    <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Rescheduled Classes</h3>
                   
                </div>
           
                    <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">           
                      <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
      <thead style="background-color:#000;color:#fff">
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
      
        
       <tbody style="background-color:#fff">
            @foreach($rescheduledata as $list)
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
                <td><a href="{{url('faculty/rescheduled/completed/1')}}/{{$list->id}}"><button type="button" class="btn btn-primary btn-sm">Complete</button></a></td>
                @else
                <td><a href="#"><button type="button" class="btn btn-success btn-sm">Completed</button></a></td>
                @endif
            </tr>
            @endforeach
              @foreach($rescheduledataopt as $list)
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