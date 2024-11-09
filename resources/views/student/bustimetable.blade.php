@extends('student/layout')
@section('title','Bus Time Table')
@section('Dashboard_select','active')
@section('container')

<style type="text/css">
	th{
		font-size: 12px !important;
        text-transform: uppercase;
	}
	td{
		font-size: 16px !important;
        text-align: center;
	}
    span{
        font-size: 14px !important;
        color: red;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="container-fluid">
        
  
                    <div class="row">  
                        <div class="col-lg-12">
                          
                <h3 class="card-title"><b> &nbsp &nbsp BUS TIME TABLE</b></h3>
                
           
                   <div class="row col-12">


                      <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
        <thead style="background-color:#000;color:#fff">
         <tr>
            <th style="text-align:center;">Location</th>
            <th style="text-align:center;">Pickup Time</th>
            <th style="text-align:center;">Drop Time</th>
         </tr>
        </thead>  
        <tbody style="background-color:#fff">
        @if(count($distance)>0)
        <tr>
            <td>{{$distance[0]->location}}</td> 
            <td><span class="right badge badge-primary">{{$distance[0]->pickuptime}}</span></td> 
            <td><span class="right badge badge-success">{{$distance[0]->droptime}}</span></td>      
        </tr>
        @else
        <tr>
            <td colspan="3">You have not opted for Transport</td>    
        </tr>
        @endif      
      </tbody>
    </table>
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
@endsection