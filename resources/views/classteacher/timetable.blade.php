@extends('classteacher/layout')
@section('title','Time Table')
@section('reports','active')
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
                          
                <h3 class="card-title"><b> &nbsp &nbsp TIME - TABLE</b></h3>
                
           
                   <div class="row col-12">
                   
                   <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                 <select class="form-control disabled" required name="class" data-val="{{$section}}" id="clasy" disabled>
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
                          <option value="">Select Section</option>
                           @foreach($sec as $list)
                           @if($section==$list->id)
                             <option value="{{$list->id}}" selected>SEC {{$list->section}}</option>
                           @endif
                          @endforeach
                      </select>
                  </div>
                  <div class="col-12 col-sm-1 mt-4 mt-sm-0"></div>
                  <div class="col-12 col-sm-5 mt-2" style="font-size:18px">
                      <b>{{$day}} ,  {{$date}}</b>
                  </div>
                    


                      <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
      <thead style="background-color:#000;color:#fff">
         <tr>
            <th>Day</th>
            <th>1st Period</th>
            <th>2nd Period</th>
            <th>3rd Period</th>
            <th>4th Period</th>
            <th>5th Period</th>
            <th>6th Period</th>
            <th>7th Period</th>
            <th>8th Period</th>
         </tr>
      </thead>
      
        
       <tbody style="background-color:#fff">
        <tr>
            <td>Monday</td> 
            @if(count($monday1)>0)
             <td><span class="right badge badge-success">{{$monday1[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($monday2)>0)
             <td><span class="right badge badge-success">{{$monday2[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($monday3)>0)
             <td><span class="right badge badge-success">{{$monday3[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($monday4)>0)
             <td><span class="right badge badge-success">{{$monday4[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($monday5)>0)
             <td><span class="right badge badge-success">{{$monday5[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($monday6)>0)
             <td><span class="right badge badge-success">{{$monday6[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($monday7)>0)
             <td><span class="right badge badge-success">{{$monday7[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif  
            @if(count($monday8)>0)
             <td><span class="right badge badge-success">{{$monday8[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif        
        </tr>
        <tr>
            <td>Tuesday</td> 
            @if(count($tuesday1)>0)
             <td><span class="right badge badge-success">{{$tuesday1[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($tuesday2)>0)
             <td><span class="right badge badge-success">{{$tuesday2[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($tuesday3)>0)
             <td><span class="right badge badge-success">{{$tuesday3[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($tuesday4)>0)
             <td><span class="right badge badge-success">{{$tuesday4[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($tuesday5)>0)
             <td><span class="right badge badge-success">{{$tuesday5[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($tuesday6)>0)
             <td><span class="right badge badge-success">{{$tuesday6[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($tuesday7)>0)
             <td><span class="right badge badge-success">{{$tuesday7[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif  
            @if(count($tuesday8)>0)
             <td><span class="right badge badge-success">{{$tuesday8[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif        
        </tr>
        <tr>
            <td>Wednesday</td> 
            @if(count($wednesday1)>0)
             <td><span class="right badge badge-success">{{$wednesday1[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($wednesday2)>0)
             <td><span class="right badge badge-success">{{$wednesday2[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($wednesday3)>0)
             <td><span class="right badge badge-success">{{$wednesday3[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($wednesday4)>0)
             <td><span class="right badge badge-success">{{$wednesday4[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($wednesday5)>0)
             <td><span class="right badge badge-success">{{$wednesday5[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($wednesday6)>0)
             <td><span class="right badge badge-success">{{$wednesday6[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($wednesday7)>0)
             <td><span class="right badge badge-success">{{$wednesday7[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif  
            @if(count($wednesday8)>0)
             <td><span class="right badge badge-success">{{$wednesday8[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif        
        </tr>
        <tr>
            <td>Thursday</td> 
            @if(count($thursday1)>0)
             <td><span class="right badge badge-success">{{$thursday1[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($thursday2)>0)
             <td><span class="right badge badge-success">{{$thursday2[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($thursday3)>0)
             <td><span class="right badge badge-success">{{$thursday3[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($thursday4)>0)
             <td><span class="right badge badge-success">{{$thursday4[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($thursday5)>0)
             <td><span class="right badge badge-success">{{$thursday5[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($thursday6)>0)
             <td><span class="right badge badge-success">{{$thursday6[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($thursday7)>0)
             <td><span class="right badge badge-success">{{$thursday7[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif  
            @if(count($thursday8)>0)
             <td><span class="right badge badge-success">{{$thursday8[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif        
        </tr>
        <tr>
            <td>Friday</td> 
            @if(count($friday1)>0)
             <td><span class="right badge badge-success">{{$friday1[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($friday2)>0)
             <td><span class="right badge badge-success">{{$friday2[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($friday3)>0)
             <td><span class="right badge badge-success">{{$friday3[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($friday4)>0)
             <td><span class="right badge badge-success">{{$friday4[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($friday5)>0)
             <td><span class="right badge badge-success">{{$friday5[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($friday6)>0)
             <td><span class="right badge badge-success">{{$friday6[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($friday7)>0)
             <td><span class="right badge badge-success">{{$friday7[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif  
            @if(count($friday8)>0)
             <td><span class="right badge badge-success">{{$friday8[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif        
        </tr>
        <tr>
            <td>Saturday</td> 
            @if(count($saturday1)>0)
             <td><span class="right badge badge-success">{{$saturday1[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($saturday2)>0)
             <td><span class="right badge badge-success">{{$saturday2[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($saturday3)>0)
             <td><span class="right badge badge-success">{{$saturday3[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($saturday4)>0)
             <td><span class="right badge badge-success">{{$saturday4[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($saturday5)>0)
             <td><span class="right badge badge-success">{{$saturday5[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($saturday6)>0)
             <td><span class="right badge badge-success">{{$saturday6[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif 
            @if(count($saturday7)>0)
             <td><span class="right badge badge-success">{{$saturday7[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif  
            @if(count($saturday8)>0)
             <td><span class="right badge badge-success">{{$saturday8[0]->dname}}</span></td>
            @else
             <td><span class="right badge badge-secondary">NA</span></td>
            @endif        
        </tr>
              
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


        


</script>




@endsection