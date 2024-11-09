@extends('student/layout')
@section('title','Content')
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
<form action="{{url('student/content/skillattribute/byskillset')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Standard</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="category" id="category">
                <option value="">Select</option>
                @foreach($category as $list)
                <option value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach 
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Subject</label>
            <select class="form-control" id="domain" aria-required="true"aria-invalid="false"name="domain">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Module</label>
            <select class="form-control" required="true" name="skillset" id="skillset" onchange="yesnoChecked(this)">
                <option selected="selected" value="">Select</option>
            </select>
        </div>
        
        <div class="col-md-6" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes" hidden="true">Get Skillset Related
            </button>
        </div>
    </div>
    <div class="form-row mt-4"></div>
</form>


<div class="row">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>Chapter</th>
                        <th>Content 1</th>
                        <th>Content 2</th>
                        <th>Content 3</th>
                        <th>Content 4</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $list)
                    <tr>
                        <td>{{$list->skillattribute}}</td>
                        <td>
                          @if($list->content1!="")
                            @if($list->type1=="1" || $list->type1=="2")
                            <a href="{{url('content/type1')}}/{{$list->content1}}" target="_blank" class="btn btn-primary btn-sm">View File</a>
                            @else
                            <a href="{{$list->content1}}" target="_blank" class="btn btn-primary btn-sm">Watch Video</a>
                            @endif
                          @else
                            <a href="#" class="btn btn-primary btn-sm disabled">Not Provided</a>
                          @endif
                        </td>
                        <td>
                          @if($list->content2!="")
                            @if($list->type2=="1" || $list->type2=="2")
                            <a href="{{url('content/type2')}}/{{$list->content2}}" target="_blank" class="btn btn-primary btn-sm">View File</a>
                            @else
                            <a href="{{$list->content2}}" target="_blank" class="btn btn-primary btn-sm">Watch Video</a>
                            @endif
                          @else
                            <a href="#" class="btn btn-primary btn-sm disabled">Not Provided</a>
                          @endif
                        </td>
                        <td>
                          @if($list->content3!="")
                            @if($list->type3=="1" || $list->type3=="2")
                            <a href="{{url('content/type3')}}/{{$list->content3}}" target="_blank" class="btn btn-primary btn-sm">View File</a>
                            @else
                            <a href="{{$list->content3}}" target="_blank" class="btn btn-primary btn-sm">Watch Video</a>
                            @endif
                          @else
                            <a href="#" class="btn btn-primary btn-sm disabled">Not Provided</a>
                          @endif
                        </td>
                        <td>
                          @if($list->content4!="")
                            @if($list->type4=="1" || $list->type4=="2")
                            <a href="{{url('content/type4')}}/{{$list->content4}}" target="_blank" class="btn btn-primary btn-sm">View File</a>
                            @else
                            <a href="{{$list->content4}}" target="_blank" class="btn btn-primary btn-sm">Watch Video</a>
                            @endif
                          @else
                            <a href="#" class="btn btn-primary btn-sm disabled">Not Provided</a>
                          @endif
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

           jQuery('#category').change(function (){
             let cid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("student/content/skillattribute/domain")}}',
              type:'get',
              data:'cid='+cid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#domain').html(result)
              }
             });
           });

            jQuery('#domain').change(function (){
            var sid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("student/content/skillattribute/skillset")}}',
              type:'get',
              data:'sid='+sid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#skillset').html(result)
              }
             });
           });



});


 

</script>
@endsection