@extends('admin/layout')
@section('title','Edit Question')
@section('Dashboard_select','active')
@section('container')
<div class="row">
<div class="col-10" style="margin:50px !important">
   <a href="{{url('admin/questions')}}"><button type="submit" class="btn btn-danger" style="margin-bottom:15px !important;">Back</button></a>
 <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title" style="color:#fff;">Edit Question</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{url('admin/question/update')}}" method="post" enctype="multipart/form-data">
              	@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="sector">Question Type</label>
                    <select id="sectors" name="qtype" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                    <option value="">Select</option>
                    @foreach($questiontype as $list)
                     @if($qtype==$list->type)
                      <option selected value="{{$list->type}}">{{$list->type}}</option>
                     @else
                     <option  value="{{$list->type}}">{{$list->type}}</option>
                    @endif
                    @endforeach
                  </select>
                  </div>


                <div class="form-group">
                    <label for="branchname">Question Text</label>
                    <textarea class="form-control" id="mainbranch" placeholder="Enter Question Text" name="qtext" rows="10">{{$question}}</textarea>
                   </div>   


                @if($qtype=="Image" || $qtype=="IMAGE")
                  <div class="form-group">
                    <label for="image" class="control-label mb-1">Question Image</label>
                    <input id="image" name="qimage" type="file" class="form-control"> 
                    @if($qimage!="")
                    <img src="{{asset('questionbankimages')}}/{{$qimage}}" width="130px" height="80px">
                    @endif
                  </div>
                @endif 

                  
                <div class="form-group">
                    <label for="branchname">Choice 1</label>
                    <input type="text" class="form-control" id="mainbranch" placeholder="Enter Choice 1" name="choice1" value="{{$choice1}}">    
                </div>

                @if($qtype=="Image" || $qtype=="IMAGE")
                  <div class="form-group">
                    <label for="image" class="control-label mb-1">Choice 1 Image</label>
                    <input id="image" name="choice1image" type="file" class="form-control"> 
                    @if($choice1image!="")
                    <img src="{{asset('questionbankimages')}}/{{$choice1image}}" width="130px" height="80px">
                    @endif
                  </div>
                @endif 

                 
                <div class="form-group">
                    <label for="branchname">Choice 2</label>
                    <input type="text" class="form-control" id="mainbranch" placeholder="Enter Choice 2" name="choice2" value="{{$choice2}}">
                </div>


                  @if($qtype=="Image" || $qtype=="IMAGE")
                  <div class="form-group">
                    <label for="image" class="control-label mb-1">Choice 2 Image</label>
                    <input id="image" name="choice2image" type="file" class="form-control"> 
                    @if($choice2image!="")
                    <img src="{{asset('questionbankimages')}}/{{$choice2image}}" width="130px" height="80px">
                    @endif
                  </div>
                @endif 

                 

                 <div class="form-group">
                    <label for="branchname">Choice 3</label>
                    <input type="text" class="form-control" id="mainbranch" placeholder="Enter Choice 3" name="choice3" value="{{$choice3}}">
                  </div> 


                  @if($qtype=="Image" || $qtype=="IMAGE")
                  <div class="form-group">
                    <label for="image" class="control-label mb-1">Choice 3 Image</label>
                    <input id="image" name="choice3image" type="file" class="form-control"> 
                    @if($choice3image!="")
                    <img src="{{asset('questionbankimages')}}/{{$choice3image}}" width="130px" height="80px">
                    @endif
                  </div>
                @endif 


                  <div class="form-group">
                    <label for="branchname">Choice 4</label>
                    <input type="text" class="form-control" id="mainbranch" placeholder="Enter Choice 4" name="choice4" value="{{$choice4}}">
                  </div> 



                  @if($qtype=="Image" || $qtype=="IMAGE")
                  <div class="form-group">
                    <label for="image" class="control-label mb-1">Choice 4 Image</label>
                    <input id="image" name="choice4image" type="file" class="form-control"> 
                    @if($choice4image!="")
                    <img src="{{asset('questionbankimages')}}/{{$choice4image}}" width="130px" height="80px">
                    @endif
                  </div>
                @endif 

                 

                  <div class="form-group">
                    <label for="branchname">Right Choices</label>
                    <input type="text" class="form-control" id="mainbranch" placeholder="Enter Right Choices" name="rightchoice" value="{{$RightChoices}}">
                  </div>
                  
                
                  <div class="form-group">
                    <label for="branchname">Difficulty Level</label>
                    <input type="text" class="form-control" id="mainbranch" placeholder="Enter Difficulty Level" name="difficultylevel" value="{{$difficultylevel}}">
                  </div>

                </div>
                 <input type="hidden" name="id" value="{{$id}}">
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
        </div>
    </div>
@endsection
