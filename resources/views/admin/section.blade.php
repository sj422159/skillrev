@extends('admin/layout')
@section('title','Section')
@section('Dashboard_select','active')
@section('container')

@if(session()->has('success'))
<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
    <span class="badge badge-pill badge-success"></span>
    {{session('success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
@endif
@if(session()->has('errors'))
<div class="sufee-alert alert with-close alert-error alert-dismissible fade show">
    <span class="badge badge-pill badge-error"></span>
    {{session('errors')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
@endif

<form action="{{url('admin/section/byclass')}}" method="post">
@csrf 
<div class="form-row">
    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Group</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="groupid" id="category">
                <option value="">Select</option>
                @foreach($groups as $list)
                     <option value="{{$list->id}}">{{$list->group}}</option>
                @endforeach 
            </select>
    </div>
    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Class</label>
            <select class="form-control" id="domain" aria-required="true"aria-invalid="false"name="classid" onchange="yesnoChecked(this)">
                <option value="">Select</option>
            </select>
    </div>
    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label></label><br>
           <a href="{{url('admin/section/addsection')}}">
             <button type="button" class="btn btn-primary" style="margin-top:8px;">Create</button>  </a>
    </div>
    <div class="col-md-6" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes" hidden="true">Category Related Domain
            </button>
    </div>
</div>   
</form>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="state">
                    @foreach($section as $list)
                    <tr>
                        <td>{{$list->group}}</td>
                        <td>{{$list->categories}}</td>
                        <td>{{$list->section}}</td>
                        <td>
                            <a href="{{url('admin/section/addsection')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
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

           jQuery('#category').change(function (){
             let cid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("admin/section/group/getclass")}}',
              type:'get',
              data:'cid='+cid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#domain').html(result)
              }
             });
           });
});
</script>
@endsection