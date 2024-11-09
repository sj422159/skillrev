@extends('supervisor/layout')
@section('title','Competition Students')
@section('Sector_select','active')
@section('container')
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
 <div class="container-fluid">
    <div class="row" >
          <div class="col-12">
            <!-- Custom Tabs -->
           
            <div class="card" style="margin-top:20px">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Competition</h3>
                 
                <ul class="nav nav-pills ml-auto p-2">
                 <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Applied</a></li>
                 <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Not Shortlisted</a></li>
                 <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Selected</a></li>
                 <li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab">Completed</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                     <div class="row">
                            <div class="col-lg-12">
                                 <div class="table-responsive table" style="padding:20px">
                                    <table id="example2" class="display nowrap" style="width:100%   ">
                                        <thead style="background-color:#000;color:#fff;">
                                           <tr>
                                              <th>Id</th>
                                              <th>Competition</th>
                                              <th>Student</th>
                                              <th>Email</th>
                                              <th>Phone</th>
                                              <th>Move To</th>
                                           </tr>
                                        </thead>
                                       <tbody>
        @php
        $count=1;
        @endphp                             
        @foreach($appliedstudents as $list)
            <tr>
            <td>{{$count}}</td>
            <td>{{$list->competitionname}}</td>
            <td>{{$list->sname}} {{$list->slname}}</td>
            <td>{{$list->semail}}</td>
            <td>{{$list->snumber}}</td>
            <td>
                <a href="{{url('groupmanager/competition/student/status/2')}}/{{$list->id}}"class="btn btn-danger btn-sm">Not Shortlisted</a>
                <a href="{{url('groupmanager/competition/student/status/3')}}/{{$list->id}}"class="btn btn-primary btn-sm">Selected</a>
            </td>
          </tr>
        @php
        $count+=1
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
                                   <table id="example1" class="display nowrap" style="width:100%   ">
                                        <thead style="background-color:#000;color:#fff;">
                                           <tr>
                                              <th>Id</th>
                                              <th>Competition</th>
                                              <th>Student</th>
                                              <th>Email</th>
                                              <th>Phone</th>
                                              <th>Move To</th>
                                            </tr>
                                       </thead>
                                       <tbody>
        @php
        $count=1;
        @endphp                             
        @foreach($notshortlistedstudents as $list)
            <tr>
            <td>{{$count}}</td>
            <td>{{$list->competitionname}}</td>
            <td>{{$list->sname}} {{$list->slname}}</td>
            <td>{{$list->semail}}</td>
            <td>{{$list->snumber}}</td>
            <td>
                <a href="{{url('groupmanager/competition/student/status/3')}}/{{$list->id}}"class="btn btn-primary btn-sm">Selected</a>
            </td>
          </tr>
        @php
        $count+=1
        @endphp  
        @endforeach
      
            
                                       </tbody>
       
                                   </table>
                                </div>
                            </div>
                           
                        
                    </div>
                  </div>

                    <div class="tab-pane" id="tab_3">
                     <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table" style="padding:20px">
                                   <table id="example1" class="display nowrap" style="width:100%   ">
                                        <thead style="background-color:#000;color:#fff;">
                                           <tr>
                                              <th>Id</th>
                                              <th>Competition</th>
                                              <th>Student</th>
                                              <!-- <th>Email</th>
                                              <th>Phone</th> -->
                                              <th>Comments</th>
                                              <th colspan="2" style="text-align:center;">Upload</th>
                                            </tr>
                                       </thead>
                                       <tbody>
        @php
        $count=1;
        @endphp                             
        @foreach($selectedstudents as $list)
            <tr>
            <td>{{$count}}</td>
            <td>{{$list->competitionname}}</td>
            <td>{{$list->sname}} {{$list->slname}}</td>
            <!-- <td>{{$list->semail}}</td>
            <td>{{$list->snumber}}</td> -->
            <td>{{$list->remarks}}</td>
            @if($list->certificatepdf!=0 && $list->certificatepdf==1)
            <form action="{{url('groupmanager/competition/student/savecertificate')}}" method="post" id="form{{$count}}" enctype="multipart/form-data">
                    @csrf
            <input type="hidden" form="form{{$count}}" name="competitionbookingid" value="{{$list->id}}">
            <td><input type="file" form="form{{$count}}" required="true" name="file" accept="application/pdf">
                <button type="submit" form="form{{$count}}" class="btn btn-primary btn-sm">Save</button>
            </td>
            </form>
            @else
            <td><a href="#" class="btn btn-primary btn-sm">No Action</a>
                <a href="{{url('groupmanager/competition/student/status/4')}}/{{$list->id}}"class="btn btn-success btn-sm">Move To Completed</a>
            </td>
            @endif
          </tr>
        @php
        $count+=1
        @endphp  
        @endforeach
      
            
                                       </tbody>
       
                                   </table>
                                </div>
                            </div>
                           
                        
                    </div>
                  </div>


                                    <div class="tab-pane" id="tab_4">
                     <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table" style="padding:20px">
                                   <table id="example1" class="display nowrap" style="width:100%   ">
                                        <thead style="background-color:#000;color:#fff;">
                                           <tr>
                                              <th>Id</th>
                                              <th>Competition</th>
                                              <th>Student</th>
                                              <th>Email</th>
                                              <th>Phone</th>
                                              <th>View</th>
                                            </tr>
                                       </thead>
                                       <tbody>
        @php
        $count=1;
        @endphp                             
        @foreach($completedstudents as $list)
            <tr>
            <td>{{$count}}</td>
            <td>{{$list->competitionname}}</td>
            <td>{{$list->sname}} {{$list->slname}}</td>
            <td>{{$list->semail}}</td>
            <td>{{$list->snumber}}</td>
            <td>
                @if($list->certificatepdf!=0)
                    <a href="{{url('pdf/competition')}}/{{$list->certificatepdf}}" target="_blank" class="btn btn-primary btn-sm">Certificate</a>
                @else
                    <a href="#" class="btn btn-primary btn-sm disabled">Certificate</a>
                @endif
            </td>
          </tr>
        @php
        $count+=1
        @endphp  
        @endforeach
      
            
                                       </tbody>
       
                                   </table>
                                </div>
                            </div>
                           
                        
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                 
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
        </div>
         
    
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
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
});
</script>
 
@endsection