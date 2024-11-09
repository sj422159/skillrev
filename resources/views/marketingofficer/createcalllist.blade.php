@extends('marketingofficer/layout')
@section('page_title','Call Form')
@section('dashboard','active extra')
@section('container')
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
     

<div class="content">
<div class="col-12 col-lg-13 m-auto">
  <form class="multisteps-form__form" action="{{url('employee/marketingofficer/coldcall/save')}}" method="post">
              @csrf 
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">

                <div class="multisteps-form__content">

                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-3">
                        <label for="slug" class="control-label">Type :</label>
                        <select class="form-control" name="type" required="true" id="category">
                          <option value="School">School</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                     <label for="GenderId" class="form-control-label">Name :</label>
                      <input type="text" id="username" name="name" placeholder="Name" class="multisteps-form__input form-control" required="true">
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Location :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Location" name="location" id="PhoneId" required="true">
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Address :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Address" name="address" id="EmailforId" required="true">
                    </div>
                  </div>

                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-3">
                     <label for="GenderId" class="form-control-label">POC :</label>
                      <input type="text" id="username" name="poc" placeholder="poc" class="multisteps-form__input form-control" required="true">
                    </div>
                    <div class="col-12 col-sm-3">
                     <label for="GenderId" class="form-control-label">Designation :</label>
                      <input type="text" id="username" name="designation" placeholder="designation" class="multisteps-form__input form-control" required="true">
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Email :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Email Address" name="email" id="EmailforId" required="true">
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Mobile :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Mobile No." name="number" id="PhoneId" required="true">
                    </div>
                  </div>
                  


                  


                  </div>
                 

                  
                  <div class="button-row d-flex mt-4">
                    <input type="submit" class="btn btn-success btn-sm" value="Save"></input>
                    <a href="{{url('employee/marketingofficer/coldcallinitial')}}"><button type="button" class="btn btn-danger btn-sm" style="margin-left:10px !important;">Back</button></a>
                  </div>
                </div>
              </div>
              </form>
            </div> 


 @endsection                 