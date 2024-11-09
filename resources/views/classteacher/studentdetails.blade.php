@extends('classteacher/layout')
@section('title','Student Details')
@section('Dashboard_select','active')
@section('container')
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>


<div class="content">
<div class="col-12 col-lg-13 m-auto">
   
        <!--single form panel-->
        <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">
            <h3 class="multisteps-form__title">Student Details</h3>
            <div class="multisteps-form__content">

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="slug" class="control-label">First Name :</label>
                        <input type="text" readonly class="ui-autocomplete-input form-control"name="firstname" value="{{$profile[0]->sname}}"> 
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="slug" class="control-label">Last Name :</label>
                        <input type="text" readonly class="ui-autocomplete-input form-control"name="firstname" value="{{$profile[0]->slname}}"> 
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="YearOfJoining">Number :</label>
                        <input type="text" readonly class="ui-autocomplete-input form-control" id="passyear" required="true"name="mobile" value="{{$profile[0]->snumber}}">
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="lastpercentage">
                        <label for="YearOfJoining">Email :</label>
                        <input type="email" readonly class="ui-autocomplete-input form-control" id="passyear"name="email" value="{{$profile[0]->semail}}">
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="slug" class="control-label">DOB :</label>
                        <input type="text" readonly class="ui-autocomplete-input form-control"name="firstname" value="{{$profile[0]->sdob}}"> 
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="slug" class="control-label">Gender :</label>
                        <input type="text" readonly class="ui-autocomplete-input form-control"name="firstname" value="{{$profile[0]->sgender}}"> 
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="YearOfJoining">Address 1:</label>
                        <input type="text" readonly class="ui-autocomplete-input form-control" id="passyear" required="true"name="mobile" value="{{$profile[0]->saddress1}}">
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="lastpercentage">
                        <label for="YearOfJoining">Address 2 :</label>
                        <input type="email" readonly class="ui-autocomplete-input form-control" id="passyear"name="email" value="{{$profile[0]->saddress1}}">
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="slug" class="control-label">Class :</label>
                        @if(count($class)>0)
                        <input type="text" readonly class="ui-autocomplete-input form-control"name="firstname" value="{{$class[0]->categories}}"> 
                        @else
                        <input type="text" readonly class="ui-autocomplete-input form-control"name="firstname" value="Not Selected"> 
                        @endif
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="slug" class="control-label">Section :</label>
                        @if(count($section)>0)
                        <input type="text" readonly class="ui-autocomplete-input form-control"name="firstname" value="{{$section[0]->section}}">
                        @else
                        <input type="text" readonly class="ui-autocomplete-input form-control"name="firstname" value="Not Selected"> 
                        @endif 
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="YearOfJoining">State :</label>
                        @if(count($state)>0)
                        <input type="text" readonly class="ui-autocomplete-input form-control" id="passyear" required="true"name="mobile" value="{{$state[0]->name}}">
                        @else
                        <input type="text" readonly class="ui-autocomplete-input form-control"name="firstname" value="Not Selected"> 
                        @endif
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="lastpercentage">
                        <label for="YearOfJoining">City :</label>
                        @if(count($city)>0)
                        <input type="email" readonly class="ui-autocomplete-input form-control" id="passyear"name="email" value="{{$city[0]->name}}">
                        @else
                        <input type="text" readonly class="ui-autocomplete-input form-control"name="firstname" value="Not Selected"> 
                        @endif
                    </div>
                </div>
                
               
    <div class="form-row mt-4">
        <div class="col-12">
        <label for="image" class="control-label mb-1">Image :</label><br>
        @if($profile[0]->image!="None")
        <img src="{{asset('studentimages')}}/{{$profile[0]->image}}" width="130px" height="80px" alt="Gallery Image">
        @endif
        </div>
    </div>

                <input type="hidden" name="id" value="{{$profile[0]->id}}">
                
                <div class="button-row d-flex mt-4">
                    <a href="{{url('classteacher/studentdetails')}}">
                    <input type="button" class="btn btn-danger" value="Back"></input>
                    </a>
                    
                </div>
            </div>
        </div>
    
</div>


@endsection
