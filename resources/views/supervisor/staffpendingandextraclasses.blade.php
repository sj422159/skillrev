@extends('supervisor/layout')
@section('title','Pending and Extra Classes')
@section('reports','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="container-fluid">      

<div class="card-body" style="background-color:#e6e6e6;margin-top:15px;">
<div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                     <div class="row">
<div class="table-responsive table ">
                          
    <table id="example1" class="display nowrap" style="width:100%;border:1px solid #000;background-color: #fff;">
                <thead>
                        <tr>
            <th>Profile</th>
            <th>Name</th>
            <th>Mobile Number</th>
            <th>Pending Classes</th>
            <th>Extra Classes</th>
            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
            @foreach($supdata as $list)
             <tr>
               <td>GROUPMANAGER</td>
               <td>{{$list->supname}}</td>
               <td>{{$list->supnumber}}</td>   
               <td>{{$list->pcount}}</td>
               <td>{{$list->ecount}}</td>
               <td><a href="{{url('groupmanager/staff/pendingandextra/classes/view')}}/{{$list->pportalid}}/{{$list->pprofile}}" class="btn btn-primary btn-sm">View Classes</a></td>
             </tr>
            @endforeach

            @foreach($mandata as $list)
            <tr>
               <td>MANAGER</td>
               <td>{{$list->mname}}</td>
               <td>{{$list->mnumber}}</td>   
               <td>{{$list->pcount}}</td>
               <td>{{$list->ecount}}</td>
               <td><a href="{{url('groupmanager/staff/pendingandextra/classes/view')}}/{{$list->pportalid}}/{{$list->pprofile}}" class="btn btn-primary btn-sm">View Classes</a></td>
            </tr>
            @endforeach

            @foreach($facdata as $list)
            <tr>
               <td>FACULTY</td>
               <td>{{$list->fname}}</td>
               <td>{{$list->fnumber}}</td>   
               <td>{{$list->pcount}}</td>
               <td>{{$list->ecount}}</td>
               <td><a href="{{url('groupmanager/staff/pendingandextra/classes/view')}}/{{$list->pportalid}}/{{$list->pprofile}}" class="btn btn-primary btn-sm">View Classes</a></td>
            </tr>
            @endforeach
                                                     
                      </tbody>
                    </table>
                </div>
</div>
</div>

                  <div class="tab-pane" id="tab_2">
                     <div class="row">
<div class="table-responsive table ">
                          
    <table id="example2" class="display nowrap" style="width:100%;border:1px solid #000;background-color: #fff;">
                <thead>
                        <tr>
           <th>Profile Type</th>
            <th>Name</th>
            <th>Mobile Number</th>
            <th>Pending Classes</th>
            <th>Extra Classes</th>
                        </tr>
                      </thead>
                      <tbody>
                                       
                 
                      
                      </tbody>
                    </table>
                </div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"  defer></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
<script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
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
});

function sec(that){
    var classid = that.value;
          var sectionid=$('#class').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("groupmanager/rescheduling/classby/section/{id}")}}',
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

          var classid = $('#class').val();
          var sectionid=$('#class').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("groupmanager/rescheduling/classby/section/{id}")}}',
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

</script>

@endsection