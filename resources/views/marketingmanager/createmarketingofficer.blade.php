@extends('marketingmanager/layout')
@section('title','Marketing Officer')
@section('proctor','active extra')
@section('container')


<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
     


<div class="col-12 col-lg-13 m-auto" style="margin-top: 30px !important;">
            <form class="" action="{{url('employee/marketingmanager/marketingofficer/save')}}" method="post">
              @csrf 
              <!--single form panel-->
              <div class="" style="background-color:#fff;padding: 15px;">
                <h3 class="multisteps-form__title">Enter Marketing Officer Details</h3>
                <div class="multisteps-form__content">
                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-3">
                     <label for="GenderId" class="form-control-label"> First Name :</label>
                       <input type="text" id="username" name="mofname" placeholder="First Name" value="{{$mofname}}" class="multisteps-form__input form-control" required="true">
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label"> Last Name :</label>
                      <input type="text" id="username" name="molname" placeholder="Last Name" value="{{$molname}}" class="multisteps-form__input form-control" required="true">
                    </div>
                     <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label"> Email Address :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Email Address" required="true"  name="moemail" value="{{$moemail}}" id="EmailforId">
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label"> Mobile Number :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Mobile No." name="momobile" id="PhoneId" required="true" value="{{$momobile}}">
                    </div>
                  </div>
                 

                  


                  </div>
                 
                  <div class="form-row mt-4">
                    
                     <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label"> Aadhar Number :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Aadhaar Number" id="AnnualFamilyIncomeforId" required="true"  name="moaadhar" data-val="true" value="{{$moaadhar}}">
                    </div>

                                        <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label"> Branch Office :</label>
                       <input type="text" class="multisteps-form__input form-control m-input" placeholder="Branch Office" id="PincodeId" required="true"  name="mobranchoffice" value="{{$mobranchoffice}}">
                    </div>

                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Work Location :</label>
                       <input type="text" class="multisteps-form__input form-control m-input" placeholder="Worklocation" id="PincodeId" required="true" name="moworklocation" value="{{$moworklocation}}">
                      
              </div>
                   

                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Employment Status :</label>
                      <select class="multisteps-form__select form-control" name="moemploymentstatus" id="subrole" required="true">
                         <option value="">Select</option>
                         @foreach($employment_status as $list)
                         @if($moemploymentstatus==$list->employment_type)
                         <option selected value="{{$list->employment_type}}">{{$list->employment_type}}</option>
                         @else
                         <option value="{{$list->employment_type}}">{{$list->employment_type}}</option>
                         @endif
                         @endforeach
                    </select>
                  </div>
                   
               </div>
              
                    


                  <input type="hidden" name="id" value="{{$id}}">
                  <div class="button-row d-flex mt-4">
                    <input type="submit" class="btn btn-success" value="Save"></input>
                    <a href="{{url('employee/marketingmanager/marketingofficers')}}"><button type="button" class="btn btn-danger" style="margin-left:10px !important;">Back</button></a>
                  </div>
                </div>
              </div>
              </form>
            </div>
            

  

@endsection