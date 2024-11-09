@extends('corporateadmin/layout')
@section('title','Reject Reason')
@section('ChildBranch_select','active extra')
@section('container')
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
     

<div class="content">
<form action="{{url('corporateadmin/marketingofficer/view/coldcalls/rejected/mosave')}}" method="post">
@csrf
<div class="col-12 col-lg-13 m-auto">
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">

                <div class="multisteps-form__content">

                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-3">
                        <label for="slug" class="control-label">Type :</label><br>
                        {{$data[0]->type}}   
                    </div>
                    <div class="col-12 col-sm-3">
                     <label for="GenderId" class="form-control-label">Name :</label><br>
                      {{$data[0]->name}} 
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Location :</label><br>
                      {{$data[0]->location}} 
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Address :</label><br>
                      {{$data[0]->address}} 
                    </div>
                  </div>

                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-3">
                     <label for="GenderId" class="form-control-label">POC :</label><br>
                      {{$data[0]->poc}} 
                    </div>
                    <div class="col-12 col-sm-3">
                     <label for="GenderId" class="form-control-label">Designation :</label><br>
                      {{$data[0]->designation}} 
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Email :</label><br>
                      {{$data[0]->email}} 
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Mobile :</label><br>
                      {{$data[0]->number}} 
                    </div>
                  </div>


                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-3">
                     <label for="GenderId" class="form-control-label">Reason For Rejecting :</label><br>
                      @if($data[0]->mmreject==0)
                      {{$data[0]->rejectreason}} 
                      @elseif($data[0]->mmreject==1)
                      {{$data[0]->mmrejectreason}}
                      @endif
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="GenderId" class="form-control-label">Marketing Manager :</label><br>
                        <select class="form-control" name="mm" id="edu" required="true">
                           <option value="">Select</option>
                           @foreach($mm as $list)
                             <option value="{{$list->id}}">{{$list->fname}} {{$list->lname}}</option>
                           @endforeach 
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="GenderId" class="form-control-label">Marketing Officer  :</label><br>
                        <select class="form-control" name="mo" id="spec" required="true">
                           <option value="">Select</option>
                        </select>
                    </div>
                  </div>
                  


                  <input type="hidden" name="id" value="{{$data[0]->id}}">


                  </div>
                 

                  
                  <div class="button-row d-flex mt-4">
                    <button type="submit" class="btn btn-primary btn-sm">Reassign</button>
                  </div>
                </div>
              </div>
              </form>
            </div> 




<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
  jQuery('#edu').change(function (){
    let id=jQuery(this).val();
      jQuery.ajax({
      url:'{{url("corporateadmin/getmarketingofficer")}}',
      type:'get',
      data:'id='+id+
      '&_token={{csrf_token()}}',
      success:function(result){
      jQuery('#spec').html(result)
      }
    });
  });
});
</script>

@endsection                 