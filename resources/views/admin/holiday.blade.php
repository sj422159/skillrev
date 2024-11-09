@extends('admin/layout') 
@section('title','Holidays') 
@section('Dashboard_select','active') 
@section('container') 
<style type="text/css">
    td,
    a,
    button {
        font-size: 12px;
        word-wrap: break-word !important;
    }

    th {
        font-size: 14px;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css"> 
@if(session()->has('success')) <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
    <span class="badge badge-pill badge-success"></span>
    {{session('success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div> @endif 
<form action="{{url('admin/holiday/upload')}}" method="post" enctype="multipart/form-data"> @csrf <div class="form-row">
        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
            <label>Excel Sheet</label><br>
            <a href="{{url('studentdetails/holidaytemplate.xlsx')}}">
                <button type="button" class="btn btn-success btn-sm"> Download </button>
            </a>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Excel File</label>
            <input type="file" name='excel' id="file" required="true">
        </div>
        <div class="col-12 col-sm-2 mt-4 mt-sm-0" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes">Upload</button>
        </div>
    </div>
    <div class="form-row mt-4"></div>
</form>
<div class="card">
    <!-- /.card-header -->
    <div class="table-responsive table" style="padding:20px" style="width:100%">
        <table id="example1" class="display wrap" style="width:100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Holiday Name</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $count=1;
                @endphp
                @foreach($data as $list)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$list->holidayname}}</td>
                    <td>{{$list->date}}</td>
                    <td>
                        <a href="{{url('admin/holiday/edit')}}/{{$list->id}}">
                            <button type="button" class="btn btn-success btn-sm">Edit</button>
                        </a>
                        <a href="{{url('admin/holiday/delete')}}/{{$list->id}}">
                            <button type="button" class="btn btn-danger btn-sm">Delete</button>
                        </a>
                    </td>
                </tr>
                @php
                $count++;
                @endphp
                @endforeach </tbody>
        </table>
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
    });
</script>
</script> 
@endsection