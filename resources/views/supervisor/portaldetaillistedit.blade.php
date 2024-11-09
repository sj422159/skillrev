@extends('supervisor/layout')
@section('title','Add Subjects')
@section('Dashboard_select','active')
@section('container')
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">

<div class="col-12 col-lg-13 m-2">
            @if(count($available)>0)
            <form class="multisteps-form__form" action="{{url('supervisor/portal/list/savetimetable')}}" method="post" enctype="multipart/form-data">
              @csrf 
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">
                <!-- <h3 class="multisteps-form__title">Define Subjects</h3> -->
                <div class="multisteps-form__content">
                
                <div class="form-row">
                  @if($available[0]->smon=="1")
                  <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Mon :</label>
                        <select id="group" type="text" class="form-control" name="monday">
                          <option value="1">Yes</option>
                       </select>
                  </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class</label>
                <select class="multisteps-form__select form-control" name="mondayclass" id="mainbranch" required="true">
                @foreach($class as $list)
                <option value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Section</label>
                <select class="multisteps-form__select form-control" name="mondaysection" id="mainbranch" required="true">
                <option value="">Select</option>
                @foreach($section as $list)
                <option value="{{$list->id}}">{{$list->section}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="multisteps-form__select form-control" name="mondayperiod" required="true">
                          <option value="">Select</option>
                          @foreach($periods as $list)
                            @if($portal[0]->pmon>=$list->id)
                            <option value="{{$list->id}}">{{$list->id}}</option>
                            @endif
                          @endforeach
                </select>
                </div>
                    @else
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Mon :</label>
                        <select class="form-control" disabled>
                          <option>No</option>
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Class</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Section</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                       </select>
                    </div>
                  @endif
                </div>

                <div class="form-row mt-1">
                  @if($available[0]->stues=="1")
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Tue :</label>
                        <select id="group" type="text" class="form-control" name="tuesday">
                          <option value="2">Yes</option>
                       </select>
                    </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class</label>
                <select class="multisteps-form__select form-control" name="tuesdayclass" id="mainbranch" required="true">
                @foreach($class as $list)
                <option  value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Section</label>
                <select class="multisteps-form__select form-control" name="tuesdaysection" id="mainbranch" required="true">
                <option value="">Select</option>
                @foreach($section as $list)
                <option  value="{{$list->id}}">{{$list->section}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="multisteps-form__select form-control" name="tuesdayperiod" required="true">
                          <option value="">Select</option>
                          @foreach($periods as $list)
                            @if($portal[0]->ptues>=$list->id)
                            <option value="{{$list->id}}">{{$list->id}}</option>
                            @endif
                          @endforeach
                </select>
                </div>
                  @else
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Tue :</label>
                        <select class="form-control" disabled>
                          <option>No</option>
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Class</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Section</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                       </select>
                    </div>
                  @endif
                </div>

                <div class="form-row mt-1">
                  @if($available[0]->swednes=="1")
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Wed :</label>
                        <select id="group" type="text" class="form-control" name="wednesday">
                          <option value="3">Yes</option>
                       </select>
                    </div>
                      <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class</label>
                <select class="multisteps-form__select form-control" name="wednesdayclass" id="mainbranch" required="true">
                @foreach($class as $list)
                <option  value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Section</label>
                <select class="multisteps-form__select form-control" name="wednesdaysection" id="mainbranch" required="true">
                <option value="">Select</option>
                @foreach($section as $list)
                <option  value="{{$list->id}}">{{$list->section}}</option>
                @endforeach
                </select>
                </div> 
                <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="multisteps-form__select form-control" name="wednesdayperiod" required="true">
                          <option value="">Select</option>
                          @foreach($periods as $list)
                            @if($portal[0]->pwednes>=$list->id)
                            <option value="{{$list->id}}">{{$list->id}}</option>
                            @endif
                          @endforeach
                </select>
                </div>
                    @else
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Wednes :</label>
                        <select class="form-control" disabled>
                          <option>No</option>
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Class</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Section</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                       </select>
                    </div>
                  @endif  
                </div>

                <div class="form-row mt-1">
                  @if($available[0]->sthurs=="1") 
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Thur :</label>
                        <select id="group" type="text" class="form-control" name="thursday">
                          <option value="4">Yes</option>
                       </select>
                    </div>
                      <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class</label>
                <select class="multisteps-form__select form-control" name="thursdayclass" id="mainbranch" required="true">
                @foreach($class as $list)
                <option  value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Section</label>
                <select class="multisteps-form__select form-control" name="thursdaysection" id="mainbranch" required="true">
                <option value="">Select</option>
                @foreach($section as $list)
                <option  value="{{$list->id}}">{{$list->section}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="multisteps-form__select form-control" name="thursdayperiod" required="true">
                          <option value="">Select</option>
                          @foreach($periods as $list)
                            @if($portal[0]->pthurs>=$list->id)
                            <option value="{{$list->id}}">{{$list->id}}</option>
                            @endif
                          @endforeach
                </select>
                </div>
                    @else
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Thur :</label>
                        <select class="form-control" disabled>
                          <option>No</option>
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Class</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Section</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                       </select>
                    </div>
                  @endif
                </div>


                <div class="form-row mt-1">
                  @if($available[0]->sfri=="1") 
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Fri :</label>
                        <select id="group" type="text" class="form-control" name="friday">
                          <option value="5">Yes</option>
                       </select>
                    </div>
                      <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class</label>
                <select class="multisteps-form__select form-control" name="fridayclass" id="mainbranch" required="true">
                @foreach($class as $list)
                <option  value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Section</label>
                <select class="multisteps-form__select form-control" name="fridaysection" id="mainbranch" required="true">
                <option value="">Select</option>
                @foreach($section as $list)
                <option  value="{{$list->id}}">{{$list->section}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="multisteps-form__select form-control" name="fridayperiod" required="true">
                          <option value="">Select</option>
                          @foreach($periods as $list)
                            @if($portal[0]->pfri>=$list->id)
                            <option value="{{$list->id}}">{{$list->id}}</option>
                            @endif
                          @endforeach
                </select>
                </div>
                    @else
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Fri :</label>
                        <select class="form-control" disabled>
                          <option>No</option>
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Class</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Section</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                       </select>
                    </div>
                  @endif
                </div>


                <div class="form-row mt-1">
                  @if($available[0]->ssatur=="1")
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Sat :</label>
                        <select id="group" type="text" class="form-control" name="saturday">
                          <option value="6">Yes</option>
                       </select>
                    </div>
                      <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class</label>
                <select class="multisteps-form__select form-control" name="saturdayclass" id="mainbranch" required="true">
                @foreach($class as $list)
                <option  value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Section</label>
                <select class="multisteps-form__select form-control" name="saturdaysection" id="mainbranch" required="true">
                <option value="">Select</option>
                @foreach($section as $list)
                <option  value="{{$list->id}}">{{$list->section}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="multisteps-form__select form-control" name="saturdayperiod" required="true">
                          <option value="">Select</option>
                          @foreach($periods as $list)
                            @if($portal[0]->psatur>=$list->id)
                            <option value="{{$list->id}}">{{$list->id}}</option>
                            @endif
                          @endforeach
                </select>
                </div>
                    @else
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Satur :</label>
                        <select class="form-control" disabled>
                          <option>No</option>
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Class</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Section</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-1 mt-sm-0">
                        <label for="role">Period :</label>
                        <select class="form-control" disabled>
                        <option>Not Available</option>
                       </select>
                    </div>
                  @endif
                </div>

                  <input type="hidden" name="typeid" value="{{$typeid}}">
                  <input type="hidden" name="portalid" value="{{$portalid}}">
                  <input type="hidden" name="profileid" value="{{$profileid}}">
                  <input type="hidden" name="subjectid" value="{{$subjectid}}">

                  <div class="button-row d-flex mt-2">
                    @if($available[0]->smon=="2" && $available[0]->stues=="2" && $available[0]->swednes=="2" && $available[0]->sfri=="2" && $available[0]->ssatur=="2")
                    <button type="button" class="btn-sm btn btn-primary" disabled>Assign</button>
                    @else
                    <input type="submit" class="btn-sm btn btn-primary" value="Assign"></input>
                    @endif
                  </div>
                </div>
              </div>
              </form>
              @endif
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