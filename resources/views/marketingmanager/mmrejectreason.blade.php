@extends('marketingmanager/layout')
@section('title','Reject Reason')
@section('dashboard','active extra')
@section('container')
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
     

<div class="content">
<div class="col-12 col-lg-13 m-auto">
  <form class="multisteps-form__form" action="{{url('employee/marketingmanager/coldcall/rejectreason/save')}}" method="post">
              @csrf 
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
                    <div class="col-12 col-sm-6">
                     <label for="GenderId" class="form-control-label">Reason For Rejecting :</label><br>
                      <textarea class="form-control" rows="4" name="rejectreason" rows="10" required></textarea>
                    </div>
                  </div>
                  


                  <input type="hidden" name="id" value="{{$data[0]->id}}">


                  </div>
                 

                  
                  <div class="button-row d-flex mt-4">
                    <input type="submit" class="btn btn-success btn-sm" value="Save"></input>
                    <a href="{{url('employee/marketingmanager/coldcall/3')}}"><button type="button" class="btn btn-danger btn-sm" style="margin-left:10px !important;">Back</button></a>
                  </div>
                </div>
              </div>
              </form>
            </div> 


 @endsection                 