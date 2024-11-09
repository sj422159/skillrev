@extends('corporateadmin/layout')
@section('title','Marketing Officer')
@section('dashboard_select','active extra')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="container-fluid">
        <div class="row" >
          <div class="col-12">
            <div class="card" style="margin-top:20px">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Marketing Officer</h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                       <div class="row">
                            <div class="col-lg-12">
                @if(count($marketingofficer)>0)
                <!-- <a href="{{url('corporateadmin/marketingofficer/export')}}/{{$id}}"><button type="button" class="btn btn-primary btn-sm">Export</button></a> -->
                @endif
                                <div class="table-responsive table" style="padding:20px">
        <table id="example2" class="display nowrap" style="width:100%   ">
        <thead>
       
                                           <tr>
                                              <th>Id</th>
            <th>Marketing Manager</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Cold Calls</th>
                                            </tr>
                                       </thead>
                                       <tbody>
            @php
            $count=1;
            @endphp                             
            @foreach($marketingofficer as $list)
                        <tr>
                          <td>{{$count}}</td>
                          <td>{{$list->fname}} {{$list->lname}}</td> 
                          <td>{{$list->mofname}} {{$list->molname}}</td> 
                          <td>{{$list->moemail}}</td> 
                          <td>{{$list->momobile}}</td> 
                          <td><a href="{{url('corporateadmin/marketingofficer/view/coldcalls')}}/{{$list->id}}" class="btn btn-primary btn-sm">Check</a></td> 
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
                </div>
              </div>
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