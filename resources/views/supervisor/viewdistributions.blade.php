@extends('supervisor/layout')
@section('title','Distributions')
@section('reports','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<style type="">
    
select,option,label,button{
    font-size: 12px !important;
}
th{
  font-size: 14px !important;
}
td{
  font-size: 12px !important;
}
</style>

<div class="col-12" style="margin:10px;background-color: #fff;padding:5px;margin-top:0px;padding-top: 10px;">
  
<form action="{{url('supervisor/distribution/reports/feecategorywise')}}" method="post">
    @csrf
    <div class="form-row">
          <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>CLASS</label>
            <select  class="form-control" name="classid" id="class" data-val="{{$sec}}" required onchange="sec(this)">
                <option value="">Select</option>
                @foreach($class as $list)
                @if($cl==$list->id)
                <option selected value="{{$list->id}}">{{$list->categories}}</option>
                @else
                <option value="{{$list->id}}">{{$list->categories}}</option>
                 @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>SECTION</label>
            <select  class="form-control" name="section" id="section" required >
                <option value="">Select</option>  
            </select>
        </div>

       <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>FEE CATEGORY</label>
            <select  class="form-control" name="feecategory" required >
                <option value="">Select</option>
                @foreach($feecategories as $list)
                @if($feecategory==$list->id)
                <option selected value="{{$list->id}}">{{$list->fcategory}}</option>
                @else
                <option value="{{$list->id}}">{{$list->fcategory}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <input type="hidden" name="class" value="{{$cl}}">

       

        
        
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
             <label>Action</label>
            <button type="submit" class="btn btn-success form-control">Fetch Report</button>
          </div>
        </div>
</form>          
</div>

<div class="card-body" style="background-color:#e6e6e6;margin-top:15px;">
<div class="table-responsive table ">
                          
    <table id="example1" class="display nowrap" style="width:100%;border:1px solid #000;background-color: #fff;">
                <thead>
                        <tr>
                            <th>Registration No</th>
                            <th>Student</th>
                            <th>Type</th>
                            <th>Remarks</th>
                        </tr>
                      </thead>
                      <tbody>
                      	@foreach($data as $list)
                        <tr class="tr-shadow">
                        <td>{{$list->sregistrationnumber}}</td>
                        <td>{{$list->sname}} {{$list->slname}}</td>
                        <td>
                            @if($list->type=="Yes")
                            <span class="right badge badge-success">{{$list->type}}</span>
                            @elseif($list->type=="No")
                            <span class="right badge badge-danger">{{$list->type}}</span>
                            @else
                            <span class="right badge badge-primary">{{$list->type}}</span>
                            @endif
                        </td>
                        <td>{{$list->remark}}</td>
                        </tr>
                        @endforeach 
                      </tbody>
                    </table>
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
} );
</script>
<script type="text/javascript">

  function sec(that){
          var classid = that.value;
          var sectionid=$('#class').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("supervisor/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid},
              dataType: "json",
              success:function(data)
              {
                 $('#section').prop('disabled', false).append('<option value="">Select</option>');
                
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
              url:'{{url("supervisor/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid},
              dataType: "json",
              success:function(data)
              {
                 $('#section').prop('disabled', false).append('<option value="">Select</option>');
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