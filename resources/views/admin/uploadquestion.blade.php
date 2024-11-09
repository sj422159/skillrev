@extends('admin/layout')
@section('title','Upload Question')
@section('Dashboard_select','active')
@section('container')
<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="form-row mt-4"> 
                <a href="{{url('studentdetails/samplequestiontemplate.xlsx')}}">
                <button type="button" class="btn btn-success">
                 Download Sample Excel Sheet
                </button> 
               </a>
               <br>
              
               
        <form action="{{url('admin/questions/upload')}}" enctype="multipart/form-data" method="post" class="col-12"> @csrf
               
            <div class="form-row mt-4">


                <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Standard</label>
            <select class="form-control" aria-required="true" required="true" aria-invalid="false" name="category" id="category">
                <option value="">Select</option>
                @foreach($category as $list)
                     <option value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach 
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Subject</label>
            <select class="form-control" id="domain" required="true" aria-required="true"aria-invalid="false"name="domain">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Module</label>
            <select class="form-control" required="true" name="skillset" id="skillset">
                <option selected="selected" value="">Select</option>
            </select>
        </div>



            <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Chapter</label>
            <select class="form-control" required="true" name="skillattribute" id="skillattribute">
                <option selected="">Select</option>
            </select>
        </div>

        </div>


               


                    <div class="input-group col-md-8" style="margin-top:20px !important;">
                      <div class="custom-file">
                        <input type="file" name='excel' id="file" required="true">
                      </div>
                <button type="submit" class="btn btn-success" id="submit">
                 Upload Question Bank
                </button>
                </div> 
        </form>
               
        </div>

              
               
              </div>
            </div>
          </div>
        </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

jQuery(document).ready(function(){

           jQuery('#category').change(function (){
             let cid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("admin/questionbank/getdomain")}}',
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
              url:'{{url("admin/questionbank/getskillset")}}',
              type:'post',
              data:'sid='+sid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#skillset').html(result)
              }
             });
           });



            jQuery('#skillset').change(function (){
            var gid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("admin/questionbank/getskillattribute")}}',
              type:'post',
              data:'gid='+gid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#skillattribute').html(result)
              }
             });
           });

});


 

</script>


@endsection
