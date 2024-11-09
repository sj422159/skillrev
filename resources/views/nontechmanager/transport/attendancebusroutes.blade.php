@extends('nontechmanager/transport/layout')
 @section('title','Bus Routes') 
 @section('Dashboard_select','active extra') 
 @section('container') 
 <style type="text/css"></style>
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
    @if(session()->has('danger'))
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
            <span class="badge badge-pill badge-danger"></span>
            {{session('danger')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3"><?php echo $day=date("l", strtotime($todaydate)); ?>, {{$todaydate}} </h3>
                    <!-- <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Today</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Holidays</a></li>
                </ul> -->
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th>Bus Route</th>
                                            <th>Pickup-Departure</th>
                                            <th>Pickup-Arrival</th>
                                            <th>Drop-Departure</th>
                                            <th>Drop-Arrival</th>
                                            <th>Student</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($busroutes as $list)
                                        <tr class="tr-shadow">
                                            <td>{{$list->busroute}}</td>
                                            <td>{{$list->busroutepickupdeparture}}</td>
                                            <td>{{$list->busroutepickuparrival}}</td>
                                            <td>{{$list->busroutedropdeparture}}</td>
                                            <td>{{$list->busroutedroparrival}}</td>
                                            <td>
                                            @if($list->pstatus==0)
                                            <a href="{{url('nontech/manager/attendance/pickup/students')}}/{{$list->id}}">
                                               <button class="btn btn-primary btn-sm">Pickup View</button>
                                            </a>
                                            @else
                                               <button class="btn btn-primary btn-sm disabled">Pickup View</button>
                                            @endif
                                            @if($list->dstatus==0)
                                            <a href="{{url('nontech/manager/attendance/drop/students')}}/{{$list->id}}">
                                               <button class="btn btn-success btn-sm">Drop View</button>
                                            </a>
                                            @else
                                               <button class="btn btn-success btn-sm disabled">Drop View</button>
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
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
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script> 
@endsection