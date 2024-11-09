@extends('nontechmanager/cafeteria/layout')
@section('title','Caterers')
@section('Dashboard_select','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="form-row">
        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
        <label>Food Items</label><br>
        <a href="{{url('nontech/manager/food/create/caterer')}}" style="margin-bottom:20px;">
            <button type="button" class="btn btn-primary">Add Caterer</button>
        </a>
    </div>

        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
            <label>Action</label><br>
            @if(count($data)>0)
            <a href="{{url('nontech/manager/food/caterer/export')}}/{{$mid}}"><button type="button"class="btn btn-success">Export</button></a>
            @else
            <a href="#"><button type="button"class="btn btn-success disabled">Export</button></a>
            @endif
        </div>
    </div>
    <div class="col-12">
        
       
            <div class="table-responsive table" style="padding:20px">
                <table id="example2" class="display nowrap" style="width:100%   ">
                    <thead>
                        <br>
                        <tr>
                            <th>Role</th>
                            <th>Cafeteria Type</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                           
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> @foreach($data as $list) <tr class="tr-shadow">
                            <td>Caterer</td>
                            <td>{{$list->ctype}}</td>
                            <td>{{$list->fname}}</td>
                            <td>{{$list->lname}}</td>
                           
                            <td> @if($list->status==1) <a href="{{url('nontech/manager/food/createuser/status/0')}}/{{$list->id}}">
                                    <button type="button" class="btn btn-primary">Active</button>
                                </a> @else <a href="{{url('nontech/manager/food/createuser/status/1')}}/{{$list->id}}">
                                    <button type="button" class="btn btn-secondary">Deactive</button>
                                </a> @endif </td>
                            <td>
                                <a href="{{url('nontech/manager/food/createuser')}}/{{$list->id}}">
                                    <button type="button" class="btn btn-success">Edit</button>
                                </a>
                                <a href="{{url('nontech/manager/food/createuser/delete')}}/{{$list->id}}">
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </a>
                            </td>
                        </tr> @endforeach </tbody>
                </table>
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