@extends('corporateadmin/layout')
@section('title','School List')
@section('dashboard_select','active extra')
@section('container')
<style type="text/css">

</style>
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
      <div class="col-12">
         <div class="card" style="margin-top:20px">
            <div class="card-header d-flex p-0">
                   
                    <ul class="nav nav-pills ml-auto p-2">
                         <li class="nav-item"><a class="nav-link active"  href="#tab_1" data-toggle="tab">Approval Pending</a></li>
                         <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Active</a></li>
                    </ul>
                </div>
            <div class="card-body">

               <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                     <div class="table-responsive table" style="padding:20px">
                        <table id="example2" class="display nowrap" style="width:100%   ">
                           <thead>
                              <tr>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>Number</th>
                                 <th>Status</th>
                                 <th>Action</th>
                              </tr>
                            </thead>
                            <tbody> 
                            @foreach($schools as $list) 
                            <tr>
                              <td>{{$list->aname}}</td>
                              <td>{{$list->aemail}}</td>
                              <td>{{$list->anumber}}</td>
                              <td> 
                                 @if($list->status==1) 
                                    <a href="{{url('corporateadmin/school/status/0')}}/{{$list->id}}">
                                       <button type="button" class="btn btn-sm btn-primary">Active</button>
                                    </a> 
                                 @elseif($list->status==0) 
                                    <a href="{{url('corporateadmin/school/status/1')}}/{{$list->id}}">
                                       <button type="button" class="btn btn-sm btn-warning">Deactive</button>
                                    </a> 
                                 @endif 
                                </td>
                              <td> 
                                 @if($list->mailstatus==1) 
                                    <a href="#">
                                       <button type="button" class="btn btn-sm btn-success">Sent</button>
                                    </a> 
                                    <a href="{{url('corporateadmin/school/mail')}}/{{$list->id}}">
                                       <button type="button" class="btn btn-sm btn-primary">Resend</button>
                                    </a> 
                                 @elseif($list->mailstatus==0) 
                                    <a href="#">
                                       <button type="button" class="btn btn-sm btn-info">Unsent</button>
                                    </a> 
                                    <a href="{{url('corporateadmin/school/mail')}}/{{$list->id}}">
                                       <button type="button" class="btn btn-sm btn-primary">Send</button>
                                    </a> 
                                 @endif 
                              </td>
                              </tr> 
                            @endforeach 
                            </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab_2">
                       <div class="table-responsive table" style="padding:20px">
                        <table id="example1" class="display nowrap" style="width:100%   ">
                           <thead>
                              <tr>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>Number</th>
                                 <th>Status</th>
                                 <th>Action</th>
                              </tr>
                            </thead>
                            <tbody> 
                            @foreach($schools1 as $list) 
                            <tr>
                              <td>{{$list->aname}}</td>
                              <td>{{$list->aemail}}</td>
                              <td>{{$list->anumber}}</td>
                              <td> 
                                 @if($list->status==1) 
                                    <a href="{{url('corporateadmin/school/status/0')}}/{{$list->id}}">
                                       <button type="button" class="btn btn-sm btn-primary">Active</button>
                                    </a> 
                                 @elseif($list->status==0) 
                                    <a href="{{url('corporateadmin/school/status/1')}}/{{$list->id}}">
                                       <button type="button" class="btn btn-sm btn-warning">Deactive</button>
                                    </a> 
                                 @endif 
                                </td>
                              <td> 
                                 @if($list->mailstatus==1) 
                                    <a href="#">
                                       <button type="button" class="btn btn-sm btn-success">Sent</button>
                                    </a> 
                                    <a href="{{url('corporateadmin/school/mail')}}/{{$list->id}}">
                                       <button type="button" class="btn btn-sm btn-secondary">Resend</button>
                                    </a> 
                                 @elseif($list->mailstatus==0) 
                                    <a href="#">
                                       <button type="button" class="btn btn-sm btn-info">Unsent</button>
                                    </a> 
                                    <a href="{{url('corporateadmin/school/mail')}}/{{$list->id}}">
                                       <button type="button" class="btn btn-sm btn-primary">Send</button>
                                    </a> 
                                 @endif 
                                 <a href="{{url('corporateadmin/school/data')}}/{{$list->id}}" class="btn btn-primary btn-sm">Get Data</a>
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
<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"  defer></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>   
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script type="text/javascript"> 
  $(document).ready(function() {
   $('#example1').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
    $('#example2').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
} );
</script>
@endsection