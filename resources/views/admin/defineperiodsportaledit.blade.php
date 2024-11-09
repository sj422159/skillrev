@extends('admin/layout')
@section('title','Add Periods')
@section('Dashboard_select','active')
@section('container')
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">


<div class="content">
<div class="col-12 col-lg-13 m-auto" style="margin-top: 30px !important;">
            <form class="multisteps-form__form" action="{{url('admin/periods/portal/saveportal')}}" method="post" enctype="multipart/form-data">
              @csrf 
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">
                <div class="multisteps-form__content">
                
                <div class="form-row">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Type :</label>
                        <select id="group" required="true" type="text" class="form-control" name="pclasstypeid">
                          <option value="">Select</option>
                          @foreach($classtypes as $list)
                          @if($pclasstypeid==$list->id){
                          <option selected value="{{$list->id}}">{{$list->classtype}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->classtype}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Schedule :</label>
                        <select id="group" required="true" type="text" class="form-control" name="pid">
                          <option value="">Select</option>
                          @foreach($portals as $list)
                          @if($pid==$list->id){
                          <option selected value="{{$list->id}}">{{$list->portaltype}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->portaltype}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="a">
                        <label for="role">Monday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="pmon">
                          <option value="">Select</option>
                          @foreach($periodnumbers as $list)
                          @if($pmon==$list->id){
                          <option selected value="{{$list->id}}">{{$list->id}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->id}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Tuesday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="ptues">
                          <option value="">Select</option>
                          @foreach($periodnumbers as $list)
                          @if($ptues==$list->id){
                          <option selected value="{{$list->id}}">{{$list->id}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->id}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                </div>


                <div class="form-row mt-4">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Wedesday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="pwednes">
                          <option value="">Select</option>
                          @foreach($periodnumbers as $list)
                          @if($pwednes==$list->id){
                          <option selected value="{{$list->id}}">{{$list->id}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->id}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="a">
                        <label for="role">Thursday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="pthurs">
                          <option value="">Select</option>
                          @foreach($periodnumbers as $list)
                          @if($pthurs==$list->id){
                          <option selected value="{{$list->id}}">{{$list->id}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->id}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Friday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="pfri">
                          <option value="">Select</option>
                          @foreach($periodnumbers as $list)
                          @if($pfri==$list->id){
                          <option selected value="{{$list->id}}">{{$list->id}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->id}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Saturday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="psatur">
                          <option value="">Select</option>
                          @foreach($periodnumbers as $list)
                          @if($psatur==$list->id){
                          <option selected value="{{$list->id}}">{{$list->id}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->id}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                </div>
                  <input type="hidden" name="id" value="{{$id}}">
                  
                  <div class="button-row d-flex mt-4">
                    <input type="submit" class="btn-sm btn btn-success" value="Save"></input>
                    <a href="{{url('admin/periods/portal')}}"><button type="button" class="btn-sm btn btn-danger" style="margin-left:10px !important;">Back</button></a>
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