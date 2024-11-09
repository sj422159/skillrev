@extends('manager/layout') @section('title','Training Program') @section('Dashboard_select','active extra') @section('container') <style type="text/css"></style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
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
    <form action="{{url('manager/trainingprogram/bytrainingtypeandsubject')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>Training Type </label>
            <select class="form-control" name="trainingtype" required id="mainbranch">
                <option value="">Select</option>
                @foreach($trainingtypes as $list)
                <option value="{{$list->id}}">{{$list->type}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>Subject </label>
            <select class="form-control" name="subject" required id="subbranch" onchange="yes(this);">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>Training Program </label>
            <a href="{{url('manager/trainingprogram/addtraining')}}" style="margin-bottom:20px;">
            <button type="button" class="btn btn-primary">Create</button>  </a>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display:flex;flex-direction: column;">
            <button type="submit" class="btn btn-success form-control" id="getjobroles" hidden="true">Fetch</button>
          </div>
        </div>
    </form>   
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Training Program</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                        <th>Id</th>
                        <th>Training Type</th>
                        <th>Training</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Assign To Students</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $count=1;
                                        @endphp
                                        @foreach($trainingprogram as $list)
                    <tr class="tr-shadow">
                        <td>{{$count}}</td>
                        <td>{{$list->type}}</td>
                        <td>{{$list->trainingname}}</td>
                        <td>
                            @if($list->status==1)
                               <a href="{{url('manager/trainingprogram/status/0')}}/{{$list->id}}"><button type="button" class="btn btn-primary">Active</button>
                               </a>
                            @elseif($list->status==0)
                                <a href="{{url('manager/trainingprogram/status/1')}}/{{$list->id}}"><button type="button" class="btn btn-warning">Deactive</button>
                                </a>
                            @endif
                        </td>
                        <td>
                            @if($list->assignedornot==0)
                            <a href="{{url('manager/trainingprogram/addtraining')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('manager/trainingprogram/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
                            </a>
                            @elseif($list->assignedornot==1)
                            <button type="button" class="btn btn-success disabled">Edit</button>
                            <button type="button" class="btn btn-danger disabled">Delete</button>
                            @endif
                        </td>
                        <td>
                            @if($list->assignedornot==0)
                            <a href="{{url('manager/training/assign')}}/{{$list->id}}"><button type="button" class="btn btn-info">Assign</button>
                            </a>  
                            @elseif($list->assignedornot==1)
                                <button type="button" class="btn btn-info disabled">Assigned</button>
                            @endif
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
    jQuery('#mainbranch').change(function (){
        $('#subbranch').html('');
        let trainingtypeid=document.getElementById("mainbranch").value;
        jQuery.ajax({
            url:'{{url("manager/trainingprogram/view/subjects")}}',
            type:'get',
            data:{trainingtypeid:trainingtypeid},
            success:function(result){
            jQuery('#subbranch').html(result)
            }
        });
    });
});
</script> 
@endsection