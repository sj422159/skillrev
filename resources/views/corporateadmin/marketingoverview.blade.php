@extends('corporateadmin//layout')
@section('title','Marketing Manager')
@section('Dashboard_select','active extra')
@section('container')
<style type="text/css">

</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="container-fluid">
        


             <div class="row" >
          <div class="col-12">
            <!-- Custom Tabs -->
           
            <div class="card" style="margin-top:20px">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Marketing Manager</h3>
                 
                <!-- <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">SkillRevelation</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Explicit</a></li>
                </ul> -->
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <div class="col-lg-12">
                    @if(count($data)>0)
                    <!-- <a href="{{url('corporateadmin/userroles/export/1')}}"><button type="button" class="btn btn-sm btn-primary">Export</button></a> -->
                    @endif
                    </div>


        <div class="table-responsive table" style="padding:20px">
        <table id="example2" class="display nowrap" style="width:100%   ">
        <thead>
       
          <tr>
                  <th>Id</th>
                  <th>Role</th>
                  <th>First Name</th>
                  <th>Last Name</th> 
                  <th>Email</th>
                  <th>Mobile</th> 
                  <th>Action</th>

        
          
        </tr>
        </thead>
        <tbody>
        @php
                        $count=1;
                        @endphp
        @foreach($data as $list)

               <tr class="tr-shadow">
                   
                 
                  <td>{{$count}}</td>
                  <td>Marketing Manager</td>
                  <td>{{$list->fname}}</td>
                  <td>{{$list->lname}}</td>
                  <td>{{$list->email}}</td>
                  <td>{{$list->mobile}}</td>
                    

                  <td>
                     <a href="{{url('corporateadmin/marketing/view')}}/{{$list->id}}"><button type="button" class="btn btn-primary btn-sm">View</button></a>
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



