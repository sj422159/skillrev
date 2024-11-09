@extends('marketingmanager/layout')
@section('title','Marketing Officer')
@section('proctor','active extra')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="row">
          <div class="col-12">
            <div class="card">
<div class="card-header">
                <a href="{{url('employee/marketingmanager/createmarketingofficer')}}" style="margin-bottom:20px;">
<button type="button" class="btn btn-primary">Add Marketing Officer</button></a>
</div>

       <div class="table-responsive table" style="padding:20px">
                          
                                      <table id="example1" class="display nowrap" style="width:100%   ">
      <thead>
         <br>
         <tr>
            
                  
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Mobile Number</th>
                  <th>Email</th>
                  <th>Status</th>  
                  <th>Action</th>
         </tr>
      </thead>
      <tbody>
        
        @foreach($data as $list)

               <tr>
                   
                  <td>{{$list->mofname}}</td>
                  <td>{{$list->molname}}</td>
                   <td>{{$list->momobile}}</td>
                   <td>{{$list->moemail}}</td>
                  <td>
                     @if($list->mostatus==1)
                     <a href="{{url('employee/marketingmanager/marketingofficer/status/0')}}/{{$list->id}}"><button type="button" class="btn btn-primary">Active</button></a>
                     @else
                     <a href="{{url('employee/marketingmanager/marketingofficer/status/1')}}/{{$list->id}}"><button type="button" class="btn btn-secondary">Deactive</button></a>
                     @endif
                  </td>

                  <td>
                     <a href="{{url('employee/marketingmanager/marketingofficer/edit')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button></a>
                     <a href="{{url('employee/marketingmanager/marketingofficer/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button></a>
                  </td>
                 
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


    
 <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
    <script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
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
} );
</script>
@endsection