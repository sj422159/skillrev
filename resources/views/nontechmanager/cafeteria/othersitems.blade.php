@extends('nontechmanager/cafeteria/layout')
@section('title','Hostel Items')
@section('Dashboard_select','active')
@section('container')

<style type="text/css">
    td,a,button{
        font-size: 12px;
        word-wrap: break-word !important;
    }
    th{
        font-size: 14px;

    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
@if(session()->has('success'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success"></span>
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif

<div class="card">
    
    <div class="form-row">
        <div class="col-12 col-sm-2 ml-4 mt-4">
            @if(count($data)>0)
            <a href="{{url('nontech/manager/Cafeteria/school/hostel/others/export')}}/3/{{$aid}}"><button type="button"class="btn btn-success">Export</button></a>
            @else
            <a href="#"><button type="button"class="btn btn-success disabled">Export</button></a>
            @endif
        </div>
    </div>
  
         <div class="table-responsive table" style="padding:20px" style="width:100%">
                          
                                      <table id="example1" class="display wrap" style="width:100%">
      <thead>
               
                <tr>
                    <th>Cafeteria</th>
                   
                    <th>Items</th>
                    <th>Item No</th>  
                    <th>Item Desc</th> 
                    <th>Status</th>   
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $list)
            <tr>
                  
                  <td>{{$list->cafeteria}}</td>
                  <td>{{$list->infraitem}}</td>
                  <td>{{$list->itemno}}</td>
                  <td>{{$list->itemdesc}}</td>
                  <td>
                      @if($list->repair==0)
                      <span class="right badge badge-success">Good</span>
                      @elseif($list->repair==1)
                      <span class="right badge badge-danger">Repair Requested</span>
                      @else
                      <span class="right badge badge-warning">Repair Inprogress</span>
                      @endif
                  </td>
                  <td>
                    @if($list->repair==0)
                      <a href="{{url('nontech/manager/Cafeteria/repair')}}/{{$list->id}}" class="btn btn-danger btn-sm">Request Repair</a></td>
                      @elseif($list->repair==1)
                      <a href="" class="btn btn-secondary btn-sm disabled">No Action</a></td>
                      @else
                        <a href="{{url('nontech/manager/Cafeteria/repair/completed')}}/{{$list->id}}" class="btn btn-success btn-sm">Repair Completed</a></td>
                      @endif
            </tr>
          @endforeach
            </tbody>
       </table>
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




<script>
  

</script>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

jQuery(document).ready(function(){

           jQuery('#category').change(function (){
            
             
           let cid=jQuery(this).val();
        
                        
           $('#domain').html('');
            $.ajax({
              url:'{{url("nontech/manager/infrastructure/hostels/getroom")}}',
              type:'GET',
              data:{cid:cid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                   
                        $('#domain').prop('disabled', false).append('<option value="'+section.id+'">'+section.roomname+'</option>');
                   
                });
              }
          });
         
           });         

});


 

</script>

@endsection