@extends('nontechgroupmanager/layout')
@section('title','Infrastructure Items')
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
<div class="card-header">
	<h3 style="text-align:center;">INFRASTRUCTURE ITEMS</h3>
</div>
<div class="row">

    <div class="col-md-12">
        <div class="table-responsive table" style="padding:20px">
        @if(count($items)>0)
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <a href="{{url('nontech/groupmanager/infra/items/export')}}/{{$id}}">
                <button type="button" class="btn btn-primary" style="margin-bottom:10px !important;">
                    Export
                </button> 
            </a>
        </div>
        @endif
        <table id="example1" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                    	<th>Item No</th>
                        <th>Item Name</th>
                        
                      
                    </tr>
                </thead>
                <tbody>
                	@php $i=1; @endphp
                    @foreach($items as $list)
                    <tr>
                    	<td>{{$i}}</td>
                        <td>{{$list->infraitem}}</td>
                        
                        
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
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
   
} );
</script>

@endsection