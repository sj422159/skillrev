@extends('student/layout') 
@section('title','Fees Payment View') 
@section('Dashboard_select','active extra') 
@section('container')
<style type="text/css">
    ::placeholder{
        background-color: blue;
    }
    th,td{
        font-size: 12px;
        width: 60px !important;
    }
    span{
        color: red;
        font-size: 13px;
        font-weight: bold;
    }
</style>
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
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Fees Structure</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive table" style="padding:20px">
                            
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr style="background-color:#000;color:#fff">
                                            <th>Installment</th>
                                            <th>Apr</th>
                                            <th>May</th>
                                            <th>Jun</th>
                                            <th>July</th>
                                            <th>Aug</th>
                                            <th>Sep</th>
                                            <th>Oct</th>
                                            <th>Nov</th>
                                            <th>Dec</th>
                                            <th>Jan</th>
                                            <th>Feb</th>
                                            <th>Mar</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                @php
                $apr=0;
                $may=0;
                $jun=0;
                $jul=0;
                $aug=0;
                $sep=0;
                $oct=0;
                $nov=0;
                $dec=0;
                $jan=0;
                $feb=0;
                $mar=0;
                $total=0;
                @endphp
                @foreach($data as $list)
                @if($list->feepaymenttype=="shannual")
                <tr class="tr-shadow">
                <td>{{$list->fcategory}}</td>
                <td><span>₹</span>{{$list->feeannual}}.00  
                @php
                $apr=$apr+$list->feeannual;
                @endphp
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><span>₹</span>{{$list->feeannual}}.00
                @php
                $total=$total+$list->feeannual;
                @endphp
                </td>
                </tr>
                @endif
                @if($list->feepaymenttype=="shhalf")
                <tr class="tr-shadow">
                <td>{{$list->fcategory}}</td>
                <td><span>₹</span>{{$list->feehalf}}.00
                @php
                $apr=$apr+$list->feehalf;
                @endphp
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><span>₹</span>{{$list->feehalf}}.00
                @php
                $oct=$oct+$list->feehalf;
                @endphp
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><span>₹</span>{{$list->feehalf+$list->feehalf}}.00
                @php
                $total=$total+$list->feehalf+$list->feehalf;
                @endphp
                </td>
                </tr>
                @endif
                @if($list->feepaymenttype=="shquater")
                <tr class="tr-shadow">
                <td>{{$list->fcategory}}</td>
                <td><span>₹</span>{{$list->feequater}}.00
                @php
                $apr=$apr+$list->feequater;
                @endphp
                </td>
                <td></td>
                <td></td>
                <td><span>₹</span>{{$list->feequater}}.00
                @php
                $jul=$jul+$list->feequater;
                @endphp
                </td>
                <td></td>
                <td></td>
                <td><span>₹</span>{{$list->feequater}}.00
                @php
                $oct=$oct+$list->feequater;
                @endphp
                </td>
                <td></td>
                <td></td>
                <td><span>₹</span>{{$list->feequater}}.00
                @php
                $jan=$jan+$list->feequater;
                @endphp
                </td>
                <td></td>
                <td></td>
                <td><span>₹</span>{{$list->feequater+$list->feequater+$list->feequater+$list->feequater}}.00
                @php
                $total=$total+$list->feequater+$list->feequater+$list->feequater+$list->feequater;
                @endphp
                </td>
                </tr>
                @endif
                @if($list->feepaymenttype=="shmonthly")
                <tr class="tr-shadow">
                <td>{{$list->fcategory}}</td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $apr=$apr+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $may=$may+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $jun=$jun+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $jul=$jul+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $aug=$aug+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $sep=$sep+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $oct=$oct+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $nov=$nov+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $dec=$dec+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $jan=$jan+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $feb=$feb+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly}}.00
                @php
                $mar=$mar+$list->feemonthly;
                @endphp
                </td>
                <td><span>₹</span>{{$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly}}.00
                @php
                $total=$total+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly+$list->feemonthly;
                @endphp
                </td>
                </tr>
                @endif
                @endforeach

                <tr>
                <th style="color:red">Total</th> 
                <th><span>₹</span>{{$apr}}.00</th>
                <th><span>₹</span>{{$may}}.00</th>
                <th><span>₹</span>{{$jun}}.00</th>
                <th><span>₹</span>{{$jul}}.00</th>
                <th><span>₹</span>{{$aug}}.00</th>
                <th><span>₹</span>{{$sep}}.00</th>
                <th><span>₹</span>{{$oct}}.00</th>
                <th><span>₹</span>{{$nov}}.00</th>
                <th><span>₹</span>{{$dec}}.00</th>
                <th><span>₹</span>{{$jan}}.00</th>
                <th><span>₹</span>{{$feb}}.00</th>
                <th><span>₹</span>{{$mar}}.00</th>
                <th><span>₹</span>{{$total}}.00</th>
                </tr> 

                        </tbody>
                        </table>
                        <form action="{{url('student/fees/selection/permanant/save')}}" method="post">
                        @csrf
                        <input type="hidden" name="feeaprmoney" value="{{$apr}}">
                        <input type="hidden" name="feemaymoney" value="{{$may}}">
                        <input type="hidden" name="feejunmoney" value="{{$jun}}">
                        <input type="hidden" name="feejulmoney" value="{{$jul}}">
                        <input type="hidden" name="feeaugmoney" value="{{$aug}}">
                        <input type="hidden" name="feesepmoney" value="{{$sep}}">
                        <input type="hidden" name="feeoctmoney" value="{{$oct}}">
                        <input type="hidden" name="feenovmoney" value="{{$nov}}">
                        <input type="hidden" name="feedecmoney" value="{{$dec}}">
                        <input type="hidden" name="feejanmoney" value="{{$jan}}">
                        <input type="hidden" name="feefebmoney" value="{{$feb}}">
                        <input type="hidden" name="feemarmoney" value="{{$mar}}">

                        <input type="checkbox" required="true" class="mt-4"> <b>This is an one time process for the complete academic year. Hence cannot be reversed.</b><br> 
                            <button type="submit" class="btn btn-primary mt-2 btn-sm">Save</button>
                            <a href="{{url('student/fees/selection')}}" class="btn btn-danger btn-sm mt-2">Back</a>
                        </form>
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
@endsection