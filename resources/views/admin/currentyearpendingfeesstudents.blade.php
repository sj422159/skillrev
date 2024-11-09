@extends('admin/layout') 
@section('title','Current Year Pending Fees Students') 
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
            <form action="{{url('admin/fees/pending/currentyear/students/bysection')}}" method="post">
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
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                        @if(count($students)>0)
                        <form action="{{url('admin/fees/pending/currentyear/students/export')}}" id="forma" method="post">
                        @csrf
                          <input type="hidden" form="forma" name="class" value="{{$class}}">
                          <input type="hidden" form="forma" name="section" value="{{$section}}">
                          <button type="submit" form="forma" class="btn btn-success btn-sm">Export</button>
                        </form>
                        @else
                        <a href="#" class="btn btn-success disabled btn-sm">Export</a>
                        @endif
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th>Rgd. No</th>
                                            <th>Student</th>
                                            <th>Father</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Month</th>
                                            <th>Total Fees</th>
                                            <th>Paid Fees</th>
                                            <th>Pending Fees</th>
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
                                            <td>{{$list->categories}}</td>
                                            <td>{{$list->section}}</td>
                                            <td>{{$month}}</td>
                                            <td>{{$list->feetotal}}</td>
                                            <td>{{$list->feetotalpaid}}</td>
                                                @php
                                                $pendingmoney=0;
                                                @endphp
                                                @if($month=='April')
                                                    @if($list->feeaprpay=="UNPAID")
                                                       @php  $pendingmoney=$pendingmoney+$list->feeaprmoney @endphp
                                                    @endif
                                                @elseif($month=='May')
                                                    @if($list->feeaprpay=="UNPAID") @php 
                                                        $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                @elseif($month=='June')
                                                    @if($list->feeaprpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejunpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejunmoney
                                                        @endphp
                                                    @endif
                                                @elseif($month=='July')
                                                    @if($list->feeaprpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejunpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejunmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejulpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejulmoney
                                                        @endphp
                                                    @endif
                                                @elseif($month=='August')
                                                    @if($list->feeaprpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejunpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejunmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejulpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejulmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeaugpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaugmoney
                                                        @endphp
                                                    @endif
                                                @elseif($month=='September')
                                                    @if($list->feeaprpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejunpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejunmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejulpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejulmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeaugpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaugmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeseppay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feesepmoney
                                                        @endphp
                                                    @endif
                                                @elseif($month=='October')
                                                    @if($list->feeaprpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejunpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejunmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejulpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejulmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeaugpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaugmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeseppay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feesepmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeoctpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeoctmoney
                                                        @endphp
                                                    @endif
                                                @elseif($month=='November')
                                                    @if($list->feeaprpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejunpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejunmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejulpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejulmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeaugpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaugmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeseppay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feesepmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeoctpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeoctmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feenovpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feenovmoney
                                                        @endphp
                                                    @endif
                                                @elseif($month=='Decemeber')
                                                    @if($list->feeaprpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejunpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejunmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejulpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejulmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeaugpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaugmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeseppay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feesepmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeoctpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeoctmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feenovpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feenovmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feedecpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feedecmoney
                                                        @endphp
                                                    @endif
                                                @elseif($month=='January')
                                                    @if($list->feeaprpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejunpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejunmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejulpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejulmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeaugpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaugmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeseppay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feesepmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeoctpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeoctmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feenovpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feenovmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feedecpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feedecmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejanpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejanmoney
                                                        @endphp
                                                    @endif
                                                @elseif($month=='February')
                                                    @if($list->feeaprpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejunpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejunmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejulpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejulmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeaugpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaugmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeseppay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feesepmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeoctpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeoctmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feenovpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feenovmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feedecpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feedecmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejanpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejanmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feefebpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feefebmoney
                                                        @endphp
                                                    @endif
                                                @elseif($month=='March')
                                                    @if($list->feeaprpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaprmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemaypay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemaymoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejunpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejunmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejulpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejulmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeaugpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeaugmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeseppay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feesepmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feeoctpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feeoctmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feenovpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feenovmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feedecpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feedecmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feejanpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feejanmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feefebpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feefebmoney
                                                        @endphp
                                                    @endif
                                                    @if($list->feemarpay=="UNPAID")
                                                         @php $pendingmoney=$pendingmoney+$list->feemarmoney
                                                        @endphp
                                                    @endif
                                                @endif

                                            <td>{{$pendingmoney}}</td>
                                            <input type="hidden" form="forma" name="feepaymentid[]" value="{{$list->id}}">
                                            <input type="hidden" form="forma" name="pendingmoney[]" value="{{$pendingmoney}}">
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