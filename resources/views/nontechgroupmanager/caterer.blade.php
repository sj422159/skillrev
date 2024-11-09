@extends('nontechgroupmanager/layout')
@section('title','Caterers')
@section('Profile','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="row">
    <div class="col-12">
     
       
            <div class="table-responsive table" style="padding:20px">
                @if(count($userroles)>0)
        <div class="col-12 col-sm-3 mt-sm-0">
            <a href="{{url('nontech/groupmanager/food/caterers/export')}}/{{$aid}}/{{$mid}}">
                <button type="button" class="btn btn-primary" style="margin-bottom:10px !important;">
                    Export
                </button> 
            </a>
        </div>
        @endif
                <table id="example2" class="display nowrap" style="width:100%   ">
                    <thead>
                        <br>
                        <tr>
                            <th>Role</th>
                            <th>Cafeteria Type</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Status</th>
                           
                        </tr>
                    </thead>
                    <tbody> @foreach($userroles as $list) <tr class="tr-shadow">
                            <td>Caterer</td>
                            <td>{{$list->ctype}}</td>
                            <td>{{$list->fname}}</td>
                            <td>{{$list->lname}}</td>
                             <td>{{$list->mobile}}</td>
                            <td>{{$list->email}}</td>
                            <td> @if($list->status==1) <a href="">
                                    <button type="button" class="btn btn-primary">Active</button>
                                </a> @else <a href="">
                                    <button type="button" class="btn btn-secondary">Deactive</button>
                                </a> @endif </td>
                          
                        </tr> @endforeach </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" defer></script>
<script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
        $('#example2').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script> @endsection