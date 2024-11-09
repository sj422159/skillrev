@extends('manager/layout') @section('title','Transfer Section') @section('Dashboard_select','active extra') @section('container') <style type="text/css"></style>
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
    <form action="{{url('manager/promote/section/students/bysection')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>SECTION :</label>
            <select class="form-control" name="section" required id="mainbranch" onchange="yes(this);">
                <option value="">Select</option>
                @foreach($sections as $list)
                @if($sec==$list->id)
                <option selected value="{{$list->id}}">{{$list->section}}</option>
                @else
                <option value="{{$list->id}}">{{$list->section}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display:flex;flex-direction: column;">
            <button type="submit" class="btn btn-success form-control" id="getjobroles" hidden="true">Fetch</button>
          </div>
        </div>
    </form>   
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Students</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Student</th>
                                            <th>Section</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $count=1;
                                        @endphp
                                        @foreach($students as $list)
                <tr class="tr-shadow">
                <td>{{$count}}</td>
                <td>{{$list->sname}} {{$list->slname}}</td>

                <form action="{{url('manager/promote/section/students/promoteortransfer')}}" method="post" id="form{{$count}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="studentid" value="{{$list->id}}">
                <td>
                <select class="multisteps-form__select form-control" name="sectionid" required="true" id="main">
                <option value="">Select</option>
                @foreach($sections as $li)
                @if($list->ssectionid==$li->id)
                <option selected value="{{$li->id}}">{{$li->section}}</option>
                @else
                <option value="{{$li->id}}">{{$li->section}}</option>
                @endif
                @endforeach
                </select>
                </td>
                <td>
                <button type="submit" form="form{{$count}}" class="btn btn-success btn-sm">Change</button>
                </td>
                </form>
                                                
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
@endsection