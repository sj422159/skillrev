@extends('student/layout') @section('title','Date') @section('Dashboard_select','active extra') @section('container') <style type="text/css"></style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
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
        <div class="col-12">
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Year - {{$year}}</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Class</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Bus</a></li>
                </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center !important;">Id</th>
                                            <th style="text-align:center !important;">Month</th>
                                            <th style="text-align:center !important;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $c=0;
                                        $count=1;
                                        @endphp
                                        @foreach($month as $list)
                                        <tr class="tr-shadow">
                                            <td style="text-align:center !important;">{{$count}}</td>
                                            <td style="text-align:center !important;">{{$month[$c]}}</td>
                                            <?php $a=date('m',strtotime($month[$c])); ?>
                                            <td style="text-align:center !important;">
                                                @if($currentmonth>=$a)  
                                                <a href="{{url('student/attendance/view/monthwise')}}/{{$a}}">View</a>
                                                @else
                                                <i class="fa-solid fa-lock"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                        $c++;
                                        $count++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example2" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center !important;">Id</th>
                                            <th style="text-align:center !important;">Month</th>
                                            <th style="text-align:center !important;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $c=0;
                                        $count=1;
                                        @endphp
                                        @if($transportattendance=="1")
                                        @foreach($month as $list)
                                        <tr class="tr-shadow">
                                            <td style="text-align:center !important;">{{$count}}</td>
                                            <td style="text-align:center !important;">{{$month[$c]}}</td>
                                            <?php $a=date('m',strtotime($month[$c])); ?>
                                            <td style="text-align:center !important;">
                                                @if($currentmonth>=$a)  
                                                <a href="{{url('student/bus/attendance/view/monthwise')}}/{{$a}}">View</a>
                                                @else
                                                <i class="fa-solid fa-lock"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                        $c++;
                                        $count++;
                                        @endphp
                                        @endforeach
                                        @else
                                        <tr class="tr-shadow">
                                        <td></td>
                                        <td style="text-align:center;">You have not opted for Transport</td> 
                                        <td></td>   
                                        </tr>
                                        @endif
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