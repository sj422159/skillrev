@extends('faculty/layout')
@section('title','Assignments Completed Students')
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
    <div class="col-12">
      <div class="card" style="margin-top:20px">
        <div class="card-header d-flex p-0">
          <h3 class="card-title p-3">Students List</h3>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
              <div class="row">
                <div class="col-lg-12">
               
                  <div class="table-responsive table" style="padding:20px">
                    <table id="example1" class="display nowrap" style="width:100%   ">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Student</th>
                          <th>Email</th>
                          <th>Number</th>
                          <th>Result</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody> @php $count=1; @endphp @foreach($data as $list) 
                        <tr id="list">
                          <td>{{$count}}</td>
                          <td>{{$list->sname}}</td>
                          <td>{{$list->semail}}</td>
                          <td>{{$list->snumber}}</td>
                          <td><a href="#">{{$list->result}}</a></td>
                          <td>
                          @if($list->status==1)
                          <a href="#" class="btn btn-primary btn-sm" disabled>Not Submitted</a>
                          @elseif($list->status==2)
                          <a href="#" class="btn btn-primary btn-sm">Submitted</a>
                          @elseif($list->status==3)
                          <a href="#" class="btn btn-primary btn-sm">Corrected</a>
                          @elseif($list->status==4)
                          <a href="#" class="btn btn-primary btn-sm">Completed</a>
                          @endif
                          </td>
                        </tr> @php $count+=1 @endphp @endforeach 
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
  });
</script>
@endsection