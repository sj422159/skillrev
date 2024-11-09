@extends('supervisor/layout')
@section('title','Add Competition')
@section('ChildBranch_select','active')
@section('container')
<div class="row">
<div class="col-10" style="margin:10px !important">
 <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Add Competition</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{url('groupmanager/competition/savecompetition')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                <div class="form-row">
                  <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="jobskill">Manager</label>
                        <select id="mainbranch" name="mid" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                          <option value="">Select</option>
                          @foreach($managers as $list)
                            @if($mid==$list->id)
                              <option selected value="{{$list->id}}">{{$list->mname}}</option>
                            @else
                              <option value="{{$list->id}}">{{$list->mname}}</option>
                            @endif
                          @endforeach 
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="jobrole">Competition Name</label>
                    <input type="text" class="form-control" id="jobrole" placeholder="Enter Name" name="competitionname" value="{{$competitionname}}" required="true">
                    </div>
                    <?php $date= date('Y-m-d', strtotime('+1 days')); ?>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">From </label>
                      <input type="date" class="multisteps-form__input form-control m-input date-picker" id="from" placeholder="Date Of Birth" oninput="getInputValue();" required="true" min={{$date}} data-val-required="please Select Dob" name="fromdate" value="{{$fromdate}}" id="DateOfBirthValue">
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">To </label>
                      <input type="date" class="multisteps-form__input form-control m-input date-picker" id="to" disabled="true" placeholder="Date Of Birth" min={{$date}} value="{{$todate}}" required="true" data-val-required="please Select Dob" name="todate" id="DateOfBirthValue">
                    </div>
                  </div>

                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="sector">Subtitle</label>
                        <textarea class="form-control" rows="5" name="subtitle" maxlength="150" placeholder="Please Provide Subtitle Upto 150 characters" value="" required="true">{{$subtitle}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="sector">Description</label>
                        <textarea class="form-control" rows="5" name="description" maxlength="450" placeholder="Please Provide Description Upto 250 characters" required="true">{{$description}}</textarea>
                    </div>
                  </div>


                    
                 
                    <div class="form-row mt-4">
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                      <label for="image" class="control-label mb-1">Image</label>
                      @if($id>0)
                        <input id="image" name="image" type="file" class="form-control">
                        <img src="{{asset('competitionimages')}}/{{$image}}" width="130px" height="80px"alt="">
                      @else
                        <input id="image" name="image" required="true" type="file" class="form-control">
                      @endif 
        
                    </div> 
                     
                  </div>
           
                 <input type="hidden" name="id" value="{{$id}}">      
                <div class="card-footer mt-4">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
              </form>
            </div>
        </div>
    </div>


<script type="text/javascript">
function getInputValue(){
  var from = document.getElementById("from").value;
  var to = document.getElementById("to");
  to.min = from;
  to.disabled=false;   
}
</script>

@endsection