@extends('supervisor/layout') 
@section('title','Leave') 
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
@if(session()->has('success'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success"></span>
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
<div class="card">
    <!-- /.card-header -->
    <div class="table-responsive table" style="padding:20px" style="width:100%">
        <table id="example1" class="display wrap" style="width:100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Approval</th>
                </tr>
            </thead>
            <tbody>
                @php
                $count=1;
                @endphp
                @foreach($facultyleave as $list)
                <tr>
                    <td>{{$count}}</td>
                    <td>Faculty</td>
                    <td>{{$list->fname}}</td>
                    <td>{{$list->fromdate}}</td>
                    <td>{{$list->todate}}</td>
                    <td>{{$list->reason}}</td>
                    <td>
                        @if($list->status==1)
                        <span class="right badge badge-primary">Applied</span>
                        @elseif($list->status==2)
                        <span class="right badge badge-danger">Rejected</span>
                        @elseif($list->status==3)
                        <span class="right badge badge-info">Inprogress</span>
                        @elseif($list->status==4)
                        <span class="right badge badge-success">Approved</span>
                        @endif
                    </td>
                    @if($list->status==1)
                        <td>
                        <a href="{{url('supervisor/inprogress/leave/status/3')}}/{{$list->id}}"><button type="button" class="btn btn-success btn-sm">Inprogress</button>
               </a>
                   <a href="{{url('supervisor/approve/leave/status/2')}}/{{$list->id}}"><button type="button" class="btn btn-danger btn-sm">Reject</button>
               </a>
               @if($list->visible==1)
                 <a href="{{url('supervisor/pendinglist')}}/{{$list->portalid}}/{{$list->profileid}}/{{$list->id}}/"><button type="button" class="btn btn-primary btn-sm">Pending List</button></a>
                @endif
           </td>
                 <td>
                     <button class="btn btn-secondary btn-sm">Not Applicable</button>
                 </td>

                    @else
                        <td>
                          @if($list->visible==1)
                         <a href="{{url('supervisor/pendinglist')}}/{{$list->portalid}}/{{$list->profileid}}/{{$list->id}}"><button type="button" class="btn btn-primary btn-sm">Pending List</button> </a>
                          @endif
                          <a href="{{url('supervisor/reschedule')}}/{{$list->portalid}}/{{$list->profileid}}/{{$list->id}}"><button type="button" class="btn btn-success btn-sm">Reschedule</button> </a>
                      </td>
                    @endif
                    @if($list->status==3) 
                    <td>
                        <a href="{{url('supervisor/approve/leave/status/4')}}/{{$list->id}}"><button type="button" class="btn btn-secondary btn-sm">Approve</button></a>
                    </td>
                    @elseif($list->status==4)
                    <td>
                        <button type="button" class="btn btn-success btn-sm">Approved</button>
                    </td>
                    @else
                        <button type="button" class="btn btn-success btn-sm">Waiting</button>
                    @endif
                </tr>
                @php
                $count++;
                @endphp
                @endforeach 
                @foreach($managerleave as $list)
                <tr>
                    <td>{{$count}}</td>
                    <td>Manager</td>
                    <td>{{$list->mname}}</td>
                    <td>{{$list->fromdate}}</td>
                    <td>{{$list->todate}}</td>
                    <td>{{$list->reason}}</td>
                    <td>
                        @if($list->status==1)
                        <span class="right badge badge-primary">Applied</span>
                        @elseif($list->status==2)
                        <span class="right badge badge-danger">Rejected</span>
                        @elseif($list->status==3)
                        <span class="right badge badge-info">Inprogress</span>
                        @elseif($list->status==4)
                        <span class="right badge badge-success">Approved</span>
                        @endif
                    </td>
                    @if($list->status==1)
                        <td>
                        <a href="{{url('supervisor/inprogress/leave/status/3')}}/{{$list->id}}"><button type="button" class="btn btn-success btn-sm">Inprogress</button>
               </a>
                   <a href="{{url('supervisor/approve/leave/status/2')}}/{{$list->id}}"><button type="button" class="btn btn-danger btn-sm">Reject</button>
               </a>
                        </td>
                    @else
                        <td>
                        <a href="#"><button type="button" class="btn btn-success btn-sm disabled">Inprogress</button>
               </a>
                   <a href="#"><button type="button" class="btn btn-danger btn-sm disabled">Reject</button>
               </a>
                        </td>
                    @endif
                    @if($list->status==3) 
                    <td>
                        <a href="{{url('supervisor/approve/leave/status/4')}}/{{$list->id}}"><button type="button" class="btn btn-secondary btn-sm">Approve</button></a>
                    </td>
                    @elseif($list->status==4)
                    <td>
                        <button type="button" class="btn btn-success btn-sm">Approved</button>
                    </td>
                    @else
                        <button type="button" class="btn btn-success btn-sm">Waiting</button>
                    @endif
                </tr>
                @php
                $count++;
                @endphp
                @endforeach 
            </tbody>
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