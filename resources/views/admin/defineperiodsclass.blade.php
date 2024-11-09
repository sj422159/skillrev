@extends('admin/layout')
@section('title','Periods')
@section('Dashboard_select','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="container-fluid">
    @if(session()->has('success'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success"></span>
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label></label><br>
           <a href="{{url('admin/periods/class/addclass')}}">
            <button type="button" class="btn btn-primary">Add</button></a>
        </div>
        <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Class</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab_1" data-toggle="tab">Regular</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_2" data-toggle="tab">Extra</a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive table" style="padding:20px">
                                        <table id="example1" class="display nowrap" style="width:100%   ">
                                            <thead style="background-color:#000;color:#fff;">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Class Name</th>
                                                    <th>Overall Total Periods</th>
                                                    <th>Optional Total Periods</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $count=1;
                                                @endphp
                                                @foreach($regularclass as $list)
                                                <tr>
                                                    <td>{{$count}}</td>
                                                    <td>{{$list->categories}}</td>
                                                    <td>{{$list->ctotalperiods}}</td>
                                                    <td>{{$list->ctotalperiodsopt}}</td>
                                                    <td>
                                                        <a href="{{url('admin/periods/class/addclass')}}/{{$list->id}}">
                                                            <button type="button" class="btn btn-info btn-sm">Edit</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @php
                                                $count++;
                                                @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive table" style="padding:20px">
                                        <table id="example2" class="display nowrap" style="width:100%   ">
                                            <thead style="background-color:#000;color:#fff;">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Class Name</th>
                                                    <th>Overall Total Periods</th>
                                                    <th>Optional Total Periods</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $count=1;
                                                @endphp
                                                @foreach($extraclass as $list)
                                                <tr>
                                                    <td>{{$count}}</td>
                                                    <td>{{$list->categories}}</td>
                                                    <td>{{$list->ctotalperiods}}</td>
                                                    <td>{{$list->ctotalperiodsopt}}</td>
                                                    <td>
                                                        <a href="{{url('admin/periods/class/addclass')}}/{{$list->id}}">
                                                            <button type="button" class="btn btn-info btn-sm">Edit</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @php
                                                $count++;
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
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']);
                });
</script>
@endsection