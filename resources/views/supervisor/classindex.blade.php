@extends('supervisor/layout')
@section('title',' Class Utilization')
@section('d','active')
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
                          
                <h3 class="card-title"><b>CLASS - UTILIZATION</b></h3>
                
            <form action="{{url('groupmanager/fetch/class/data')}}" method="post" class="form-row mt-4">
                @csrf
                   <div class="form-row  col-12">
                   
                   <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                 <select class="form-control" required onchange="sec(this)" name="class" data-val="{{$section}}" id="clasy">
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
                   <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                      <select class="form-control" id="section" required name="section">
                          <option value="">Select Section</option>
                      </select>
                  </div>
                   <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                     <button type="submit" class="btn btn-primary btn-sm form-control" >Check</button>
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
            
             	
             	@if($list->stype==2)
                 <td style="background-color:#00000040;color:#fff">
                @else
                <td>
                @endif
                    <b> {{$list->domain}}</b>@if($list->stype==2)<br> <span style="font-size:8px;color:black;font-weight:bold;">OPTIONAL</span>     @endif
                </td>
                <td>@php $count=0; @endphp
                    <b>@foreach($list->monname as $li) <a href="{{url('groupmanager/faculty/list')}}/{{$list->stype}}/{{$list->mfid[$count]}}/Monday">{{$li}}</a> / 
                        @php
                        $count++;
                        @endphp 
                        @endforeach
                        @php $mc=0; @endphp
                    <b>@foreach($list->monmname as $li) <a href="{{url('groupmanager/manager/list')}}/{{$list->stype}}/{{$list->mmfid[$mc]}}/Monday">{{$li}}</a> / 
                        @php
                        $mc++;
                        @endphp 
                        @endforeach
                     @php $oc=0; @endphp
                     <b>@foreach($list->mononame as $li) <a href="{{url('groupmanager/own/list')}}/{{$list->stype}}/{{$list->mofid[$oc]}}/Monday" style="color:green;">{{$li}}</a> / 
                        @php
                        $oc++;
                        @endphp 
                        @endforeach

                    <span>{{$list->monday}}</span></b>
                    </td>

                <td>@php $count=0; @endphp
                    <b>@foreach($list->tuename as $li) <a href="{{url('groupmanager/faculty/list')}}/{{$list->stype}}/{{$list->tfid[$count]}}/Tuesday">{{$li}}</a> /  
                        @php
                        $count++;
                        @endphp 
                        @endforeach  
                          @php $mc=0; @endphp
                        <b>@foreach($list->tuemname as $li) <a href="{{url('groupmanager/manager/list')}}/{{$list->stype}}/{{$list->tmfid[$mc]}}/Tuesday">{{$li}}</a> / 
                        @php
                        $count++;
                        @endphp 
                        @endforeach
                         @php $oc=0; @endphp
                     <b>@foreach($list->tueoname as $li) <a href="{{url('groupmanager/own/list')}}/{{$list->stype}}/{{$list->tofid[$oc]}}/Tuesday" style="color:green;">{{$li}}</a> / 
                        @php
                        $oc++;
                        @endphp 
                        @endforeach  
                        <span>{{$list->tuesday}}</span></b>
                    </td>

                 <td>@php $count=0; @endphp
                    <b>@foreach($list->wedname as $li) <a href="{{url('groupmanager/faculty/list')}}/{{$list->stype}}/{{$list->wfid[$count]}}/Wednesday">{{$li}}</a> /  
                        @php
                        $count++;
                        @endphp 
                        @endforeach
                          @php $mc=0; @endphp 
                         <b>@foreach($list->wedmname as $li) <a href="{{url('groupmanager/manager/list')}}/{{$list->stype}}/{{$list->wmfid[$mc]}}/Wednesday">{{$li}}</a> / 
                        @php
                        $count++;
                        @endphp 
                        @endforeach
                         @php $oc=0; @endphp
                     <b>@foreach($list->wedoname as $li) <a href="{{url('groupmanager/own/list')}}/{{$list->stype}}/{{$list->wofid[$oc]}}/Wednesday" style="color:green;">{{$li}}</a> / 
                        @php
                        $oc++;
                        @endphp 
                        @endforeach     
                        <span>{{$list->wednesday}}</span></b>
                    </td>

                <td>@php $count=0; @endphp
                    <b>@foreach($list->thuname as $li) <a href="{{url('groupmanager/faculty/list')}}/{{$list->stype}}/{{$list->thfid[$count]}}/Thursday">{{$li}}</a> /  
                        @php
                        $count++;
                        @endphp 
                        @endforeach
                          @php $mc=0; @endphp
                         <b>@foreach($list->thumname as $li) <a href="{{url('groupmanager/manager/list')}}/{{$list->stype}}/{{$list->thmfid[$mc]}}/Thursday">{{$li}}</a> / 
                        @php
                        $count++;
                        @endphp 
                        @endforeach  
                         @php $oc=0; @endphp
                     <b>@foreach($list->thuoname as $li) <a href="{{url('groupmanager/own/list')}}/{{$list->stype}}/{{$list->thofid[$oc]}}/Thursday" style="color:green;">{{$li}}</a> / 
                        @php
                        $oc++;
                        @endphp 
                        @endforeach
                    <span>{{$list->thursday}}</span></b>
                    </td>

                <td>@php $count=0; @endphp
                    <b>@foreach($list->friname as $li) <a href="{{url('groupmanager/faculty/list')}}/{{$list->stype}}/{{$list->ffid[$count]}}/Friday">{{$li}}</a> /  
                        @php
                        $count++;
                        @endphp  
                        @endforeach
                         @php $mc=0; @endphp
                         <b>@foreach($list->frimname as $li) <a href="{{url('groupmanager/manager/list')}}/{{$list->stype}}/{{$list->fmfid[$mc]}}/Friday">{{$li}}</a> / 
                        @php
                        $count++;
                        @endphp 
                        @endforeach  
                         @php $oc=0; @endphp
                     <b>@foreach($list->frioname as $li) <a href="{{url('groupmanager/own/list')}}/{{$list->stype}}/{{$list->fofid[$oc]}}/Friday" style="color:green;">{{$li}}</a> / 
                        @php
                        $oc++;
                        @endphp 
                        @endforeach
                        <span>{{$list->friday}}</span></b>
                    </td>

                <td>@php $count=0; @endphp
                    <b>@foreach($list->satname as $li) <a href="{{url('groupmanager/faculty/list')}}/{{$list->stype}}/{{$list->sfid[$count]}}/Saturday">{{$li}}</a> /  
                        @php
                        $count++;
                        @endphp 
                        @endforeach
                         @php $mc=0; @endphp
                         <b>@foreach($list->satmname as $li) <a href="{{url('groupmanager/manager/list')}}/{{$list->stype}}/{{$list->smfid[$mc]}}/Saturday">{{$li}}</a> / 
                        @php
                        $count++;
                        @endphp 
                        @endforeach 
                         @php $oc=0; @endphp
                     <b>@foreach($list->satoname as $li) <a href="{{url('groupmanager/own/list')}}/{{$list->stype}}/{{$list->sofid[$oc]}}/Saturday" style="color:green;">{{$li}}</a> / 
                        @php
                        $oc++;
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
<script type="text/javascript">
     function sec(that){
          var classid = that.value;
          clas=that.value;
          var sectionid=$('#class').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("supervisor/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                   if(sectionid==section.id){
                       $('#section').prop('disabled', false).append('<option value="'+section.id+'" selected >'+section.section+'</option>');
                   }else{
                        $('#section').prop('disabled', false).append('<option value="'+section.id+'">'+section.section+'</option>');
                   }
                });
              }
          });
         }


           $(document).ready(function(){
            var classid = document.getElementById('clasy').value;
            var sectionid=$('#clasy').attr('data-val');
             $('#section').html('');
            $.ajax({
              url:'{{url("supervisor/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                   if(sectionid==section.id){
                       $('#section').prop('disabled', false).append('<option value="'+section.id+'" selected >'+section.section+'</option>');
                   }else{
                        $('#section').prop('disabled', false).append('<option value="'+section.id+'">'+section.section+'</option>');
                   }
                });
              }
          });

           });


</script>




@endsection