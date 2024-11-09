@extends('caterer/layout')
@section('title','Profile')
@section('Profile','active')
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
<div class="row">
    <div class="col-md-12">
         
      
       
         <div class="table-responsive table" style="padding:20px" style="width:100%">
                          
                                      <table id="example1" class="display wrap" style="width:100%">
                <thead>
                    <br>
                    <tr>
                        <th>Food Category</th>
                        <th>Food Items</th>
                        <th>Price Type</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@php
                	$i=0;
                	@endphp
                    @foreach($data as $list)
                    @if(in_array($list->id,$check))

                    @else
                    <tr>
                        <td>{{$list->foodcategory}}</td>
                        <td>{{$list->fooditems}}</td>
                        <td>{{$list->ptype}}</td>
                        <td>{{$list->price}}</td>
                      
                        <td>
                          <form action="{{url('vendor/caterer/add/schoolmenu')}}" id="form{{$i}}" method="post">
                          	@csrf
                          	<select class="form-control" name="catererprice" required form="form{{$i}}">
                                <option value="">Select</option>
                          		 @foreach($price as $li)
                                       <option value="{{$li['val']}}">{{$li['type']}}</option>
                                   @endforeach 
                          	</select>
                            <input type="hidden" value="{{$list->id}}" required name="id" form="form{{$i}}">
                          	<button type="submit" class="btn btn-primary btn-sm" form="form{{$i}}">Add To Menu</button>
                          </form>
                        </td>
                    </tr>
                    @endif
                    @php
                    $i++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function yesnoChecked(that) {
    if (that.value != "") {
        document.getElementById('getskillattributes').click();    
     } 
  }
</script>


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
@endsection