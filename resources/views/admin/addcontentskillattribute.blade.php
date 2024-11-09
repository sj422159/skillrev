@extends('admin/layout')
@section('title','Add')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-9">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Content For Chapter</h3>
            </div>
            <form action="{{url('admin/content/skillattribute/saveskillattribute')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="jobskill">Standard</label>
                        <select id="mainbranch" name="category" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($categories as $list)
                            @if($category==$list->id)
                            <option selected value="{{$list->id}}">{{$list->categories}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->categories}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                            <label for="branchname">Subject</label>
                            <select name="domain" class="form-control" required="true" data-val="{{$domain}}" id="subbranch">
                            </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                            <label for="branchname">Module</label>
                            <select name="skillset" class="form-control" required="true" data-val="{{$skillset}}" id="subskillset">
                            </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                            <label for="branchname">Chapter</label>
                            <select name="skillattribute" class="form-control" required="true" data-val="{{$skillattribute}}" id="skillattribute">
                            </select>
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Content Type</label>
                        <select id="contenttype1" name="contenttype1" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($contenttypes1 as $list)
                            @if($type1==$list->id)
                            <option selected value="{{$list->id}}">{{$list->contenttype}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->contenttype}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="file1">
                        <label for="jobskill">Upload File</label>
                        <input type="file" class="form-control" name="file1" accept="application/*">
                    </div>
                    @if($id>0 && $type1=="1")
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">File</label><br>
                        <a href="{{url('content/type1')}}/{{$content1}}" target="_blank" class="btn btn-primary">View</a>
                    </div>
                    @else
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Action</label><br>
                        <a href="#" target="_blank" class="btn btn-primary disabled">View</a>
                    </div>
                    @endif
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Content Type</label>
                        <select id="contenttype2" name="contenttype2" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($contenttypes2 as $list)
                            @if($type2==$list->id)
                            <option selected value="{{$list->id}}">{{$list->contenttype}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->contenttype}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="file2">
                        <label for="jobskill">Upload File</label>
                        <input type="file" class="form-control" name="file2" accept="application/*">
                    </div>
                    @if($id>0 && $type2=="2")
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">File</label><br>
                        <a href="{{url('content/type2')}}/{{$content2}}" target="_blank" class="btn btn-primary">View</a>
                    </div>
                    @else
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Action</label><br>
                        <a href="#" target="_blank" class="btn btn-primary disabled">View</a>
                    </div>
                    @endif
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Content Type</label>
                        <select id="contenttype3" name="contenttype3" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($contenttypes3 as $list)
                            @if($type3==$list->id)
                            <option selected value="{{$list->id}}">{{$list->contenttype}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->contenttype}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="video3">
                        <label for="jobskill">Video Link</label>
                        <input type="url" required="true" value="{{$content3}}"class="form-control" name="video3"placeholder="Video Link" >
                    </div>
                    @if($id>0 && $type3=="3")
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Video</label><br>
                        <a href="{{$content3}}" target="_blank" class="btn btn-primary">View</a>
                    </div>
                    @else
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Action</label><br>
                        <a href="#" target="_blank" class="btn btn-primary disabled">View</a>
                    </div>
                    @endif
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Content Type</label>
                        <select id="contenttype4" required="true" name="contenttype4" type="text" class="form-control" aria-required="true" aria-invalid="false">
                            <option value="">Select</option>
                            @foreach($contenttypes4 as $list)
                            @if($type4==$list->id)
                            <option selected value="{{$list->id}}">{{$list->contenttype}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->contenttype}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="video4">
                        <label for="jobskill">Video Link</label>
                        <input type="url" required="true" value="{{$content4}}" class="form-control" name="video4"placeholder="Video Link">
                    </div>
                    @if($id>0 && $type4=="4")
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Video</label><br>
                        <a href="{{$content4}}" target="_blank" class="btn btn-primary">View</a>
                    </div>
                    @else
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Action</label><br>
                        <a href="#" target="_blank" class="btn btn-primary disabled">View</a>
                    </div>
                    @endif
                </div>
                <div class="form-row mt-4"></div>
                    <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{url('admin/content/skillattribute')}}" class="btn btn-danger">Back</a>
                </div>
        </div>
        </form>
    </div>
</div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    
        $(document).ready(function(){
            var state = $('#mainbranch').val();
            var subbranch=$('#subbranch').attr('data-val');

           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/skillattribute/domain/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,jobskills)
                 {   
                   if(subbranch==jobskills.id){
                       $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+' " selected>'+jobskills.domain+'</option>');
                   }else{
                        $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.domain+'</option>');
                   }
                });
               subskillset();
               skillattribute();
              }
          });
          });

         function subskillset(){
                   var state = $('#subbranch').val();
                   var subskillset=$('#subskillset').attr('data-val');
                  
           $('#subskillset').html('');
            $.ajax({
              url:'{{url("admin/skillattribute/skillset/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,jobroles)
                 {   
                   if(subskillset==jobroles.id){
                       $('#subskillset').prop('disabled', false).append('<option value="'+jobroles.id+'" selected >'+jobroles.skillset+'</option>');
                   }else{
                        $('#subskillset').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillset+'</option>');
                   }
                });
              }
          });
          };

        function skillattribute(){
            var state = $('#subskillset').attr('data-val');
            var subskillset=$('#skillattribute').attr('data-val');    
           $('#skillattribute').html('');
            $.ajax({
              url:'{{url("admin/skillattribute/getskillattribute/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,jobroles)
                 {   
                   if(subskillset==jobroles.id){
                       $('#skillattribute').prop('disabled', false).append('<option value="'+jobroles.id+'" selected >'+jobroles.skillattribute+'</option>');
                   }else{
                        $('#skillattribute').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillattribute+'</option>');
                   }
                });
              }
          });
          };
       $(document).ready(function(){
        $('#mainbranch').change(function(){

           var state = $('#mainbranch').val();
           var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/skillattribute/domain/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                 $('#subbranch').prop('disabled', false).append('<option value="">Select</option>'); 
                $.each(data, function(key,jobskills)
                 {     
                  $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.domain+'</option>');
                });
              }
          }); 
        });
      });
    $(document).ready(function(){
        $('#subbranch').change(function(){
           var state = $('#subbranch').val();
           $('#subskillset').html('');
            $.ajax({
             url:'{{url("admin/skillattribute/skillset/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              { 
                $('#subskillset').prop('disabled', false).append('<option value="">Select</option>'); 

                $.each(data, function(key,jobroles)
                 {    

                  $('#subskillset').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillset+'</option>');
                });
              }
          });
        });
    });

    $(document).ready(function(){
        $('#subskillset').change(function(){
           var state = $('#subskillset').val();
           $('#skillattribute').html('');
            $.ajax({
             url:'{{url("admin/skillattribute/getskillattribute/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              { 
                $('#skillattribute').prop('disabled', false).append('<option value="">Select</option>'); 

                $.each(data, function(key,jobroles)
                 {    

                  $('#skillattribute').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillattribute+'</option>');
                });
              }
          });
        });
      });
    </script>

@endsection