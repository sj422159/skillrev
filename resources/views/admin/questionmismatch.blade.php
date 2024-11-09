@extends('admin/layout')
@section('title','Mismatch Question')
@section('Dashboard_select','active')
@section('container')

<style type="text/css">
  td{
    font-size: 12px !important;
  }
  th{
  	font-size: 12px !important;
  }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="row">
          <div class="col-12">
            <div class="card">

       <div class="table-responsive table" style="padding:20px">
                          
                                      <table id="example1" class="display" style="width:100%   ">
      <thead>
         <br>
         <tr>
         	<th colspan="7" style="text-align:center;">Answer Mismatch Questions</th>
         </tr>
         <tr>
            
                  
                  <th>SId</th>
                  <th>Subject</th>
                  <th>Module</th>
                  <th>Chapter</th>
                  <th style="width:40% !important">Question</th>
                  <th>Action</th>
                  
         </tr>
      </thead>
      <tbody> 
      	       @php
      	       $count=0;
      	       @endphp
      	       @foreach($que as $list)
                 @if($list->RightChoices==$list->choice1 || $list->RightChoices==$list->choice2 || $list->RightChoices==$list->choice3 || $list->RightChoices==$list->choice4)

                 @else
                 @php
                 $count++;
                 @endphp
                 <tr>
                 	<td>{{$count}}</td>
                  <td>{{$list->domain}}</td>
                  <td>{{$list->skillset}}</td>
                  <td>{{$list->skillattribute}}</td>
                 	<td>{{$list->qtext}}</td>
                 	<td> <a href="{{url('admin/question/edit')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button></td>
                 </tr>
                 @endif
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