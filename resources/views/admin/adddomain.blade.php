@extends('admin/layout')
@section('title','Add Subject')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/domain/savedomain')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                    <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                        <label for="jobskill">Group</label>
                        <select id="mainbranch" name="groupid" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
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
                    <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                            <label for="branchname">Standard</label>
                            <select name="category" class="form-control" required="true" data-val="{{$category}}" id="subbranch">
                            </select>
                    </div>
                    <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                        <label for="jobskill">Subject Type</label>
                        <select id="mainbranch" name="stype" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($subtypes as $list)
                            @if($subtype==$list)
                            <option selected value="{{$list}}">{{$list}}</option>
                            @else
                            <option value="{{$list}}">{{$list}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                 <div class="form-row mt-4">
                    <div class="col-12 col-sm-3 mt-2 mt-sm-0">
                        <label for="jobrole">Subject</label>
                        <input type="text" class="form-control" id="jobrole" placeholder="Enter Subject" name="domain" value="{{$domain}}" required="true">
                    </div>
                     <div class="col-12 col-sm-3 mt-2 mt-sm-0">
                        <label for="jobrole">Visible Name</label>
                        <input type="text" class="form-control" id="jobrole" placeholder="Name For Students" name="dname" value="{{$dname}}" required="true">
                    </div>


                </div>
                  
                   <div class="form-row">
                  <div class="form-check mt-3">
                    @if($show=="1")
                      <input type="checkbox" checked class="form-check-input" id="check1" name="show" style="margin-top:8px;margin-left:0px;">
                    @else
                       <input type="checkbox" class="form-check-input" id="check1" name="show" style="margin-top:8px;margin-left:0px;">
                    @endif
                   
                    <label class="form-check-label" for="show" style="margin-left:30px;text-transform:uppercase;"><b>Check If You Want it visible For Students ?</b></label>
                </div>
            </div>
                     
                       
                       
                
            </div>
                <input type="hidden" name="id" value="{{$id}}">
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
              url:'{{url("admin/skillset/getcategory/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,jobskills)
                 {   
                   if(subbranch==jobskills.id){
                       $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+' " selected>'+jobskills.categories+'</option>');
                   }else{
                        $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.categories+'</option>');
                   }
                });
              
              }
          });
          });

         
        $(document).ready(function(){
        $('#mainbranch').change(function(){
           var state = $('#mainbranch').val();
           var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/skillset/getcategory/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                $('#subbranch').prop('disabled', false).append('<option value="">Select</option>'); 
                $.each(data, function(key,jobskills)
                 {     
                  $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.categories+'</option>');
                });
              }
          }); 
        });
      });
       
    </script>
@endsection