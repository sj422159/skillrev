@extends('nontechmanager/cafeteria/layout')
@section('title','Create Caterer')
@section('Dashboard_select','active')
@section('container')

<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
     

<div class="content">
<div class="col-12 col-lg-13 m-auto" style="margin-top: 30px !important;">
            <form class="multisteps-form__form" action="{{url('nontech/manager/food/createvendor/processing')}}" method="post">
              @csrf 
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">
                <h3 class="multisteps-form__title"><b>Enter Caterer Details</b></h3>
                <div class="multisteps-form__content">
                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-3">
                     <label for="GenderId" class="form-control-label"> First Name :</label>
                       <input type="text" id="username" name="fname" placeholder="First Name" value="{{$fname}}" class="multisteps-form__input form-control" required="true">
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label"> Last Name :</label>
                      <input type="text" id="username" name="lname" placeholder="Last Name" value="{{$lname}}" class="multisteps-form__input form-control" required="true">
                    </div>
                   <div class="col-12 col-sm-3">
                               <label>Cafeteria Type</label>
                               <select class="form-control" aria-required="true" aria-invalid="false" name="ctype" id="category" onchange="gethostel(this)" >
                                   <option value="">Select</option>
                                     @foreach($ctypes as $list)
                                     @if($ctype==$list->id)
                                      <option value="{{$list->id}}" selected>{{$list->ctype}}</option>
                                     @else
                                        <option value="{{$list->id}}" >{{$list->ctype}}</option>
                                     @endif
                                       
                                   @endforeach 
                                 </select>
                           </div>
                   <div class="col-12 col-sm-3" id="hosteldiv" style="display:none;">
                     <label>Hostels</label>
                         <select class="form-control" aria-required="true" aria-invalid="false" name="hostel" id="hostel">
                             <option value="">Select</option>
                             @foreach($hostels as $list)
                              @if($hostel==$list->id)
                                  <option value="{{$list->id}}" selected>{{$list->hostel}}</option>
                                  @else
                                  <option value="{{$list->id}}" >{{$list->hostel}}</option>
                                  @endif
                             @endforeach 
                         </select>
                     </div>
                  
                  </div>
                  


                  


                  </div>
                 
                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label"> Mobile Number :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Mobile No." name="mobile" id="PhoneId" value="{{$mobile}}">
                    </div>
                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label"> Email Address :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Email Address" required="true"  name="email" value="{{$email}}" id="EmailforId">
                    </div>
                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label"> Branch Office :</label>
                       <input type="text" class="multisteps-form__input form-control m-input" placeholder="Branch Office" id="PincodeId"  name="branchoffice" value="{{$branchoffice}}">
                    </div>
                  </div>
                  <div class="form-row mt-4">
                    
                    

                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label">Work Location :</label>
                       <input type="text" class="multisteps-form__input form-control m-input" placeholder="Worklocation" id="PincodeId"  name="worklocation" value="{{$worklocation}}">
                      
              </div>
                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label"> Aadhar Number :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Aadhaar Number" id="AnnualFamilyIncomeforId"  name="aadhar" data-val="true" value="{{$aadhar}}">
                    </div>

                    <div class="col-12 col-sm-4">
                      <label for="GenderId" class="form-control-label">Employment Status :</label>
                      <select class="multisteps-form__select form-control" name="employmentstatus" required="true">
                         <option value="">Select</option>
                         @foreach($employment_status as $list)
                         @if($employmentstatus==$list->id)
                         <option selected value="{{$list->id}}">{{$list->employment_type}}</option>
                         @else
                         <option value="{{$list->id}}">{{$list->employment_type}}</option>
                         @endif
                         @endforeach
                    </select>
                  </div>
                </div>

                  <input type="hidden" name="id" value="{{$id}}">
                  <div class="button-row d-flex mt-4">
                    <input type="submit" class="btn btn-success" value="Save"></input>
                    <a href="{{url('corporateadmin/users')}}"><button type="button" class="btn btn-danger" style="margin-left:10px !important;">Back</button></a>
                  </div>
                </div>
              </div>
              </form>
            </div> 

            <script>
              var cafetype=<?php echo $ctype; ?>;
              if(cafetype==2){
                document.getElementById('hosteldiv').style.display="block";
              }

              
              function gethostel(that){
                 if(that.value==2){
                  document.getElementById('hosteldiv').style.display="block";
                 }else{
                  document.getElementById('hosteldiv').style.display="none";
                 }
              }

            </script>
@endsection