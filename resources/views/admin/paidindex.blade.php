@extends('admin/layout') 
@section('title','Students') 
@section('Dashboard_select','active extra') 
@section('container')
<style type="text/css">
    ::placeholder{
        background-color: blue;
    }
</style> 
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
            <form action="{{url('admin/fees/index/students/bysection')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>CLASS :</label>
            <select class="form-control" name="class" required id="topbranch">
                <option value="">Select</option>
                @foreach($classes as $list)
                <option value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>SECTION :</label>
            <select class="form-control" name="section" required id="mainbranch" onchange="yes(this);">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display:flex;flex-direction: column;">
            <button type="submit" class="btn btn-success form-control" id="getjobroles" hidden="true">Fetch</button>
          </div>
        </div>
    </form>   
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Students List</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="col-12">
                            @if($paymentcount==count($students))
                            <form action="{{url('admin/fees/index/fees/transfer')}}" method="post">
                            @csrf
                            <input type="hidden" name="class" value="{{$class}}">
                            <input type="hidden" name="section" value="{{$section}}">
                            <input type="checkbox" required="true" class="mt-4"> If you click <b> MONEY TRANSFER </b>all the students who are listed below their <b>REMAINING BALANCE FEES</b> will be <b>AUTOMATICALLY TRANSFERRED</b> to <b>LAST YEAR PENDING</b> & all <b>PAYMENT HISTORY</b> related to <b>STUDENT</b> will be <b>DELETED</b>, You <b>CANNOT REVERSE OR CHANGE</b> as this is a <b>ONE TIME PROCESS</b>, so what is done <b>CANNOT BE UNDONE</b> .<br> 
                            <button type="submit" class="btn btn-success btn-sm mt-2">MONEY TRANSFER</button>
                            </form>
                            @endif
                        </div>
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th>Registration No</th>
                                            <th>Student</th>
                                            <th>Father</th>
                                            <th>Number</th>
                                            <th>Fees</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $list)
                                        <tr class="tr-shadow">
                                            <td>{{$list->sregistrationnumber}}</td>
                                            <td>{{$list->sname}} {{$list->slname}}</td>
                                            <td>{{$list->sfathername}}</td> 
                                            <td>{{$list->snumber}}</td>
                                            <td>
                                            @if($list->visible==1)
                                            <a href="{{url('admin/fees/index/students/view/structure')}}/{{$list->id}}">
                                               <button class="btn btn-primary btn-sm">View</button>
                                            </a>
                                            @else
                                               <button class="btn btn-primary btn-sm disabled">Not Selected By Student</button>
                                            @endif
                                           </td>  
                                           <td>
                                            @if($list->visible==1)
                                            <a href="{{url('admin/fees/index/students/export')}}/{{$list->id}}">
                                               <button class="btn btn-info btn-sm">Export</button>
                                            </a>
                                            @else
                                               <button class="btn btn-info btn-sm disabled">Export</button>
                                            @endif
                                           </td>  
                                        </tr>
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
});
</script>  
@endsection