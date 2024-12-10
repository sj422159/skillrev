@extends('admin/layout')
@section('title','Subject')
@section('Dashboard_select','active')
@section('container')



<form action="{{url('admin/domain/bycategory')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
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
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Standard</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="category" id="category" data-val="{{$categoryid}}" onchange="yesnoChecked(this)">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label></label><br>
           <a href="{{url('admin/domain/adddomain')}}">
             <button type="button" class="btn btn-primary" style="margin-top:8px;">Create</button>  </a>
        </div>
        <div class="col-md-6" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes" hidden="true">Category Related Domain
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
                        <th>Subject</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($domain as $list)
                    <tr>
                        <td>{{$list->domain}}</td>
                        <td>
                            <a href="{{url('admin/domain/adddomain')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('admin/domain')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function yesnoChecked(that) {
    if (that.value != "") {
        document.getElementById('getskillattributes').click();    
     } 
  }
</script>
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
});

$(document).ready(function(){
    var group = $('#group').val();
    var category =$('#category').attr('data-val');
        $('#category').html('');
            $.ajax({
              url:'{{url("admin/skillset/getcategory/{id}")}}',
              type:'GET',
              data:{myID:group},
              dataType: "json",
              success:function(data){ 
                $.each(data, function(key,jobskills){   
                    if(category==jobskills.id){
                       $('#category').prop('disabled', false).append('<option value="'+jobskills.id+' " selected>'+jobskills.categories+'</option>');
                    }else{
                        $('#category').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.categories+'</option>');
                    }
                });
              }
    });
});
</script>
@endsection