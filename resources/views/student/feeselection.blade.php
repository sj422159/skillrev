@extends('student/layout') 
@section('title','Fees Selection') 
@section('Dashboard_select','active extra') 
@section('container')
<style type="text/css">
    ::placeholder{
        background-color: blue;
    }

   th,td{
        font-size: 12px;
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
    @if(session()->has('danger'))
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
            <span class="badge badge-pill badge-danger"></span>
            {{session('danger')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Fees Selection</h3>
                </div>
                <form action="{{url('student/fees/selection/save')}}" method="post">
                @csrf
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="col-12">
                                <h6>All the below listed categories with <span style="color:red;">*</span> mark is manadatory you have to select before while proceeding to the next process.</h6>
                            </div>
                            <div class="table-responsive table" style="padding:20px">
                            
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Annualy</th>
                                            <th>Half-Yearly</th>
                                            <th>Quaterly</th>
                                            <th>Monthly</th>
                                            <th>Payment Type</th>
                                            <th>Discount</th>
                                            <th>Initial Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                @php
                  $totalannuallymoney=0;
                  $totalhalfyearlymoney=0;
                  $totalquaterlymoney=0;
                  $totalmonthlymoney=0;
                  $totalrevisedmoney=0;
                  $c=0;
                @endphp

                @foreach($commonfeeschedules as $list)
                <tr class="tr-shadow">
                @if($list->fcmandatoryornot=="1")
                <td>{{$list->fcategory}} <span style="color:red;">*</span></td>
                @elseif($list->fcmandatoryornot=="2" && $hostelservice=="Yes")
                <td>{{$list->fcategory}} <span style="color:red;">*</span></td>
                @elseif($list->fcmandatoryornot=="2" && $hostelservice=="No")
                <td>{{$list->fcategory}}</td>
                @endif
                <input type="hidden" name="feescheduleid[]" class="form-control" value="{{$list->id}}">
                <td>@if($list->shannual!=0)
                    Rs {{$list->shannual}}
                    @php
                    $totalannuallymoney=$totalannuallymoney+$list->shannual;  
                    @endphp 
                    @else
                    Not Available
                    @endif
                </td>
                <td>@if($list->shhalf!=0)
                    Rs {{$list->shhalf}}
                    @php
                    $totalhalfyearlymoney=$totalhalfyearlymoney+$list->shhalf;  
                    @endphp 
                    @else
                    Not Available
                    @endif
                </td>
                <td>@if($list->shquater!=0)
                    Rs {{$list->shquater}}
                    @php
                    $totalquaterlymoney=$totalquaterlymoney+$list->shquater;  
                    @endphp 
                    @else
                    Not Available
                    @endif
                </td>
                <td>@if($list->shmonthly!=0)
                    Rs {{$list->shmonthly}}
                    @php
                    $totalmonthlymoney=$totalmonthlymoney+$list->shmonthly;  
                    @endphp 
                    @else
                    Not Available
                    @endif
                </td>
                <td>
                @if($list->fcmandatoryornot=="1")
                    @if($selecty==1)
                     <select class="form-control" name="type[]" required onchange="getmoney(this)" data-getid="{{$list->shcategory}}" data-c="{{$c}}" data-rowid="{{$list->id}}" disabled>
                    @else
                     <select class="form-control" name="type[]" required onchange="getmoney(this)" data-getid="{{$list->shcategory}}" data-c="{{$c}}" data-rowid="{{$list->id}}" >
                    @endif  
                @elseif($list->fcmandatoryornot=="2" && $hostelservice=="Yes")
                    @if($selecty==1)
                     <select class="form-control" name="type[]" required onchange="getmoney(this)" data-getid="{{$list->shcategory}}" data-c="{{$c}}" data-rowid="{{$list->id}}" disabled>
                    @else
                     <select class="form-control" name="type[]" required onchange="getmoney(this)" data-getid="{{$list->shcategory}}" data-c="{{$c}}" data-rowid="{{$list->id}}" >
                    @endif
                @elseif($list->fcmandatoryornot=="2" && $hostelservice=="No")
                    @if($selecty==1)
                     <select class="form-control" name="type[]" onchange="getmoney(this)" data-getid="{{$list->shcategory}}" data-c="{{$c}}" data-rowid="{{$list->id}}" disabled>
                    @else
                     <select class="form-control" name="type[]" onchange="getmoney(this)" data-getid="{{$list->shcategory}}" data-c="{{$c}}" data-rowid="{{$list->id}}" >
                    @endif
                @endif
                    
                   
                        <option value="">Select</option>
                        @foreach($types as $li)
                        @if($list->seltype==$li['id'])
                        <option value="{{$li['id']}}" selected>{{$li['type']}}</option>
                        @else
                        <option value="{{$li['id']}}">{{$li['type']}}</option>
                        @endif
                        @endforeach
                    </select>
                </td>
                <td id="{{$c}}dis">{{$list->seldiscount}}</td>
                <td id="{{$c}}pric">{{$list->selfees}}</td> 
                @php
                    $totalrevisedmoney=$totalrevisedmoney+$list->selfees;  
                @endphp 
                </tr>
                <input type="hidden" name="discount[]" id="{{$c}}discount">
                <input type="hidden" name="val[]" id="{{$c}}val" value="0">
                @php
                  $c++;
                @endphp 
                @endforeach 


                @foreach($transportfeeschedules as $list)
                <tr class="tr-shadow">
                @if($list->fcmandatoryornot=="1")
                <td>{{$list->fcategory}} <span style="color:red;">*</span></td>
                @elseif($list->fcmandatoryornot=="2")
                <td>{{$list->fcategory}} <span style="color:red;">*</span></td>
                @endif
                <input type="hidden" name="feescheduleid[]" class="form-control" value="{{$list->id}}">
                <td>@if($list->shannual!=0)
                    Rs {{$list->shannual}}
                    @php
                    $totalannuallymoney=$totalannuallymoney+$list->shannual;  
                    @endphp 
                    @else
                    Not Available
                    @endif
                </td>
                <td>@if($list->shhalf!=0)
                    Rs {{$list->shhalf}}
                    @php
                    $totalhalfyearlymoney=$totalhalfyearlymoney+$list->shhalf;  
                    @endphp 
                    @else
                    Not Available
                    @endif
                </td>
                <td>@if($list->shquater!=0)
                    Rs {{$list->shquater}}
                    @php
                    $totalquaterlymoney=$totalquaterlymoney+$list->shquater;  
                    @endphp 
                    @else
                    Not Available
                    @endif
                </td>
                <td>@if($list->shmonthly!=0)
                    Rs {{$list->shmonthly}}
                    @php
                    $totalmonthlymoney=$totalmonthlymoney+$list->shmonthly;  
                    @endphp 
                    @else
                    Not Available
                    @endif
                </td>
                <td>
                @if($list->fcmandatoryornot=="1")
                    @if($selecty==1)
                     <select class="form-control" name="type[]" required onchange="getmoney(this)" data-getid="{{$list->shcategory}}" data-c="{{$c}}" data-rowid="{{$list->id}}" disabled>
                    @else
                     <select class="form-control" name="type[]" required onchange="getmoney(this)" data-getid="{{$list->shcategory}}" data-c="{{$c}}" data-rowid="{{$list->id}}" >
                    @endif  
                @elseif($list->fcmandatoryornot=="2")
                    @if($selecty==1)
                     <select class="form-control" name="type[]" required onchange="getmoney(this)" data-getid="{{$list->shcategory}}" data-c="{{$c}}" data-rowid="{{$list->id}}" disabled>
                    @else
                     <select class="form-control" name="type[]" required onchange="getmoney(this)" data-getid="{{$list->shcategory}}" data-c="{{$c}}" data-rowid="{{$list->id}}" >
                    @endif
                @endif
                   
                        <option value="">Select</option>
                        @foreach($types as $li)
                        @if($list->seltype==$li['id'])
                        <option value="{{$li['id']}}" selected>{{$li['type']}}</option>
                        @else
                        <option value="{{$li['id']}}">{{$li['type']}}</option>
                        @endif
                        @endforeach
                    </select>
                </td>
                <td id="{{$c}}dis">{{$list->seldiscount}}</td>
                <td id="{{$c}}pric">{{$list->selfees}}</td>
                @php
                    $totalrevisedmoney=$totalrevisedmoney+$list->selfees;  
                @endphp  
                </tr>
                <input type="hidden" name="discount[]" id="{{$c}}discount">
                <input type="hidden" name="val[]" id="{{$c}}val" value="0">
                @php
                  $c++;
                @endphp 
                @endforeach 
                <tr>
                    <th>Total</th>
                    <th>Rs {{$totalannuallymoney}}</th>
                    <th>Rs {{$totalhalfyearlymoney}}</th>
                    <th>Rs {{$totalquaterlymoney}}</th>
                    <th>Rs {{$totalmonthlymoney}}</th>
                    <th></th>
                    <th></th>
                    <th id="totalrevisedmoney">Rs {{$totalrevisedmoney}}</th>
                </tr>
                </tbody>

                            </table>
                            @if($selecty=="")
                            @if(count($commonfeeschedules)!=0 || count($transportfeeschedules)!=0) 
                            <button type="submit" class="btn btn-primary mt-2 btn-sm">Next</button>
                            @endif
                            @else
                            <input type="checkbox" onclick="return false;" onkeydown="return false;" checked required="true" class="mt-4"><b> This is an one time process for the complete academic year. Hence cannot be reversed.</b><br> 
                            <button type="button" class="btn btn-success mt-2 btn-sm">Saved</button>
                            @endif
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
    // $(document).ready(function() {
    //     $('#example1').DataTable({
    //         dom: 'Bfrtip',
    //         buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    //     });
    // });
</script>
<script>
  function yes(that) {
    if (that.value != " ") {
        document.getElementById('getjobroles').click();     
     } 
  }
</script>
<script type="text/javascript">
    var cs=<?php echo count($commonfeeschedules) ;?>;
    var ts=<?php echo count($transportfeeschedules);?>;
    var tot=parseInt(cs)+parseInt(ts);
    function getmoney(that){
        var val=that.value;
        var cat=that.getAttribute("data-getid");
        var row=that.getAttribute("data-rowid");
        var c=that.getAttribute("data-c");
        $.ajax({
            url:'{{url("student/fees/getmoney")}}',
            type:'GET',
            data:{val:val,cat:cat,row:row},
            dataType: "json",
            success:function(data)
            { 
            document.getElementById(c+"dis").innerHTML=data[0]+"%";
            document.getElementById(c+"discount").value=data[0]+"%";
            document.getElementById(c+"pric").innerHTML=data[1];
            document.getElementById(c+"val").value=data[1];
            var max=0;
            for(var k=0;k<tot;k++){
              max=max+parseInt(document.getElementById(k+"val").value);
            }
           
            document.getElementById("totalrevisedmoney").innerHTML="Rs " +max;
           
            }
          });
    }
</script>
@endsection