@extends('classteacher/layout')
@section('title','Completed Students')
@section('Dashboard_select','active')
@section('container')

<style type="text/css">
	th{
		font-size: 12px !important;
	}
	td{
		font-size: 10px !important;
        text-align: center;
	}
    span{
        font-size: 14px;
        color: red;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="container-fluid">
        
  
                    <div class="row">  
                        <div class="col-lg-12">
                          
                <h3 class="card-title col-12"><b>CLASS - UTILIZATION</b></h3>
                
            <form action="{{url('classteacher/fetch/class/data')}}" method="post" class="form-row mt-4">
                @csrf
                   <div class="form-row  col-12">
                   
                   <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                 <select class="form-control" required onchange="sec(this)" name="class" data-val="{{$section}}" id="clasy" disabled>
                          <option value="">Select Class</option>
                          @foreach($class as $list)
                           @if($cl==$list->id)
                             <option value="{{$list->id}}" selected>{{$list->categories}}</option>
                           @else
                            <option value="{{$list->id}}">{{$list->categories}}</option>
                           @endif
                          @endforeach
                      </select>
                  </div>
                   <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <select class="form-control" id="section" required name="section" disabled>
                         
                           @foreach($sec as $list)
                           @if($section==$list->id)
                             <option value="{{$list->id}}" selected>{{$list->section}}</option>
                           @else
                            <option value="{{$list->id}}">{{$list->section}}</option>
                           @endif
                          @endforeach
                      </select>
                  </div>
                  
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                     <a href="{{url('classteacher/faculty/list')}}/{{$mid}}/0" class="btn btn-success btn-sm form-control"  style="display:flex;align-items:center;justify-content:center;color: #fff;"><span style="color:#fff">My Schedule</span></a>
                  </div>
             
                 </div> 
                  </form>    


                      <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
      <thead style="background-color:#000;color:#fff">
         <tr>
            <th>Subject</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Periods Assigned</th>
            
            
         </tr>
      </thead>
      
        
       <tbody style="background-color:#fff">
           
           @foreach($data as $list)
             <tr>
             	
             	<td><b>{{$list->domain}}</b></td>
                <td>@php $count=0; @endphp
                    <b>@foreach($list->monname as $li) <a href="{{url('classteacher/faculty/list')}}/{{$list->mfid[$count]}}/Monday">{{$li}}</a> / 
                        @php
                        $count++;
                        @endphp 
                        @endforeach
                       

                    <span>{{$list->monday}}</span></b>
                    </td>

                <td>@php $count=0; @endphp
                    <b>@foreach($list->tuename as $li) <a href="{{url('classteacher/faculty/list')}}/{{$list->tfid[$count]}}/Tuesday">{{$li}}</a> /  
                        @php
                        $count++;
                        @endphp 
                        @endforeach  
                         
                        <span>{{$list->tuesday}}</span></b>
                    </td>

                 <td>@php $count=0; @endphp
                    <b>@foreach($list->wedname as $li) <a href="{{url('classteacher/faculty/list')}}/{{$list->wfid[$count]}}/Wednesday">{{$li}}</a> /  
                        @php
                        $count++;
                        @endphp 
                        @endforeach
                           
                        <span>{{$list->wednesday}}</span></b>
                    </td>

                <td>@php $count=0; @endphp
                    <b>@foreach($list->thuname as $li) <a href="{{url('classteacher/faculty/list')}}/{{$list->thfid[$count]}}/Thursday">{{$li}}</a> /  
                        @php
                        $count++;
                        @endphp 
                        @endforeach
                        
                    <span>{{$list->thursday}}</span></b>
                    </td>

                <td>@php $count=0; @endphp
                    <b>@foreach($list->friname as $li) <a href="{{url('classteacher/faculty/list')}}/{{$list->ffid[$count]}}/Friday">{{$li}}</a> /  
                        @php
                        $count++;
                        @endphp  
                        @endforeach
                        
                        <span>{{$list->friday}}</span></b>
                    </td>

                <td>@php $count=0; @endphp
                    <b>@foreach($list->satname as $li) <a href="{{url('classteacher/faculty/list')}}/{{$list->sfid[$count]}}/Saturday">{{$li}}</a> /  
                        @php
                        $count++;
                        @endphp 
                        @endforeach
                        
                        <span>{{$list->saturday}}</span></b>
                    </td>
                
                <td><b><span>{{(int)$list->monday+(int)$list->tuesday+(int)$list->wednesday+(int)$list->thursday+(int)$list->friday+(int)$list->saturday}}</span></b></td>
             </tr>
          @endforeach
           
            
           
           
      </tbody>
   </table>
                                </div>
                            </div>
                           
                        
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                 
                  <!-- /.tab-pane -->
                 
                  <!-- /.tab-pane -->
               



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