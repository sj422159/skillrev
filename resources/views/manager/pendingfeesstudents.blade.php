@extends('manager/layout') 
@section('title','Pending Fees Students') 
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
            <form action="{{url('manager/fees/pending/students/bysection')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>CLASS :</label>
            <select class="form-control" name="class" required id="topbranch" readonly>
                @foreach($classes as $list)
                <option value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>SECTION :</label>
            <select class="form-control" name="section" required id="mainbranch" onchange="yes(this);">
                <option value="">Select</option>
                @foreach($sections as $list)
                @if($section==$list->id)
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
                    <h3 class="card-title p-3">Students List</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Clear Pending Fees</a></li>
                  <!-- <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Upload Pending Fees</a></li> -->
                </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                        @if(count($students)>0)
                        <a href="{{url('manager/fees/pending/students/export')}}/{{$class}}/{{$section}}" class="btn btn-success btn-sm">Export</a>
                        @else
                        <a href="#" class="btn btn-success disabled btn-sm">Export</a>
                        @endif
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th>Registration No</th>
                                            <th>Student</th>
                                            <th>Father</th>
                                            <th>Fee Pending</th>
                                            <th>Fee Paid</th>
                                            <th>Reciept</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $count=1;
                                        @endphp
                                        @foreach($students as $list)
                                        <tr class="tr-shadow">
                                            <td>{{$list->sregistrationnumber}}</td>
                                            <td>{{$list->sname}} {{$list->slname}}</td>
                                            <td>{{$list->sfathername}}</td> 
                                             
            <input type="hidden" form="formb" name="studentid[]" value="{{$list->id}}">
            <td><input type="number" form="formb" name="amount[]" value="{{$list->spendingfees}}"readonly></td>
            <td><input type="number" form="formb" name="paidamount[]" min="1" max="{{$list->spendingfees}}" oninput="getmoney(this)" data-count="{{$count}}"></td>
            <td><input type="file" id="{{$count}}photos" form="formb" name="photos{{$count}}"></td>
            </form>
                                            <td>
                                            @if($list->spendingfees=="0")
                                               <button disabled class="btn btn-success btn-sm">Paid</button>
                                            @else
                                               <button disabled class="btn btn-danger btn-sm">Unpaid</button>
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
                        <div class="tab-pane" id="tab_2">
                        @if(count($students)>0)
                        <a href="{{url('manager/fees/pending/students/export')}}/{{$class}}/{{$section}}" class="btn btn-success btn-sm">Export</a>
                        @else
                        <a href="#" class="btn btn-success disabled btn-sm">Export</a>
                        @endif
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example2" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th>Registration No</th>
                                            <th>Student</th>
                                            <th>Father</th>
                                            <th>Fee Pending</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $count=1;
                                        @endphp
                                        @foreach($students as $list)
                                        <tr class="tr-shadow">
                                            <td>{{$list->sregistrationnumber}}</td>
                                            <td>{{$list->sname}} {{$list->slname}}</td>
                                            <td>{{$list->sfathername}}</td> 
                                             
            <input type="hidden" form="formc" name="studentid[]" value="{{$list->id}}">
            <td><input type="number" form="formc" name="amount[]" min="0" value="{{$list->spendingfees}}"></td>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
<script type="text/javascript">
    function getmoney(that){
        var val=that.value;
        var count=that.getAttribute("data-count");
        if(val>0){
            document.getElementById(count+"photos").setAttribute("required",true);         
        }
        else{
            document.getElementById(count+"photos").setAttribute("required",false);  
        }
    }
</script> 
@endsection