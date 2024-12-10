@extends('admin/layout') @section('title','Date') @section('Dashboard_select','active extra') @section('container') <style type="text/css"></style>
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
            <form action="{{url('admin/attendance/view/students/bydate')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>CLASS :</label>
            <select class="form-control" name="class" required id="topbranch">
                <option value="">Select</option>
                @foreach($classes as $list)
                @if($class==$list->id)
                <option selected value="{{$list->id}}">{{$list->categories}}</option>
                @else
                <option value="{{$list->id}}">{{$list->categories}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>SECTION :</label>
            <select class="form-control" name="section" required id="mainbranch">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>MONTH :</label>
            <select class="form-control" name="month" required id="subbranch">
                <option value="">Select</option>
                @php
                $c=0;
                @endphp
                @foreach($months as $list)
                <?php $a=date('m',strtotime($months[$c])); ?>
                @if($currentmonth>=$a)  
                @if($month==$a)
                <option selected value="{{$a}}">{{$months[$c]}}</option>
                @else
                <option value="{{$a}}">{{$months[$c]}}</option>
                @endif
                @endif
                @php
                $c++;
                @endphp
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>DATE :</label>
            <select class="form-control" name="date" required onchange="yes(this);" id="childbranch">
                <option value="">Select</option>
                <option selected value="{{$dates}}">{{$dates}}</option>
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display:flex;flex-direction: column;">
            <button type="submit" class="btn btn-success form-control" id="getjobroles" hidden="true">Fetch</button>
          </div>
        </div>
    </form>   
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Year - {{$year}}</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Month</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $c=0;
                                        $count=1;
                                        @endphp
                                        @foreach($student as $list)
                                        <tr class="tr-shadow">
                                            <td>{{$count}}</td>
                                            <td>{{$student[$c]}}</td> 
                                            <td>
                                            @if($attendances[0]->attendancetype=="1")
                                                @if(($attendance[$c]=="Present"))
                                                <span class="right badge badge-success">{{$attendance[$c]}}</span>
                                                @else
                                                <span class="right badge badge-warning">{{$attendance[$c]}}</span>
                                                @endif
                                                @elseif($attendances[0]->attendancetype=="2")
                                                <span class="right badge badge-danger">{{$attendance[$c]}}</span>
                                                @elseif($attendances[0]->attendancetype=="3")
                                                <span class="right badge badge-primary">{{$attendance[$c]}}</span>
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
<script>
  function yes(that) {
    if (that.value != " ") {
        document.getElementById('getjobroles').click();     
     } 
  }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
<script>
jQuery(document).ready(function(){
    jQuery('#topbranch').change(function (){
        let classid=document.getElementById("topbranch").value;
        jQuery.ajax({
            url:'{{url("admin/attendance/view/sections")}}',
            type:'get',
            data:{classid:classid},
            success:function(result){
            jQuery('#mainbranch').html(result)
            }
        });
    });
    jQuery('#subbranch').change(function (){
        let sectionid=document.getElementById("mainbranch").value;
        let monthid=document.getElementById("subbranch").value;
        jQuery.ajax({
            url:'{{url("admin/attendance/view/dates")}}',
            type:'get',
            data:{monthid:monthid,sectionid:sectionid},
            success:function(result){
            jQuery('#childbranch').html(result)
            }
        });
    });
});
</script>  
@endsection