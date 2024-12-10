@extends('admin/layout')
@section('title','Chapter')
@section('Dashboard_select','active')
@section('container')

<form action="{{url('admin/skillattribute/byskillset')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
            <label>Group</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="group" id="group">
                <option value="">Select</option>
                @foreach($groups as $list)
                     @if($groupid==$list->id)
                    <option selected value="{{$list->id}}">{{$list->group}}</option>
                   @else
                    <option value="{{$list->id}}">{{$list->group}}</option>
                   @endif
                @endforeach  
            </select>
        </div>
        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
            <label>Standard</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="category" id="category" data-val="{{$categoryid}}">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
            <label>Subject</label>
            <select class="form-control" id="domain" aria-required="true"aria-invalid="false"name="domain" data-val="{{$domainid}}">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
            <label>Module</label>
            <select class="form-control" required="true" name="skillset" id="skillset" data-val="{{$skillsetid}}" onchange="yesnoChecked(this)">
                <option selected="selected" value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label></label><br>
           <a href="{{url('admin/skillattribute/addskillattribute')}}">
            <button type="button" class="btn btn-primary" style="margin-top:8px;">Create</button>  </a>
        </div>
        
        <div class="col-md-6" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes" hidden="true">Get Skillset Related
            </button>
        </div>
    </div>
</form>


<div class="row">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <br>
                    <tr>
                        <th>Chapter</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($skillattribute as $list)
                    <tr>
                        <td>{{$list->skillattribute}}</td>
                        <td>
                            <a href="{{url('admin/skillattribute/addskillattribute')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('admin/skillattribute')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
  function yesnoChecked(that) {
    if (that.value != "") {
        document.getElementById('getskillattributes').click();    
     } 
  }
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
jQuery(document).ready(function(){

          jQuery('#group').change(function (){
             let cid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("admin/questionbank/getcategory")}}',
              type:'get',
              data:'cid='+cid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#category').html(result)
              }
             });
           });  

           jQuery('#category').change(function (){
             let cid=jQuery(this).val();
             let groupid=document.getElementById("group").value;
             jQuery.ajax({
              url:'{{url("admin/getdomains")}}',
              type:'get',
              data:{cid:cid,groupid:groupid},
              success:function(result){
                jQuery('#domain').html(result)
              }
             });
           });

            jQuery('#domain').change(function (){
            var sid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("admin/questionbank/getskillset")}}',
              type:'post',
              data:'sid='+sid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#skillset').html(result)
              }
             });
           });

});



        $(document).ready(function(){
            var state = $('#group').val();
            var subbranch=$('#category').attr('data-val');
            $('#category').html('');
            $.ajax({
              url:'{{url("admin/skillset/getcategory/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {   
                $.each(data, function(key,jobskills)
                 {   
                   if(subbranch==jobskills.id){
                       $('#category').prop('disabled', false).append('<option value="'+jobskills.id+' " selected>'+jobskills.categories+'</option>');
                   }else{
                        $('#category').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.categories+'</option>');
                   }
                });
               skillset();
               skillattribute();
              }
          });
          });

        function skillset(){
            var state = $('#category').val();
            var childbranch=$('#domain').attr('data-val'); 
            var groupid = $('#group').val();      
            $('#domain').html('');
            $.ajax({
              url:'{{url("admin/skillset/domain/{id}/{groupid}")}}',
              type:'GET',
              data:{id:state,groupid:groupid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,jobroles)
                 {   
                   if(childbranch==jobroles.id){
                       $('#domain').prop('disabled', false).append('<option value="'+jobroles.id+'" selected >'+jobroles.domain+'</option>');
                   }else{
                        $('#domain').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.domain+'</option>');
                   }
                });
              }
          });
        };


        function skillattribute(){
            var state = $('#domain').attr('data-val');
            var skillset=$('#skillset').attr('data-val');      
            $('#skillset').html('');
            $.ajax({
              url:'{{url("admin/skillset/getskillset/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              {
                 $.each(data, function(key,jobroles)
                 {   
                   if(skillset==jobroles.id){
                       $('#skillset').prop('disabled', false).append('<option value="'+jobroles.id+'" selected >'+jobroles.skillset+'</option>');
                   }else{
                        $('#skillset').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillset+'</option>');
                   }
                });
              }
          });
          };
 

</script>
@endsection