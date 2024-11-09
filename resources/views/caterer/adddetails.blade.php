@extends('caterer/layout')
@section('title','Add Details')
@section('Dashboard_select','active')
@section('container')
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">


<div class="content">
<div class="col-12 col-lg-13 m-auto" style="margin-top: 30px !important;">
            <form class="multisteps-form__form" action="{{url('vendor/caterer/adddetails/processing')}}" method="post" enctype="multipart/form-data">
              @csrf 
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">
                <h3 class="multisteps-form__title">Your Details</h3>
                <div class="multisteps-form__content">

                <div class="form-row mt-4">

                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                     <label for="GenderId" class="form-control-label">Name :</label>
                       <input type="text" id="username" name="name" placeholder="Corporate Name" value="{{$name}}" class="multisteps-form__input form-control" required="true">
                    </div>

                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">Email Address :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Email Address" required="true"  name="email" value="{{$email}}" id="EmailforId" data-val="true" data-val-email="The EmailAddress field is not a valid e-mail address." data-val-length="The field EmailAddress must be a string with a maximum length of 256." data-val-length-max="256" data-val-required="Please enter email-id" maxlength="256">
                    </div>

                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">Mobile Number :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Mobile Number" name="number" id="PhoneId" value="{{$number}}" data-val-regex-pattern="^[6-9][0-9]{9}$" data-val-regex="Please enter a valid Mobile no" required="true" data-val-required="please enter phone number" data-val="true" data-val-length="The field PhoneNumber must be a string with a maximum length of 24." data-val-length-max="24" maxlength="24">
                    </div>

                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="image" class="form-control-label">Image :</label>
                      <input id="image" name="image" type="file" class="form-control">
                      @if($id>0)
                      <img src="{{asset('catererimages')}}/{{$image}}" width="130px" height="80px" alt="Gallery Image">
                      @endif
                    </div>
              </div>


                  <input type="hidden" name="id" value='{{$id}}'>
                  <div class="button-row d-flex mt-4">
                    <input type="submit" class="btn btn-success" value="Save"></input>
                    <a href="{{url('vendor/caterer/dashboard')}}"><button type="button" class="btn btn-danger" style="margin-left:10px !important;">Back</button></a>
                  </div>
                </div>
              </div>
              </form>
            </div> 


<script>
  $('#State').editableSelect({
    effects: 'slide'
  });

  $('#Sector').editableSelect({
    effects: 'slide'
  });

  $('#Jobrole').editableSelect({
    effects: 'slide'
  });
</script>                
 @endsection                 