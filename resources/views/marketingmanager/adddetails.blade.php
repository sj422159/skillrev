@extends('marketingmanager/layout')
@section('title','Personal Details')
@section('dashboard_select','active')
@section('container')

<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
     

<div class="content">
<div class="col-12 col-lg-13 m-auto" style="margin-top: 50px !important;">
            <form class="multisteps-form__form" action="{{url('employee/marketingmanager/adddetails/processing')}}" method="post" enctype="multipart/form-data">
              @csrf 
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">
                <h3>Personal Details </h3>
                <h3 class="multisteps-form__title"></h3>
                <div class="multisteps-form__content">
                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-4">
                     <label for="GenderId" class="form-control-label"> First Name :</label>
                       <input type="text" id="username" name="fname" placeholder="First Name" value="{{$data[0]->fname}}" class="multisteps-form__input form-control" required="true">
                    </div>
                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label"> Last Name :</label>
                      <input type="text" id="username" name="lname" placeholder="Last Name" value="{{$data[0]->lname}}" class="multisteps-form__input form-control" required="true">
                    </div>
                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label"> Mobile Number :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Mobile No." name="mobile" id="PhoneId" value="{{$data[0]->mobile}}">
                    </div>
                    
                  </div>
                  


                  


                  </div>
                 
                  <div class="form-row mt-4">
                    
                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label"> Email Address :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Email Address" required="true"  name="email" value="{{$data[0]->email}}" id="EmailforId">
                    </div>
                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label"> Branch Office :</label>
                       <input type="text" class="multisteps-form__input form-control m-input" placeholder="Branch Office" id="PincodeId"  name="branchoffice" value="{{$data[0]->branchoffice}}">
                    </div>
                     <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label">Work Location :</label>
                       <input type="text" class="multisteps-form__input form-control m-input" placeholder="Worklocation" id="PincodeId"  name="worklocation" value="{{$data[0]->worklocation}}">
                      
              </div>
                  </div>
                  <div class="form-row mt-4">
                    
                    

                   
                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label"> Aadhar Number :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Aadhaar Number" id="AnnualFamilyIncomeforId"  name="aadhar" data-val="true" value="{{$data[0]->aadhar}}">
                    </div>

                     <div class="col-12 col-sm-4">
        <label for="image" class="control-label">Image</label>
        <input id="image" name="image" type="file" class="form-control">
        @if($data[0]->image!="")
         <img src="{{asset('internalimages')}}/{{$data[0]->image}}" width="130px" height="80px" alt="Image">
         @endif
        </div>
                  

                   
                </div>

                  <input type="hidden" name="id" value="{{$data[0]->id}}">
                  <div class="button-row d-flex mt-4">
                    <input type="submit" class="btn btn-success" value="Save"></input>
                   
                  </div>
                </div>
              </div>
              </form>
            </div> 
@endsection